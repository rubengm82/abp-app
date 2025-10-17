<?php

namespace App\Http\Controllers;

use App\Models\CenterDocument;
use App\Models\Center;
use App\Models\Professional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Helpers\mainlog;

class CenterDocumentController extends Controller
{
    /**
     * Store a newly created document in storage.
     */
    public function store(Request $request, Center $center)
    {
        mainlog::log("Iniciando store en CenterDocumentController para center_id: " . $center->id);
        
        try {
            $request->validate([
                'document' => 'required|file|max:10240'
            ]);

            $uploadedByProfessionalId = Auth::user()->id ?? null;

            $file = $request->file('document');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $originalName = $file->getClientOriginalName();
            $fileSize = $file->getSize();
            $mimeType = $file->getMimeType();
            
            // Store file in filesystem
            $filePath = $file->storeAs('documents/centers', $fileName, 'public');

            CenterDocument::create([
                'center_id' => $center->id,
                'file_name' => $fileName,
                'original_name' => $originalName,
                'file_path' => $filePath,
                'file_size' => $fileSize,
                'mime_type' => $mimeType,
                'uploaded_by_professional_id' => $uploadedByProfessionalId
            ]);
            mainlog::log("Documento creado correctamente");
            return redirect()->route('center_show', $center->id . '#documents-section')->with('success', 'Document afegit correctament!');
            
        } catch (\Exception $e) {
            mainlog::log("Error inesperado en subida de archivo: " . $e->getMessage());
            return redirect()->route('center_show', $center)->with('error', 'Error en pujar el document');
        }
    }

    /**
     * Download the specified document.
     */
    // public function download(CenterDocument $document)
    // {
    //     if (!Storage::disk('public')->exists($document->file_path)) {
    //         // abort(404, 'File not found');
    //         return redirect()->back()->with('error_document_not_found', 'Document no trobat!');
    //     }
        
    //     return Storage::disk('public')->download($document->file_path, $document->original_name);
    // }

    public function download(CenterDocument $document)
    {
        $path = storage_path('app/public/' . $document->file_path);

        if (!file_exists($path)) {
            return redirect()->back()->with('error', 'Document no trobat!');
        }

        return response()->download($path, $document->original_name);
    }

    /**
     * Remove the specified document from storage.
     */
    public function destroy(CenterDocument $document)
    {
        $center = $document->center;
        
        // Delete file from filesystem
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }
        
        $document->delete();
        
        return redirect()->route('center_show', $center->id . '#documents-section')->with('success', 'Document eliminat correctament!');
    }
}