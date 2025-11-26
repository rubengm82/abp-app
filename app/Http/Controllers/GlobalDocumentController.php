<?php

namespace App\Http\Controllers;

use App\Models\DocumentComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GlobalDocumentController extends Controller
{
    /**
     * Display a listing of all documents globally
     */
    public function index(Request $request)
    {
        $query = DocumentComponent::with(['uploadedByProfessional'])->where('center_id', Auth::user()->center_id);

        // Search functionality
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('original_name', 'like', "%{$search}%")
                  ->orWhere('file_name', 'like', "%{$search}%")
                  ->orWhere('document_type', 'like', "%{$search}%");
            });
        }

        $documents = $query->orderBy('created_at', 'desc')->paginate(10)->appends(['search' => $search]);

        return $request->ajax()
            ? view('components.contents.document.tables.globalDocumentsListTable', with(['documents' => $documents]))->render()
            : view("components.contents.document.globalDocumentsList", with(['documents' => $documents]));
    }

    /**
     * Download document from server
     */
    public function download(DocumentComponent $document)
    {
        $path = storage_path('app/public/' . $document->file_path);

        if (file_exists($path)) {
            return response()->download($path, $document->original_name);
        }

        return back()->with('error', 'El document no existeix.');
    }
}

