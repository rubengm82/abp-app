<?php

namespace App\Http\Controllers;

use App\Models\CenterDocument;
use App\Models\Center;
use App\Models\Professional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CenterDocumentController extends Controller
{
    /**
     * Store a newly created document in storage.
     */
    public function store(Request $request, Center $center)
    {
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
            
            // Log inicio de subida
            syslog(LOG_INFO, "Iniciando subida de archivo: {$originalName}, tamaño: {$fileSize} bytes, tipo: {$mimeType}");
            
            // Verificar espacio disponible
            $freeSpace = disk_free_space(storage_path('app/public'));
            if ($fileSize > $freeSpace) {
                syslog(LOG_ERR, "Error: Espacio insuficiente. Archivo: {$fileSize} bytes, Disponible: {$freeSpace} bytes");
                return redirect()->route('center_show', $center)->with('error_document_size', 'No hay espacio suficiente para subir el archivo');
            }
            
            // Store file in filesystem
            $filePath = $file->storeAs('documents/centers', $fileName, 'public');
            
            if (!$filePath) {
                syslog(LOG_ERR, "Error: Fallo al almacenar archivo {$originalName}");
                return redirect()->route('center_show', $center)->with('error_document_upload', 'Error al subir el archivo');
            }

            CenterDocument::create([
                'center_id' => $center->id,
                'file_name' => $fileName,
                'original_name' => $originalName,
                'file_path' => $filePath,
                'file_size' => $fileSize,
                'mime_type' => $mimeType,
                'uploaded_by_professional_id' => $uploadedByProfessionalId
            ]);

            syslog(LOG_INFO, "Archivo subido exitosamente: {$originalName} -> {$filePath}");
            return redirect()->route('center_show', $center)->with('success_document_added', 'Document afegit correctament!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            syslog(LOG_ERR, "Error de validación en subida de archivo: " . $e->getMessage());
            throw $e;
        } catch (\Exception $e) {
            syslog(LOG_ERR, "Error inesperado en subida de archivo: " . $e->getMessage());
            return redirect()->route('center_show', $center)->with('error_document_upload', 'Error al subir el archivo');
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
            return redirect()->back()->with('error_document_not_found', 'Document no trobat!');
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
        
        return redirect()->route('center_show', $center)->with('success_document_deleted', 'Document eliminat correctament!');
    }
}