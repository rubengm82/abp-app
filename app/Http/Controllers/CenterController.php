<?php

namespace App\Http\Controllers;

use App\Models\Center;
use Illuminate\Http\Request;
use App\Helpers\mainlog;
use App\Models\DocumentComponent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        mainlog::log("Iniciando index en CenterController");
        $centers = Center::all();

        return view("components.contents.center.centersList")
            ->with('centers', $centers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("components.contents.center.centerForm");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
     
        $status_actived = '1';

        Center::create([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'status' => $status_actived,
        ]);
        return redirect()->route('center_form')->with('success', 'Centre afegit correctament!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        mainlog::log("Iniciando show en CenterController para center_id: " . $id);
        $center = Center::with(['notes', 'documents'])->findOrFail($id);
        return view('components.contents.center.centerShow')->with('center', $center);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Center $center)
    {
        return view("components.contents.center.centerEdit")->with('center', $center);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Center $center)
    {
        //TODO: Consider adding validation in the request
        $center->update($request->all());
        
        return redirect()->route('centers_list')->with('success', 'Centre actualitzat correctament!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /* *********** */
    /* OWN METHODS */
    /* *********** */
    
    /**
     * Display a listing of the resource.
     */
    public function index_desactivatedCenters()
    {
        $centers = Center::all();
        return view("components.contents.center.centersDesactivatedList")->with('centers', $centers);
    }

    /**
     * Activate Status the specified resource in storage.
     */
    public function activateStatus(Request $request, Center $center)
    {
        $center->update(['status' => 1]);
        
        return redirect()->route('centers_desactivated_list')->with('success', 'Centre activat correctament!');
    }

    /**
     * Desactivate Status the specified resource in storage.
     */
    public function desactivateStatus(Request $request, Center $center)
    {
        $center->update(['status' => 0]);
        
        return redirect()->route('centers_list')->with('success', 'Centre desactivat correctament!');
    }

    /**
     * Download CSV from resource in storage
     */
    public function downloadCSV(int $statusParam)
    {
        $centers = Center::where('status', $statusParam)->get();

        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = $statusParam == 1 ? "centres_actius_{$timestamp}.csv" : "centres_no_actius_{$timestamp}.csv";

        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['ID', 'Nom', 'Adreça', 'Telèfon', 'Email', 'Estat']);

        foreach ($centers as $center) {
            fputcsv($handle, [
                $center->id,
                $center->name,
                $center->address,
                $center->phone,
                $center->email,
                $center->status == 1 ? 'Actiu' : 'No actiu',
            ]);
        }

        // Close Pointer File
        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }


    //// DOCUMENTS ////
    // Upload Document to server
    public function center_document_add(Request $request, Center $center)
    {
        $request->validate([
            'file' => 'required|file|max:10240', 
        ]);

        $file = $request->file('file');

        // File name: original_name + fecha
        $timestamp = now()->format('Ymd_His');
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $fileName = $originalName . '_' . $timestamp . '.' . $extension;

        $filePath = $file->storeAs('documents/centers', $fileName, 'public');

        $center->documents()->create([
            'file_name' => $fileName,
            'original_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'uploaded_by_professional_id' => Auth::user()->id,
        ]);

        return back()->with('success', 'Document pujat correctament!');
    }


    // Download Document to server
    public function center_document_download(DocumentComponent $document)
    {
        $path = storage_path('app/public/' . $document->file_path);

        if (file_exists($path)) {
            return response()->download($path, $document->original_name);
        }

        return back()->with('error', 'El document no existeix.');
    }

    // Delete Document to server
    public function center_document_delete(DocumentComponent $document)
    {
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return back()->with('success', 'Document eliminat correctament!');
    }

}
