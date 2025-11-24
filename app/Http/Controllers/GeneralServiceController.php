<?php

namespace App\Http\Controllers;

use App\Models\GeneralService;
use App\Models\NotesComponent;
use App\Models\DocumentComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GeneralServiceController extends Controller
{
    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    public function show(string $service_type)
    {
        $generalService = GeneralService::where('center_id', Auth::user()->center_id)
                             ->where('service_type', $service_type)
                             ->firstOrFail();
        return view('components.contents.generalservice.generalServiceShow')
           ->with('service', $generalService);
    }

    //// DOCUMENTS ////
    /**
     * Upload Document to server
     */
    public function general_service_document_add(Request $request, GeneralService $generalService)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
            'document_type' => 'nullable|in:Altres',
        ]);

        $file = $request->file('file');

        // File name: original_name + fecha
        $timestamp = now()->format('Ymd_His');
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $fileName = $originalName . '_' . $timestamp . '.' . $extension;

        $filePath = $file->storeAs('documents/general_services', $fileName, 'public');

        $generalService->documents()->create([
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

    /**
     * Download Document from server
     */
    public function general_service_document_download(DocumentComponent $document)
    {
        $path = storage_path('app/public/' . $document->file_path);

        if (file_exists($path)) {
            return response()->download($path, $document->original_name);
        }

        return back()->with('error', 'El document no existeix.');
    }

    /**
     * Delete Document from server
     */
    public function general_service_document_delete(DocumentComponent $document)
    {
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return back()->with('success', 'Document eliminat correctament!');
    }

    //// NOTES ////
    /**
     * Add note to general service
     */
    public function general_service_note_add(Request $request, GeneralService $generalService)
    {
        $request->validate([
            'notes' => 'required|string|max:1000',
            'restricted' => 'nullable'
        ]);

        // Convert checkbox value: "on" or presence = 1, absence = 0
        $restricted = $request->has('restricted') && $request->input('restricted') !== null ? 1 : 0;

        $generalService->notes()->create([
            'notes' => $request->input('notes'),
            'created_by_professional_id' => Auth::id(),
            'restricted' => $restricted
        ]);

        return redirect()->route('general_service_show', $generalService->id . '#notes-section')
                         ->with('success', 'Nota afegida correctament!');
    }

    /**
     * Update note
     */
    public function general_service_note_update(Request $request, NotesComponent $note)
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

        return redirect()->route('general_service_show', $note->noteable->id . '#notes-section')
                         ->with('success', 'Nota actualitzada correctament!');
    }

    /**
     * Delete note
     */
    public function general_service_note_delete(NotesComponent $note)
    {
        $note->delete();

        return redirect()->route('general_service_show', $note->noteable->id . '#notes-section')
                         ->with('success', 'Nota eliminada correctament!');
    }
}

