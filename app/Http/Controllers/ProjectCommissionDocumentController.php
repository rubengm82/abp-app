<?php

namespace App\Http\Controllers;

use App\Models\ProjectCommissionDocument;
use App\Models\ProjectCommission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Helpers\mainlog;

class ProjectCommissionDocumentController extends Controller
{
    /**
     * Store newly uploaded documents.
     */
    public function store(Request $request, ProjectCommission $projectCommission)
    {
        mainlog::log("Iniciando store en ProjectCommissionDocumentController para project_commission_id: " . $projectCommission->id);
        
        try {
            $request->validate([
                'document' => 'required|file|max:10240'
            ]);

            $uploadedByProfessionalId = Auth::user()->id ?? null;
            
            $uploadedByProfessionalId = Auth::user()->id ?? null;
            
            $file = $request->file('document');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $originalName = $file->getClientOriginalName();
            $fileSize = $file->getSize();
            $mimeType = $file->getMimeType();
            
            // Store file in filesystem
            $filePath = $file->storeAs('documents/project-commissions', $fileName, 'public');
                    
            ProjectCommissionDocument::create([
                'project_commission_id' => $projectCommission->id,
                'professional_id' => $uploadedByProfessionalId,
                'file_name' => $fileName,
                'original_name' => $originalName,
                'file_path' => $filePath,
                'file_size' => $fileSize,
                'mime_type' => $mimeType,
            ]);

            mainlog::log("Documentos creados correctamente");
            return redirect()->route('projectcommission_show', $projectCommission->id . '#documents-section')->with('success', 'Document afegit correctament!');

        } catch (\Exception $e) {
            mainlog::log("Error inesperado en subida de archivo: " . $e->getMessage(), LOG_ERR);
            return redirect()->route('projectcommission_show', $projectCommission->id . '#documents-section')->with('error', 'Error en pujar els documents');
        }
    }

    /**
     * Remove the specified document from storage.
     */
    public function destroy(ProjectCommissionDocument $document)
    {
        $projectCommission = $document->projectCommission;
        
        // Delete file from filesystem
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }
        
        $document->delete();
        
        return redirect()->route('projectcommission_show', $projectCommission->id . '#documents-section')->with('success', 'Arxiu eliminat correctament!');
    }

    /**
     * Download the specified document.
     */
    public function download(ProjectCommissionDocument $document)
    {
        $path = storage_path('app/public/' . $document->file_path);

        if (!file_exists($path)) {
            return redirect()->back()->with('error', 'Document no trobat!');
        }

        return response()->download($path, $document->original_name);
    }
}
