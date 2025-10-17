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
                'files.*' => 'required|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,txt'
            ]);

            $uploadedByProfessionalId = Auth::user()->id ?? null;
            
            $uploadedFiles = [];

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $originalName = $file->getClientOriginalName();
                    $fileSize = $file->getSize();
                    $mimeType = $file->getMimeType();
                    $fileName = time() . '_' . $originalName;
                    
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

                    $uploadedFiles[] = $originalName;
                }
            }

            $message = count($uploadedFiles) > 1 
                ? count($uploadedFiles) . ' arxius pujats correctament!'
                : 'Arxiu pujat correctament!';

            mainlog::log("Documentos creados correctamente: " . count($uploadedFiles) . " archivos");
            return redirect()->route('projectcommission_show', $projectCommission)->with('success', $message);
            
        } catch (\Exception $e) {
            mainlog::log("Error inesperado en subida de archivo: " . $e->getMessage(), LOG_ERR);
            return redirect()->route('projectcommission_show', $projectCommission)->with('error', 'Error en pujar els documents');
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
        
        return redirect()->route('projectcommission_show', $projectCommission)->with('success', 'Arxiu eliminat correctament!');
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
