<?php

namespace App\Http\Controllers;

use App\Models\Professional;
use App\Models\MaterialAssignment;
use App\Models\DocumentComponent;
use App\Models\NotesComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Helpers\mainlog;

/**
 * Controlador para la gestión de profesionales.
 *
 * Maneja las operaciones CRUD y acciones adicionales como activación,
 * desactivación, descarga de CSV y gestión de documentos y notas.
 */
class ProfessionalController extends Controller
{
    /**
     * Muestra un listado de los profesionales según el estado indicado.
     *
     * @param Request $request
     * @param int     $status Estado de los profesionales (1 = activos, 0 = inactivos)
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request, $status = 1)
    {
        $query = Professional::query()
            ->where('status', $status)
            ->where('center_id', Auth::user()->center->id);

        if ($search = $request->get('search')) {
            $query->whereAny(
                ['name', 'surname1', 'surname2', 'key_code', 'dni', 'address', 'role', 'phone', 'email', 'employment_status'],
                'like',
                "%{$search}%"
            );
        }

        $professionals = $query->get();
        $isDeactivated = ($status == 0);

        return $request->ajax()
            ? view('components.contents.professional.tables.professionalsListTable', compact('professionals', 'isDeactivated'))->render()
            : view('components.contents.professional.professionalsList', compact('professionals', 'isDeactivated'));
    }

    /**
     * Muestra el formulario para crear un nuevo profesional.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('components.contents.professional.professionalForm');
    }

    /**
     * Almacena un nuevo profesional en la base de datos.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname1' => 'required|string|max:255',
            'surname2' => 'nullable|string|max:255',
            'dni' => 'required|string|max:20|unique:professionals,dni',
            'role' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|max:255|unique:professionals,email',
            'address' => 'nullable|string|max:500',
            'employment_status' => 'nullable|string|max:50',
            'cvitae' => 'nullable|string',
            'user' => 'required|string|max:100|unique:professionals,user',
            'password' => 'required|string|min:4',
            'locker_num' => 'nullable|string|max:50',
            'key_code' => 'nullable|string|max:50',
        ]);

        $professional = Professional::create([
            'center_id' => Auth::user()->center_id,
            'role' => $validated['role'] ?? null,
            'name' => $validated['name'],
            'surname1' => $validated['surname1'],
            'surname2' => $validated['surname2'] ?? null,
            'dni' => $validated['dni'],
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'],
            'address' => $validated['address'] ?? null,
            'employment_status' => $validated['employment_status'] ?? 'Actiu',
            'cvitae' => $validated['cvitae'] ?? null,
            'user' => $validated['user'],
            'password' => $validated['password'],
            'locker_num' => $validated['locker_num'] ?? null,
            'key_code' => $validated['key_code'] ?? null,
            'status' => 1,
        ]);

        return redirect()->route('professionals_list')->with('success', 'Professional afegit correctament!');
    }

    /**
     * Muestra los detalles de un profesional específico.
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        $professional = Professional::findOrFail($id);

        $shirtSize = MaterialAssignment::getLatestShirtSize($professional->id);
        $pantsSize = MaterialAssignment::getLatestPantsSize($professional->id);
        $shoeSize = MaterialAssignment::getLatestShoeSize($professional->id);

        return view('components.contents.professional.professionalShow', compact('professional', 'shirtSize', 'pantsSize', 'shoeSize'));
    }

    /**
     * Muestra el formulario para editar un profesional específico.
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id)
    {
        $professional = Professional::findOrFail($id);
        return view('components.contents.professional.professionalEdit', compact('professional'));
    }

    /**
     * Actualiza un profesional específico en la base de datos.
     *
     * @param Request $request
     * @param string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id)
    {
        $professional = Professional::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname1' => 'required|string|max:255',
            'surname2' => 'nullable|string|max:255',
            'dni' => 'required|string|max:20|unique:professionals,dni,' . $id,
            'role' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|max:255|unique:professionals,email,' . $id,
            'address' => 'nullable|string|max:500',
            'employment_status' => 'nullable|string|max:50',
            'cvitae' => 'nullable|string',
            'user' => 'required|string|max:100|unique:professionals,user,' . $id,
            'password' => 'nullable|string|min:4',
            'locker_num' => 'nullable|string|max:50',
            'key_code' => 'nullable|string|max:50',
        ]);

        $updateData = [
            'role' => $validated['role'] ?? $professional->role,
            'name' => $validated['name'],
            'surname1' => $validated['surname1'],
            'surname2' => $validated['surname2'] ?? $professional->surname2,
            'dni' => $validated['dni'],
            'phone' => $validated['phone'] ?? $professional->phone,
            'email' => $validated['email'],
            'address' => $validated['address'] ?? $professional->address,
            'employment_status' => $validated['employment_status'] ?? $professional->employment_status,
            'cvitae' => $validated['cvitae'] ?? $professional->cvitae,
            'user' => $validated['user'],
            'locker_num' => $validated['locker_num'] ?? $professional->locker_num,
            'key_code' => $validated['key_code'] ?? $professional->key_code,
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = $validated['password'];
        }

        $professional->update($updateData);

        return redirect()->route('professionals_list')->with('success', 'Professional actualitzat correctament!');
    }

    /**
     * Activa el estado de un profesional.
     *
     * @param Request $request
     * @param string  $professional_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activateStatus(Request $request, string $professional_id)
    {
        $professional = Professional::findOrFail($professional_id);
        $professional->update([
            'status' => 1,
            'employment_status' => 'Actiu'
        ]);

        return redirect()->route('professionals_desactivated_list')->with('success', 'Professional activat correctament!');
    }

    /**
     * Desactiva el estado de un profesional.
     *
     * @param Request $request
     * @param string  $professional_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function desactivateStatus(Request $request, string $professional_id)
    {
        $professional = Professional::findOrFail($professional_id);
        $professional->update(['status' => 0, 'employment_status' => 'No Contractat']);

        return redirect()->route('professionals_list')->with('success', 'Professional desactivat correctament!');
    }

    /**
     * Descarga un archivo CSV con los profesionales según su estado.
     *
     * @param int $statusParam
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function downloadCSV(int $statusParam)
    {
        $professionals = Professional::with('center')
            ->where('status', $statusParam)
            ->where('center_id', Auth::user()->center->id)
            ->get();

        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = $statusParam == 1 ? "professionals_actius_{$timestamp}.csv" : "professionals_no_actius_{$timestamp}.csv";

        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['ID', 'Centre', 'Taquilla', 'Codi', 'Nom', 'Primer cognom', 'Segon cognom', 'DNI', 'Adreça', 'Rol', 'Telèfon', 'Email', 'Estat']);

        foreach ($professionals as $professional) {
            fputcsv($handle, [
                $professional->id,
                $professional->center ? $professional->center->name : 'No assignat',
                $professional->locker_num,
                $professional->key_code,
                $professional->name,
                $professional->surname1,
                $professional->surname2,
                $professional->dni,
                $professional->address,
                $professional->role,
                $professional->phone,
                $professional->email,
                $professional->status == 1 ? 'Actiu' : 'No actiu',
            ]);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }

    /**
     * Descarga un archivo CSV con las asignaciones de material de los profesionales.
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function downloadCSVMaterialAssignments()
    {
        $professionals = Professional::where('status', 1)
            ->where('center_id', Auth::user()->center->id)
            ->get();

        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = "professionals_taquilles_{$timestamp}.csv";

        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['ID', 'Taquilla', 'Nom', 'Primer cognom', 'Segon cognom', 'Samarreta', 'Pantaló', 'Sabata']);

        foreach ($professionals as $professional) {
            $shirtSize = MaterialAssignment::getLatestShirtSize($professional->id);
            $pantsSize = MaterialAssignment::getLatestPantsSize($professional->id);
            $shoeSize = MaterialAssignment::getLatestShoeSize($professional->id);

            fputcsv($handle, [
                $professional->id,
                $professional->locker_num,
                $professional->name,
                $professional->surname1,
                $professional->surname2,
                $shirtSize ?: 'No assignat',
                $pantsSize ?: 'No assignat',
                $shoeSize ?: 'No assignat',
            ]);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }

    /**
     * Agrega un documento a un profesional.
     *
     * @param Request    $request
     * @param Professional $professional
     * @return \Illuminate\Http\RedirectResponse
     */
    public function professional_document_add(Request $request, Professional $professional)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
            'document_type' => 'nullable|string',
        ]);

        $file = $request->file('file');

        $timestamp = now()->format('Ymd_His');
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $fileName = $originalName . '_' . $timestamp . '.' . $extension;

        $filePath = $file->storeAs('documents/professionals', $fileName, 'public');

        $professional->documents()->create([
            'file_name' => $fileName,
            'original_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'uploaded_by_professional_id' => Auth::user()->id,
            'document_type' => $request->input('document_type') ?: 'Altres',
        ]);

        return back()->with('success', 'Document pujat correctament!');
    }

    /**
     * Descarga un documento de un profesional.
     *
     * @param DocumentComponent $document
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\RedirectResponse
     */
    public function professional_document_download(DocumentComponent $document)
    {
        $path = storage_path('app/public/' . $document->file_path);

        if (file_exists($path)) {
            return response()->download($path, $document->original_name);
        }

        return back()->with('error', 'El document no existeix.');
    }

    /**
     * Elimina un documento de un profesional.
     *
     * @param DocumentComponent $document
     * @return \Illuminate\Http\RedirectResponse
     */
    public function professional_document_delete(DocumentComponent $document)
    {
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return back()->with('success', 'Document eliminat correctament!');
    }

    /**
     * Agrega una nota a un profesional.
     *
     * @param Request    $request
     * @param Professional $professional
     * @return \Illuminate\Http\RedirectResponse
     */
    public function professional_note_add(Request $request, Professional $professional)
    {
        $request->validate([
            'notes' => 'required|string|max:1000',
            'restricted' => 'nullable',
        ]);

        $restricted = $request->has('restricted') && $request->input('restricted') !== null ? 1 : 0;

        $professional->notes()->create([
            'notes' => $request->input('notes'),
            'created_by_professional_id' => Auth::id(),
            'restricted' => $restricted,
        ]);

        return redirect()->route('professional_show', $professional->id . '#notes-section')
            ->with('success', 'Nota afegida correctament!');
    }

    /**
     * Actualiza una nota de un profesional.
     *
     * @param Request       $request
     * @param NotesComponent $note
     * @return \Illuminate\Http\RedirectResponse
     */
    public function professional_note_update(Request $request, NotesComponent $note)
    {
        $request->validate([
            'notes' => 'required|string|max:1000',
            'restricted' => 'nullable',
        ]);

        $restricted = $request->has('restricted') && $request->input('restricted') !== null ? 1 : 0;

        $note->update([
            'notes' => $request->input('notes'),
            'restricted' => $restricted,
        ]);

        return redirect()->route('professional_show', $note->noteable->id . '#notes-section')
            ->with('success', 'Nota actualitzada correctament!');
    }

    /**
     * Elimina una nota de un profesional.
     *
     * @param NotesComponent $note
     * @return \Illuminate\Http\RedirectResponse
     */
    public function professional_note_delete(NotesComponent $note)
    {
        $note->delete();

        return redirect()->route('professional_show', $note->noteable->id . '#notes-section')
            ->with('success', 'Nota eliminada correctament!');
    }
}
