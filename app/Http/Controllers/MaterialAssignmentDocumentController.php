<?php

namespace App\Http\Controllers;

use App\Models\MaterialAssignmentDocument;
use App\Models\MaterialAssignment;
use App\Models\Professional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Helpers\mainlog;

class MaterialAssignmentDocumentController extends Controller
{
    /**
     * Store a newly created document in storage.
     */
    public function store(Request $request, MaterialAssignment $materialAssignment)
    {
        mainlog::log("Iniciando store en MaterialAssignmentDocumentController para material_assignment_id: " . $materialAssignment->id);
        
        try {
            $request->validate([
                'document' => 'required|file|max:10240'
            ]);
            mainlog::log("Documento validado");

            $uploadedByProfessionalId = Auth::user()->id ?? null;
            
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

            mainlog::log("Documento creado correctamente");
            return redirect()->route('materialassignment_show', $materialAssignment)->with('success', 'Document afegit correctament!');
            
        } catch (\Exception $e) {
            mainlog::log("Error inesperado en subida de archivo: " . $e->getMessage(), LOG_ERR);
            return redirect()->route('materialassignment_show', $materialAssignment)->with('error', 'Error en pujar el document');
        }
    }

    /**
     * Download the specified document.
     */
    public function download(MaterialAssignmentDocument $document)
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
    public function destroy(MaterialAssignmentDocument $document)
    {
        $materialAssignment = $document->materialAssignment;
        
        // Delete file from filesystem
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }
        
        $document->delete();
        
        return redirect()->route('materialassignment_show', $materialAssignment)->with('success', 'Document eliminat correctament!');
    }
}