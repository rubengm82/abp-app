<?php

namespace App\Http\Controllers;

use App\Models\ProfessionalDocument;
use App\Models\Professional;
use Illuminate\Http\Request;

class ProfessionalDocumentController extends Controller
{
    /**
     * Store a newly created document in storage.
     */
    public function store(Request $request, Professional $professional)
    {
        $request->validate([
            'document' => 'required|file|max:10240'
        ]);

        $uploadedByProfessionalId = auth()->user()->professional_id ?? null;
        
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
        $fileContent = file_get_contents($file->getRealPath());

        ProfessionalDocument::create([
            'professional_id' => $professional->id,
            'file_name' => $fileName,
            'original_name' => $originalName,
            'file_content' => $fileContent,
            'file_size' => $fileSize,
            'mime_type' => $mimeType,
            'uploaded_by_professional_id' => $uploadedByProfessionalId
        ]);

        return redirect()->route('professional_show', $professional)->with('success_document_added', 'Document afegit correctament!');
    }

    /**
     * Download the specified document.
     */
    public function download(ProfessionalDocument $document)
    {
        return response($document->file_content)
            ->header('Content-Type', $document->mime_type)
            ->header('Content-Disposition', 'attachment; filename="' . $document->original_name . '"');
    }

    /**
     * Remove the specified document from storage.
     */
    public function destroy(ProfessionalDocument $document)
    {
        $professional = $document->professional;
        $document->delete();
        
        return redirect()->route('professional_show', $professional)->with('success_document_deleted', 'Document eliminat correctament!');
    }
}