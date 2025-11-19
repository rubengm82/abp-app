<?php

namespace App\Http\Controllers;

use App\Models\Center;
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
    public function index()
    {
        $complementaryServices = ComplementaryService::all();
        return view('components.contents.complementaryservices.complementaryServicesList', compact('complementaryServices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $centers = Center::all();

        return view('components.contents.complementaryservices.complementaryServiceForm', compact('centers'));
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
            'center_id' => 'required|exists:centers,id'
        ]);

        ComplementaryService::create([
            'service_type' => $request->input('service_type'),
            'service_responsible' => $request->input('service_responsible'),
            'start_date' => $request->input('start_date'),
            'center_id' => $request->input('center_id'),
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
        $centers = Center::all();

        return view('components.contents.complementaryservices.complementaryServiceEdit', compact('complementaryService','centers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ComplementaryService $complementaryService)
    {
        $complementaryService->update($request->all());
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


    //// DOCUMENTS ////
    // Upload Document to server
    public function complementaryservice_document_add(Request $request, ComplementaryService $complementaryService)
    {
        $request->validate([
            'file' => 'required|file|max:10240', 
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
        $services = ComplementaryService::with('center')->get(); // Cargamos también el centro

        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = "serveis_complementaris_{$timestamp}.csv";

        $handle = fopen($filename, 'w+');

        // Cabecera del CSV
        fputcsv($handle, ['Tipus de Servei', 'Centre','Responsable', 'Data d\'inici']);

        foreach ($services as $service) {
            fputcsv($handle, [
                $service->service_type ?? 'No especificat',
                $service->center ? $service->center->name : 'No assignat',
                $service->service_responsible ?? 'No especificat',
                $service->start_date ? \Carbon\Carbon::parse($service->start_date)->format('d/m/Y') : 'No especificada',
            ]);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }

}
