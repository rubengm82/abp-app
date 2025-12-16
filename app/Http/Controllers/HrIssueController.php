<?php

namespace App\Http\Controllers;

use App\Models\HrIssue;
use App\Models\Professional;
use App\Models\DocumentComponent;
use App\Models\NotesComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HrIssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = HrIssue::query()->where('center_id', Auth::user()->center_id);

        if ($search = $request->get('search')) {
            $query->where(function($q) use ($search) {
                
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")

                  ->orWhereHas('affectedProfessional', fn($q) =>
                      $q->whereAny(['name', 'surname1', 'surname2'], 'like', "%{$search}%")
                  )
                  ->orWhereHas('registeringProfessional', fn($q) =>
                      $q->whereAny(['name', 'surname1', 'surname2'], 'like', "%{$search}%")
                  )
                  ->orWhereHas('referredToProfessional', fn($q) =>
                      $q->whereAny(['name', 'surname1', 'surname2'], 'like', "%{$search}%")
                  );
            });
        }

        $hrIssues = $query->orderBy('opening_date', 'desc')->get();

        return $request->ajax()
            ? view('components.contents.hrIssue.tables.hrIssuesListTable', with(['hrIssues' => $hrIssues]))->render()
            : view("components.contents.hrIssue.hrIssuesList", with(['hrIssues' => $hrIssues]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $professionals = Professional::where('status', 1)
            ->where('center_id', Auth::user()->center_id)
            ->orderBy('name')
            ->orderBy('surname1')
            ->get();
        
        return view("components.contents.hrIssue.hrIssueForm")
            ->with('professionals', $professionals);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'center_id' => 'nullable|exists:centers,id',
            'opening_date' => 'required|date',
            'closing_date' => 'nullable|date|after_or_equal:opening_date',
            'affected_professional_id' => 'required|exists:professionals,id',
            'registering_professional_id' => 'required|exists:professionals,id',
            'referred_to_professional_id' => 'nullable|exists:professionals,id',
            'description' => 'required|string|max:5000',
            'status' => 'required|in:Obert,Tancat',
        ]);

        // Assign the center_id of the logged in user
        $validated['center_id'] = Auth::user()->center_id;

        HrIssue::create($validated);

        return redirect()->route('hr_issues_list')->with('success', 'Tema pendent RRHH creada correctament!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $hrIssue = HrIssue::with(['center', 'affectedProfessional', 'registeringProfessional', 'referredToProfessional', 'documents', 'notes'])
            ->findOrFail($id);

        return view('components.contents.hrIssue.hrIssueShow')->with([
            'hrIssue' => $hrIssue,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $hrIssue = HrIssue::findOrFail($id);
        
        $professionals = Professional::where('status', 1)
            ->where('center_id', Auth::user()->center_id)
            ->orderBy('name')
            ->orderBy('surname1')
            ->get();
        
        return view("components.contents.hrIssue.hrIssueEdit")
            ->with('hrIssue', $hrIssue)
            ->with('professionals', $professionals);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $hrIssue = HrIssue::findOrFail($id);

        $validated = $request->validate([
            'center_id' => 'nullable|exists:centers,id',
            'opening_date' => 'required|date',
            'closing_date' => 'nullable|date|after_or_equal:opening_date',
            'affected_professional_id' => 'required|exists:professionals,id',
            'registering_professional_id' => 'required|exists:professionals,id',
            'referred_to_professional_id' => 'nullable|exists:professionals,id',
            'description' => 'required|string|max:5000',
            'status' => 'required|in:Obert,Tancat',
        ]);

        // Ensure center_id remains the same (cannot be changed)
        $validated['center_id'] = $hrIssue->center_id;

        $hrIssue->update($validated);

        return redirect()->route('hr_issues_list')->with('success', 'Tema pendent RRHH actualitzada correctament!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $hrIssue = HrIssue::findOrFail($id);
        $hrIssue->delete();

        return redirect()->route('hr_issues_list')->with('success', 'Tema pendent RRHH eliminada correctament!');
    }

    //// DOCUMENTS ////
    /**
     * Upload Document to server
     */
    public function hr_issue_document_add(Request $request, HrIssue $hrIssue)
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

        $filePath = $file->storeAs('documents/hr_issues', $fileName, 'public');

        $hrIssue->documents()->create([
            'file_name' => $fileName,
            'original_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'uploaded_by_professional_id' => Auth::user()->id,
            'document_type' => $request->input('document_type'),
        ]);

        return back()->with('success', 'Document pujat correctament!');
    }

    /**
     * Download Document from server
     */
    public function hr_issue_document_download(DocumentComponent $document)
    {
        $path = storage_path('app/public/' . $document->file_path);

        if (file_exists($path)) {
            return response()->download($path, $document->original_name);
        }

        return back()->with('error', 'El document no existeix.');
    }

    /**
     * Delete Document from server
     */
    public function hr_issue_document_delete(DocumentComponent $document)
    {
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return back()->with('success', 'Document eliminat correctament!');
    }

    //// NOTES ////
    /**
     * Add note to HR issue
     */
    public function hr_issue_note_add(Request $request, HrIssue $hrIssue)
    {
        $request->validate([
            'notes' => 'required|string|max:1000',
            'restricted' => 'nullable'
        ]);

        // Convert checkbox value: "on" or presence = 1, absence = 0
        $restricted = $request->has('restricted') && $request->input('restricted') !== null ? 1 : 0;

        $hrIssue->notes()->create([
            'notes' => $request->input('notes'),
            'created_by_professional_id' => Auth::id(),
            'restricted' => $restricted
        ]);

        return redirect()->route('hr_issue_show', $hrIssue->id . '#notes-section')
                         ->with('success', 'Nota afegida correctament!');
    }

    /**
     * Update note
     */
    public function hr_issue_note_update(Request $request, NotesComponent $note)
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

        return redirect()->route('hr_issue_show', $note->noteable->id . '#notes-section')
                         ->with('success', 'Nota actualitzada correctament!');
    }

    /**
     * Delete note
     */
    public function hr_issue_note_delete(NotesComponent $note)
    {
        $note->delete();

        return redirect()->route('hr_issue_show', $note->noteable->id . '#notes-section')
                         ->with('success', 'Nota eliminada correctament!');
    }

    /**
     * Download CSV
     */
    public function downloadCSV()
    {
        $hrIssues = HrIssue::with(['center', 'affectedProfessional', 'registeringProfessional', 'referredToProfessional'])
            ->where('center_id', Auth::user()->center->id)
            ->orderBy('opening_date', 'desc')
            ->get();

        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = "temes_rrhh_{$timestamp}.csv";

        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['Professional Afectat', 'Professional Registrador', 'Professional Referit', 'Descripció', 'Estat', 'Data d\'obertura', 'Data de tancament']);

        foreach ($hrIssues as $hrIssue) {
            $affectedName = $hrIssue->affectedProfessional ? $hrIssue->affectedProfessional->name . ' ' . $hrIssue->affectedProfessional->surname1 : 'No especificat';
            $registeringName = $hrIssue->registeringProfessional ? $hrIssue->registeringProfessional->name . ' ' . $hrIssue->registeringProfessional->surname1 : 'No especificat';
            $referredName = $hrIssue->referredToProfessional ? $hrIssue->referredToProfessional->name . ' ' . $hrIssue->referredToProfessional->surname1 : 'No especificat';

            fputcsv($handle, [
                $affectedName,
                $registeringName,
                $referredName,
                $hrIssue->description,
                $hrIssue->status,
                $hrIssue->opening_date ? \Carbon\Carbon::parse($hrIssue->opening_date)->format('d/m/Y') : 'No especificada',
                $hrIssue->closing_date ? \Carbon\Carbon::parse($hrIssue->closing_date)->format('d/m/Y') : 'No especificada',
            ]);
        }

        fclose($handle);
        return response()->download($filename)->deleteFileAfterSend(true);
    }
}

