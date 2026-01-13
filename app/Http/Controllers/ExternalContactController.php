<?php

namespace App\Http\Controllers;

use App\Models\ExternalContact;
use App\Models\DocumentComponent;
use App\Models\NotesComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExternalContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ExternalContact::with('center')->where('center_id', Auth::user()->center_id);

        if ($search = $request->get('search')) {
            $query->whereAny(['id', 'external_contact_type', 'company', 'department', 'name', 'surname', 'phone', 'email'], 'like', "%{$search}%");
        }
        $externalContacts = $query->get();

        return $request->ajax()
            ? view('components.contents.externalcontact.tables.externalContactsListTable', with(['externalContacts' => $externalContacts]))->render()
            : view('components.contents.externalcontact.externalContactsList', with(['externalContacts' => $externalContacts]));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("components.contents.externalcontact.externalContactForm");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        ExternalContact::create([
            'center_id' => Auth::user()->center_id, //assign the center_id of the logged in user
            'external_contact_type' => $request->input('external_contact_type'),
            'service_reason' => $request->input('service_reason'),
            'company' => $request->input('company'),
            'department' => $request->input('department'),
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'link' => $request->input('link'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'observations' => $request->input('observations'),
        ]);

        return redirect()->route('externalcontact_form')->with('success', 'Contacte extern afegit correctament!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ExternalContact $externalContact)
    {
        $externalContact->load([
            'center',
            'notes.createdByProfessional',
            'documents.uploadedByProfessional'
        ]);

        return view('components.contents.externalcontact.externalContactShow', [
            'externalContact' => $externalContact
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExternalContact $externalContact)
    {
        return view("components.contents.externalcontact.externalContactEdit")->with([
            'externalContact' => $externalContact
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExternalContact $externalContact)
    {
        $externalContact->update([
            // center_id is not modified, it remains the existing one
            'external_contact_type' => $request->input('external_contact_type'),
            'service_reason' => $request->input('service_reason'),
            'company' => $request->input('company'),
            'department' => $request->input('department'),
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'link' => $request->input('link'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'observations' => $request->input('observations'),
        ]);

        return redirect()->route('externalcontacts_list')->with('success', 'Contacte extern actualitzat correctament!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExternalContact $externalContact)
    {
        $externalContact->delete();

        return redirect()->route('externalcontacts_list')->with('success', 'Contacte extern eliminat correctament!');
    }

    /**
     * Download CSV from resource in storage
     */
    public function downloadCSV()
    {
        $externalContacts = ExternalContact::where('center_id', Auth::user()->center->id)->get();

        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = "contactes_externs_{$timestamp}.csv";

        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['Tipus', 'Motiu/Servei', 'Empresa', 'Departament', 'Responsable', 'Telèfon', 'Correu', 'Enllaç', 'Observacions']);

        foreach ($externalContacts as $externalContact) {
            $responsible = trim(($externalContact->name ?? '') . ' ' . ($externalContact->surname ?? ''));
            fputcsv($handle, [
                $externalContact->external_contact_type,
                $externalContact->service_reason,
                $externalContact->company,
                $externalContact->department,
                $responsible,
                $externalContact->phone,
                $externalContact->email,
                $externalContact->link,
                $externalContact->observations,
            ]);
        }

        // Close Pointer File
        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }

    //// DOCUMENTS ////
    // Upload Document to server
    public function externalcontact_document_add(Request $request, ExternalContact $externalContact)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
            'document_type' => 'nullable|string',
        ]);

        $file = $request->file('file');

        // File name: original_name + fecha
        $timestamp = now()->format('Ymd_His');
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $fileName = $originalName . '_' . $timestamp . '.' . $extension;

        $filePath = $file->storeAs('documents/external-contacts', $fileName, 'public');

        $externalContact->documents()->create([
            'file_name' => $fileName,
            'original_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'uploaded_by_professional_id' => Auth::user()->id,
            'document_type' => $request->input('document_type') ? $request->input('document_type') : 'Altres' ,
        ]);

        return back()->with('success', 'Document pujat correctament!');
    }


    // Download Document to server
    public function externalcontact_document_download(DocumentComponent $document)
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

    // Delete Document to server
    public function externalcontact_document_delete(DocumentComponent $document)
    {
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return back()->with('success', 'Document eliminat correctament!');
    }


    //// NOTES ////
    public function externalcontact_note_add(Request $request, ExternalContact $externalContact)
    {
        $request->validate([
            'notes' => 'required|string|max:1000',
            'restricted' => 'nullable'
        ]);

        // Convert checkbox value: "on" or presence = 1, absence = 0
        $restricted = $request->has('restricted') && $request->input('restricted') !== null ? 1 : 0;

        $externalContact->notes()->create([
            'notes' => $request->input('notes'),
            'created_by_professional_id' => Auth::id(),
            'restricted' => $restricted
        ]);

        return redirect()->route('externalcontact_show', $externalContact->id . '#notes-section')
                         ->with('success', 'Nota afegida correctament!');
    }

    public function externalcontact_note_update(Request $request, NotesComponent $note)
    {
        $request->validate([
            'notes' => 'required|string|max:1000',
            'restricted' => 'nullable'
        ]);

        // Convert checkbox value: "on" or presence = 1, absence = 0
        $restricted = $request->has('restricted') && $request->input('restricted') !== null ? 1 : 0;

        $note->update([
            'notes' => $request->input('notes'),
            'restricted' => $restricted
        ]);

        return redirect()->route('externalcontact_show', $note->noteable->id . '#notes-section')
                         ->with('success', 'Nota actualitzada correctament!');
    }

    public function externalcontact_note_delete(NotesComponent $note)
    {
        $note->delete();

        return redirect()->route('externalcontact_show', $note->noteable->id . '#notes-section')
                         ->with('success', 'Nota eliminada correctament!');
    }
    
}

