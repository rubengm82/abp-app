<?php

namespace App\Http\Controllers;

use App\Models\ProjectCommissionDocument;
use App\Models\ProjectCommission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectCommissionDocumentController extends Controller
{
    /**
     * Store newly uploaded documents.
     */
    public function store(Request $request, ProjectCommission $projectCommission)
    {
        $request->validate([
            'files.*' => 'required|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,txt'
        ]);

        $professionalId = auth()->user()->professional_id ?? null;
        
        // Si no hay profesional logueado, usar el primero disponible
        if (!$professionalId) {
            $firstProfessional = \App\Models\Professional::where('status', 1)->first();
            if ($firstProfessional) {
                $professionalId = $firstProfessional->id;
            }
        }

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
                    'professional_id' => $professionalId,
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

        return redirect()->route('projectcommission_show', $projectCommission)->with('success_document_added', $message);
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
        
        return redirect()->route('projectcommission_show', $projectCommission)->with('success_document_deleted', 'Arxiu eliminat correctament!');
    }

    /**
     * Download the specified document.
     */
    public function download(ProjectCommissionDocument $document)
    {
        if (!Storage::disk('public')->exists($document->file_path)) {
            // abort(404, 'File not found');
            return redirect()->back()->with('error_document_not_found', 'Document no trobat!');
        }
        
        return Storage::disk('public')->download($document->file_path, $document->original_name);
    }
}
