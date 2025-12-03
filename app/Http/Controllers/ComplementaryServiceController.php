<?php

namespace App\Http\Controllers;

use App\Models\ComplementaryService;
use App\Models\DocumentComponent;
use App\Models\NotesComponent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ComplementaryServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $status = 1)
    {
        $query = ComplementaryService::query()->where('center_id', Auth::user()->center_id)->where('status', $status);

        if ($search = $request->get('search')) {
            $query->where(function($q) use ($search) {
                $q->where('service_type', 'like', "%{$search}%")
                ->orWhere('service_responsible', 'like', "%{$search}%")
                ->orWhere('start_date', 'like', "%{$search}%");
            })
            ->orWhereHas('center', fn($q) =>
                $q->where('name', 'like', "%{$search}%")
            );
        }

        $complementaryServices = $query->orderBy('start_date', 'desc')
                                    ->paginate(10)
                                    ->appends(['search' => $search]);

        $isDeactivated = ($status == 0);

        return $request->ajax()
            ? view('components.contents.complementaryservices.tables.complementaryServicesListTable', compact('complementaryServices', 'isDeactivated'))->render()
            : view('components.contents.complementaryservices.complementaryServicesList', compact('complementaryServices', 'isDeactivated'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('components.contents.complementaryservices.complementaryServiceForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_type' => 'required|string|max:255',
            'service_responsible' => 'required|string',
            'start_date' => 'required',
            'end_date' => 'nullable',
        ]);

        ComplementaryService::create([
            'service_type' => $request->input('service_type'),
            'service_responsible' => $request->input('service_responsible'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'center_id' => Auth::user()->center_id, //assign the center_id of the logged in user
        ]);

        return redirect()->route('complementaryservices_list')->with('success', 'Servei Complenmentari creat correctament.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ComplementaryService $complementaryService)
    {
        return view('components.contents.complementaryservices.complementaryServiceShow', compact('complementaryService'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ComplementaryService $complementaryService)
    {
        return view('components.contents.complementaryservices.complementaryServiceEdit', compact('complementaryService'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ComplementaryService $complementaryService)
    {
        $validated = $request->validate([
            'service_type' => 'required|string|max:255',
            'service_responsible' => 'required|string',
            'start_date' => 'required',
            'end_date' => 'nullable',
        ]);

        $complementaryService->update([
            'service_type' => $validated['service_type'],
            'service_responsible' => $validated['service_responsible'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            // center_id is not modified, it remains the existing one
        ]);

        return redirect()->route('complementaryservices_list')->with('success', 'Servei Complenmentari actualitzat correctament!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ComplementaryService $complementaryService)
    {
        $complementaryService->delete();
        return redirect()->route('complementaryservices_list')->with('success', 'Servei Complenmentari eliminat correctament.');
    }

    /**
     * Activate Status the specified resource in storage.
     */
    public function activateStatus(Request $request, ComplementaryService $complementaryService)
    {
        $complementaryService->update(['status' => 1]);

        return redirect()->route('complementaryservices_desactivated_list')->with('success', 'Servei Complementari activat correctament!');
    }

    /**
     * Desactivate Status the specified resource in storage.
     */
    public function desactivateStatus(Request $request, ComplementaryService $complementaryService)
    {
        $complementaryService->update(['status' => 0]);

        return redirect()->route('complementaryservices_list')->with('success', 'Servei Complementari desactivat correctament!');
    }

    //// DOCUMENTS ////
    // Upload Document to server
    public function complementaryservice_document_add(Request $request, ComplementaryService $complementaryService)
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

        $filePath = $file->storeAs('documents/complementaryservices', $fileName, 'public');

        $complementaryService->documents()->create([
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
    public function complementaryservice_document_download(DocumentComponent $document)
    {
        $path = storage_path('app/public/' . $document->file_path);

        if (file_exists($path)) {
            return response()->download($path, $document->original_name);
        }

        return back()->with('error', 'El document no existeix.');
    }

    // Delete Document to server
    public function complementaryservice_document_delete(DocumentComponent $document)
    {
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return back()->with('success', 'Document eliminat correctament!');
    }
    

    //// NOTES ////
    public function complementaryservice_note_add(Request $request, ComplementaryService $complementaryService)
    {
        $request->validate([
            'notes' => 'required|string|max:1000',
            'restricted' => 'nullable'
        ]);

        // Convert checkbox value: "on" or presence = 1, absence = 0
        $restricted = $request->has('restricted') && $request->input('restricted') !== null ? 1 : 0;

        $complementaryService->notes()->create([
            'notes' => $request->input('notes'),
            'created_by_professional_id' => Auth::id(),
            'restricted' => $restricted
        ]);
        return redirect()->route('complementaryservice_show', $complementaryService->id . '#notes-section')
                         ->with('success', 'Nota afegida correctament!');
    }

    public function complementaryservice_note_update(Request $request, NotesComponent $note)
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

        return redirect()->route('complementaryservice_show', $note->noteable->id . '#notes-section')
                         ->with('success', 'Nota actualitzada correctament!');
    }

    public function complementaryservice_note_delete(NotesComponent $note)
    {
        $note->delete();

        return redirect()->route('complementaryservice_show', $note->noteable->id . '#notes-section')
                         ->with('success', 'Nota eliminada correctament!');
    }

    /**
     * Download CSV
     */
    public function downloadCSV()
    {
        $services = ComplementaryService::with('center')
        ->where('center_id', Auth::user()->center->id)
        ->orderBy('start_date', 'desc')
        ->get();

        $timestamp = now()->format('Y-m-d_H-i-s');
        $filepath = sys_get_temp_dir() . "/serveis_complementaris_{$timestamp}.csv";

        $handle = fopen($filepath, 'w+');

        fputcsv($handle, ['Tipus de Servei', 'Centre', 'Responsable', 'Data d\'inici']);

        foreach ($services as $service) {
            fputcsv($handle, [
                $service->service_type ?? 'No especificat',
                $service->center ? $service->center->name : 'No assignat',
                $service->service_responsible ?? 'No especificat',
                $service->start_date ? \Carbon\Carbon::parse($service->start_date)->format('d/m/Y') : 'No especificada',
            ]);
        }

        fclose($handle);

        return response()->download($filepath)->deleteFileAfterSend(true);
    }

}
