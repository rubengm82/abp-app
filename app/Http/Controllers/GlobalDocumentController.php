<?php

namespace App\Http\Controllers;

use App\Models\DocumentComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GlobalDocumentController extends Controller
{
    /**
     * Display a listing of all documents globally
     */
    public function index(Request $request)
    {
        $query = DocumentComponent::active()
            ->with(['uploadedByProfessional', 'documentable'])
            ->whereHas('uploadedByProfessional', function ($q) {
                $q->where('center_id', Auth::user()->center_id);
            });

        // Search functionality
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('original_name', 'like', "%{$search}%")
                  ->orWhere('file_name', 'like', "%{$search}%")
                  ->orWhere('document_type', 'like', "%{$search}%")
                  ->orWhereHas('uploadedByProfessional', function ($professionalQuery) use ($search) {
                      $professionalQuery->where('name', 'like', "%{$search}%")
                                        ->orWhere('surname1', 'like', "%{$search}%")
                                        ->orWhere('surname2', 'like', "%{$search}%");
                  });
            });
        }

        $documents = $query->orderBy('created_at', 'desc')->get();

        $searchPerformed = $request->filled('search');

        return $request->ajax()
            ? view('components.contents.document.tables.globalDocumentsListTable', with(['documents' => $documents, 'searchPerformed' => $searchPerformed]))->render()
            : view("components.contents.document.globalDocumentsList", with(['documents' => $documents]));
    }

    /**
     * Download document from server
     */
    public function download(DocumentComponent $document)
    {
        $path = storage_path('app/public/' . $document->file_path);

        $response = null;
        if (file_exists($path)) {
            $response = response()->download($path, $document->original_name);
        } else {
            $response = back()->with('error', 'El document no existeix.');
        }

        return $response;
    }

    /**
     * List deactivated documents (center-scoped). Only Direcció/Gerència.
     */
    public function desactivatedIndex(Request $request)
    {
        if (!in_array(Auth::user()->permissions ?? null, ['Direcció', 'Gerència'])) {
            abort(403);
        }

        $query = DocumentComponent::where('active', false)
            ->with(['uploadedByProfessional', 'documentable'])
            ->whereHas('uploadedByProfessional', function ($q) {
                $q->where('center_id', Auth::user()->center_id);
            });

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('original_name', 'like', "%{$search}%")
                  ->orWhere('file_name', 'like', "%{$search}%")
                  ->orWhere('document_type', 'like', "%{$search}%")
                  ->orWhereHas('uploadedByProfessional', function ($professionalQuery) use ($search) {
                      $professionalQuery->where('name', 'like', "%{$search}%")
                                        ->orWhere('surname1', 'like', "%{$search}%")
                                        ->orWhere('surname2', 'like', "%{$search}%");
                  });
            });
        }

        $documents = $query->orderBy('updated_at', 'desc')->get();

        $searchPerformed = $request->filled('search');

        return $request->ajax()
            ? view('components.contents.document.tables.globalDocumentsDesactivatedListTable', with(['documents' => $documents, 'searchPerformed' => $searchPerformed]))->render()
            : view('components.contents.document.globalDocumentsDesactivatedList', with(['documents' => $documents]));
    }

    /**
     * Restore a deactivated document (set active). Only Direcció/Gerència.
     */
    public function restore(DocumentComponent $document)
    {
        if (!in_array(Auth::user()->permissions ?? null, ['Direcció', 'Gerència'])) {
            abort(403);
        }
        $this->ensureDocumentBelongsToUserCenter($document);

        $document->update(['active' => true]);

        return redirect()->route('documents_desactivated_list')->with('success', 'Document restaurat correctament!');
    }

    /**
     * Permanently delete document and its file. Only Direcció/Gerència.
     */
    public function destroy(DocumentComponent $document)
    {
        if (!in_array(Auth::user()->permissions ?? null, ['Direcció', 'Gerència'])) {
            abort(403);
        }
        $this->ensureDocumentBelongsToUserCenter($document);

        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }
        $document->delete();

        return redirect()->route('documents_desactivated_list')->with('success', 'Document eliminat definitivament!');
    }

    private function ensureDocumentBelongsToUserCenter(DocumentComponent $document): void
    {
        $document->loadMissing('uploadedByProfessional');
        if (!$document->uploadedByProfessional || $document->uploadedByProfessional->center_id !== Auth::user()->center_id) {
            abort(403);
        }
    }
}

