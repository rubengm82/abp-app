<?php

namespace App\Http\Controllers;

use App\Models\ProfessionalDocument;
use App\Models\Professional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Helpers\mainlog;

class ProfessionalDocumentController extends Controller
{
    /**
     * Store a newly created document in storage.
     */
    public function store(Request $request, Professional $professional)
    {
        mainlog::log("Iniciando store en ProfessionalDocumentController para professional_id: " . $professional->id);
        
        try {
            $request->validate([
                'document' => 'required|file|max:10240'
            ]);

            $uploadedByProfessionalId = Auth::user()->id ?? null;
            
            //TODO TEMPORAL
            // Si no hay profesional logueado, usar el primero disponible
            if (!$uploadedByProfessionalId) {
                $firstProfessional = Professional::where('status', 1)->first();
                if ($firstProfessional) {
                    $uploadedByProfessionalId = $firstProfessional->id;
                }
            }

            $file = $request->file('document');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $originalName = $file->getClientOriginalName();
            $fileSize = $file->getSize();
            $mimeType = $file->getMimeType();
            
            // Store file in filesystem
            $filePath = $file->storeAs('documents/professionals', $fileName, 'public');

            ProfessionalDocument::create([
                'professional_id' => $professional->id,
                'file_name' => $fileName,
                'original_name' => $originalName,
                'file_path' => $filePath,
                'file_size' => $fileSize,
                'mime_type' => $mimeType,
                'uploaded_by_professional_id' => $uploadedByProfessionalId
            ]);

            mainlog::log("Documento creado correctamente");
            return redirect()->route('professional_show', $professional)->with('success_document_added', 'Document afegit correctament!');
            
        } catch (\Exception $e) {
            mainlog::log("Error inesperado en subida de archivo: " . $e->getMessage(), LOG_ERR);
            return redirect()->route('professional_show', $professional)->with('error_document_upload', 'Error en pujar el document');
        }
    }

    /**
     * Download the specified document.
     */
    public function download(ProfessionalDocument $document)
    {
        $path = storage_path('app/public/' . $document->file_path);

        if (!file_exists($path)) {
            return redirect()->back()->with('error_document_not_found', 'Document no trobat!');
        }

        return response()->download($path, $document->original_name);
    }

    /**
     * Remove the specified document from storage.
     */
    public function destroy(ProfessionalDocument $document)
    {
        $professional = $document->professional;
        
        // Delete file from filesystem
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }
        
        $document->delete();
        
        return redirect()->route('professional_show', $professional)->with('success_document_deleted', 'Document eliminat correctament!');
    }
}