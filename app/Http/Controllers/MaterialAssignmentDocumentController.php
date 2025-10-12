<?php

namespace App\Http\Controllers;

use App\Models\MaterialAssignmentDocument;
use App\Models\MaterialAssignment;
use App\Models\Professional;
use Illuminate\Http\Request;

class MaterialAssignmentDocumentController extends Controller
{
    /**
     * Store a newly created document in storage.
     */
    public function store(Request $request, MaterialAssignment $materialAssignment)
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

        MaterialAssignmentDocument::create([
            'material_assignment_id' => $materialAssignment->id,
            'file_name' => $fileName,
            'original_name' => $originalName,
            'file_content' => $fileContent,
            'file_size' => $fileSize,
            'mime_type' => $mimeType,
            'uploaded_by_professional_id' => $uploadedByProfessionalId
        ]);

        return redirect()->route('materialassignment_show', $materialAssignment)->with('success_document_added', 'Document afegit correctament!');
    }

    /**
     * Download the specified document.
     */
    public function download(MaterialAssignmentDocument $document)
    {
        return response($document->file_content)
            ->header('Content-Type', $document->mime_type)
            ->header('Content-Disposition', 'attachment; filename="' . $document->original_name . '"');
    }

    /**
     * Remove the specified document from storage.
     */
    public function destroy(MaterialAssignmentDocument $document)
    {
        $materialAssignment = $document->materialAssignment;
        $document->delete();
        
        return redirect()->route('materialassignment_show', $materialAssignment)->with('success_document_deleted', 'Document eliminat correctament!');
    }
}