<?php

namespace App\Http\Controllers;

use App\Models\ProjectCommissionDocument;
use App\Models\ProjectCommission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectCommissionDocumentController extends Controller
{
    /**
     * Store newly uploaded documents.
     */
    public function store(Request $request, ProjectCommission $projectCommission)
    {
        //TODO Preguntar tipo de archivos que el cliente necesita
        $request->validate([
            'files.*' => 'required|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,csv,txt'
        ]);

        $professionalId = auth()->user()->professional_id ?? null;
        
        // TODO TEMPORAL: Si no hay profesional logueado, usar el primero disponible
        if (!$professionalId) {
            $firstProfessional = \App\Models\Professional::where('status', 1)->first();
            if ($firstProfessional) {
                $professionalId = $firstProfessional->id;
            }
        }

        $uploadedFiles = [];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                // TODO: Implementar almacenamiento real cuando la DB esté completa
                // Por ahora solo guardamos la información sin el archivo
                $originalName = $file->getClientOriginalName();
                $fileSize = $file->getSize();
                $mimeType = $file->getMimeType();
                
                // Generar un nombre único para el archivo
                $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
                
                // TODO: Descomentar cuando se implemente el almacenamiento real
                // $filePath = $file->storeAs('project-commission-documents', $fileName, 'public');
                
                ProjectCommissionDocument::create([
                    'project_commission_id' => $projectCommission->id,
                    'professional_id' => $professionalId,
                    'file_name' => $fileName,
                    'original_name' => $originalName,
                    'file_content' => null, // TODO: Cambiar por contenido del archivo cuando se implemente
                    'file_size' => $fileSize,
                    'mime_type' => $mimeType,
                ]);

                $uploadedFiles[] = $originalName;
            }
        }
        //TODO: REVISAR
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
        
        // TODO: Eliminar archivo físico cuando se implemente el almacenamiento real
        // if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
        //     Storage::disk('public')->delete($document->file_path);
        // }
        
        $document->delete();
        
        return redirect()->route('projectcommission_show', $projectCommission)->with('success_document_deleted', 'Arxiu eliminat correctament!');
    }

    /**
     * Download the specified document.
     */
    public function download(ProjectCommissionDocument $document)
    {
        // TODO: Implementar descarga real cuando los paths estén completos
        return response()->json([
            'message' => 'Funcionalidad de descarga pendiente',
            'document' => $document->original_name
        ]);
    }
}
