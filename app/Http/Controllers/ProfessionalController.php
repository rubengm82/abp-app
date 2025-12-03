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

class ProfessionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $status = 1)
    {
        $query = Professional::query()
            ->where('status', $status)
            ->where('center_id', Auth::user()->center->id);

        if ($search = $request->get('search')) {

            $query
            ->whereAny(['name', 'surname1', 'surname2', 'key_code', 'dni', 'address', 'role', 'phone', 'email','employment_status'], 'like', "%{$search}%");
        }

        $professionals = $query->paginate(10)->appends(['search' => $search]);

        $isDeactivated = ($status == 0);

        return $request->ajax()
            ? view('components.contents.professional.tables.professionalsListTable', with(['professionals' => $professionals, 'isDeactivated' => $isDeactivated]))->render()
            : view("components.contents.professional.professionalsList", with(['professionals' => $professionals, 'isDeactivated' => $isDeactivated]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("components.contents.professional.professionalForm");
    }

    /**
     * Store a newly created resource in storage.
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

        // Create professional
        $professional = Professional::create([
            'center_id' => Auth::user()->center_id, //assign the center_id of the logged in user
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
            'password' => $validated['password'], // Will be hashed in the model booted()
            'locker_num' => $validated['locker_num'] ?? null,
            'key_code' => $validated['key_code'] ?? null,
            'status' => 1,
        ]);

        return redirect()->route('professionals_list')->with('success', 'Professional afegit correctament!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $professional = Professional::findOrFail($id);

        $shirtSize = MaterialAssignment::getLatestShirtSize($professional->id);
        $pantsSize = MaterialAssignment::getLatestPantsSize($professional->id);
        $shoeSize = MaterialAssignment::getLatestShoeSize($professional->id);

        return view('components.contents.professional.professionalShow')->with([
            'professional' => $professional,
            'shirtSize' => $shirtSize,
            'pantsSize' => $pantsSize,
            'shoeSize' => $shoeSize,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $professional = Professional::findOrFail($id);
        return view("components.contents.professional.professionalEdit")->with('professional', $professional);
    }

    /**
     * Update the specified resource in storage.
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
            // center_id is not modified, it remains the existing one
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

        // Only include password if it has content
        if (!empty($validated['password'])) {
            $updateData['password'] = $validated['password'];
        }

        $professional->update($updateData);

        // Update associated user if exists
        // if ($professional->userAccount && $validated['password']) {
        //     $professional->userAccount->update([
        //         'password' => Hash::make($validated['password'])
        //     ]);
        // }

        return redirect()->route('professionals_list')->with('success', 'Professional actualitzat correctament!');
    }

    /**
     * Activate Status
     */
    public function activateStatus(Request $request, String $professional_id)
    {
        $professional = Professional::findOrFail($professional_id);
        $professional->update(['status' => 1, 'employment_status' => 'Actiu']);
        return redirect()->route('professionals_desactivated_list')->with('success', 'Professional activat correctament!');
    }

    /**
     * Deactivate Status
     */
    public function desactivateStatus(Request $request, String $professional_id)
    {
        $professional = Professional::findOrFail($professional_id);
        $professional->update(['status' => 0, 'employment_status' => 'No Contractat']);
        return redirect()->route('professionals_list')->with('success', 'Professional desactivat correctament!');
    }


    /**
     * Download CSV by status
     */
    public function downloadCSV(int $statusParam)
    {
        $professionals = Professional::with('center')->where('status', $statusParam)->where('center_id', Auth::user()->center->id)->get();

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
     * Download CSV with material assignments
     */
    public function downloadCSVMaterialAssignments()
    {
        $professionals = Professional::where('status', 1)->where('center_id', Auth::user()->center->id)->get();
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


    //// DOCUMENTS ////
    // Upload Document to server
    public function professional_document_add(Request $request, Professional $professional)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
            'document_type' => 'nullable|string',
        ]);

        $file = $request->file('file');

        // File name: original_name + fecha
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
            'document_type' => $request->input('document_type'),
        ]);

        return back()->with('success', 'Document pujat correctament!');
    }


    // Download Document to server
    public function professional_document_download(DocumentComponent $document)
    {
        $path = storage_path('app/public/' . $document->file_path);

        if (file_exists($path)) {
            return response()->download($path, $document->original_name);
        }

        return back()->with('error', 'El document no existeix.');
    }

    // Delete Document to server
    public function professional_document_delete(DocumentComponent $document)
    {
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return back()->with('success', 'Document eliminat correctament!');
    }
    

    //// NOTES ////
    public function professional_note_add(Request $request, Professional $professional)
    {
        mainlog::log("Iniciando professional_note_add en ProfessionalController");
        mainlog::log("restricted:". $request->input('restricted'));
        $request->validate([
            'notes' => 'required|string|max:1000',
            'restricted' => 'nullable'
        ]);
        mainlog::log("Validación pasada de datos en professional_note_add en ProfessionalController");

        // Convert checkbox value: "on" or presence = 1, absence = 0
        $restricted = $request->has('restricted') && $request->input('restricted') !== null ? 1 : 0;

        $professional->notes()->create([
            'notes' => $request->input('notes'),
            'created_by_professional_id' => Auth::id(),
            'restricted' => $restricted
        ]);
        mainlog::log("Nota añadida correctamente en professional_note_add en ProfessionalController");
        return redirect()->route('professional_show', $professional->id . '#notes-section')
                         ->with('success', 'Nota afegida correctament!');
    }

    public function professional_note_update(Request $request, NotesComponent $note)
    {
        $request->validate([
            'notes' => 'required|string|max:1000',
            'restricted' => 'nullable'
        ]);

        // Convert checkbox value: "on" or presence = 1, absence = 0
        $restricted = $request->has('restricted') && $request->input('restricted') !== null ? 1 : 0;

        $note->update([
            'notes' => $request->input('notes'),
            'restricted' => $restricted
        ]);

        return redirect()->route('professional_show', $note->noteable->id . '#notes-section')
                         ->with('success', 'Nota actualitzada correctament!');
    }

    public function professional_note_delete(NotesComponent $note)
    {
        $note->delete();

        return redirect()->route('professional_show', $note->noteable->id . '#notes-section')
                         ->with('success', 'Nota eliminada correctament!');
    }

}
