<?php

namespace App\Http\Controllers;

use App\Models\MaterialAssignmentDocument;
use App\Models\MaterialAssignment;
use App\Models\Professional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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
        $filePath = $file->storeAs('documents/material-assignments', $fileName, 'public');

        MaterialAssignmentDocument::create([
            'material_assignment_id' => $materialAssignment->id,
            'file_name' => $fileName,
            'original_name' => $originalName,
            'file_path' => $filePath,
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
        $path = storage_path('app/public/' . $document->file_path);

        if (!file_exists($path)) {
            return redirect()->back()->with('error_document_not_found', 'Document no trobat!');
        }

        return response()->download($path, $document->original_name);
    }

    /**
     * Remove the specified document from storage.
     */
    public function destroy(MaterialAssignmentDocument $document)
    {
        $materialAssignment = $document->materialAssignment;
        
        // Delete file from filesystem
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }
        
        $document->delete();
        
        return redirect()->route('materialassignment_show', $materialAssignment)->with('success_document_deleted', 'Document eliminat correctament!');
    }
}