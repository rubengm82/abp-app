<?php

namespace App\Http\Controllers;

use App\Models\MaterialAssignment;
use App\Models\Professional;
use App\Models\DocumentComponent;
use App\Models\NotesComponent;
use App\Helpers\mainlog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MaterialAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = MaterialAssignment::with(['professional', 'assignedBy'])->orderBy('created_at', 'desc');

        if ($search = $request->get('search')) {

            $query
                ->whereAny(['id', 'shirt_size', 'pants_size', 'shoe_size', 'assignment_date', 'observations'], 'like', "%{$search}%")
                ->orWhereHas('professional', fn($q) =>
                    $q->whereAny(['name', 'surname1'], 'like', "%{$search}%")
                )
                ->orWhereHas('assignedBy', fn($q) =>
                    $q->whereAny(['name', 'surname1'], 'like', "%{$search}%")
                );
        }

        $materialAssignments = $query->paginate(10)->appends(['search' => $search]);

        return $request->ajax()
            ? view('components.contents.materialassignment.tables.materialAssignmentsListTable', with(['materialAssignments' => $materialAssignments]))->render()
            : view('components.contents.materialassignment.materialAssignmentsList', with(['materialAssignments' => $materialAssignments]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $professionals = Professional::where('status', 1)->get();
        return view('components.contents.materialassignment.materialAssignmentForm')
            ->with('professionals', $professionals);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'professional_id' => 'required|exists:professionals,id',
            'shirt_size' => 'nullable|string|in:XS,S,M,L,XL,2XL,3XL,4XL,36,38,40,42,44,46,48,50,52,54,56',
            'pants_size' => 'nullable|string|in:XS,S,M,L,XL,2XL,3XL,4XL,36,38,40,42,44,46,48,50,52,54,56',
            'shoe_size' => 'nullable|string|in:34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56',
            'assignment_date' => 'required|date',
            'observations' => 'nullable|string|max:1000',
            'assigned_by_professional_id' => 'nullable|exists:professionals,id',
        ]);

        $assignedByProfessionalId = Auth::user()->id ?? null;

        MaterialAssignment::create([
            'professional_id' => $validated['professional_id'],
            'shirt_size' => $validated['shirt_size'],
            'pants_size' => $validated['pants_size'],
            'shoe_size' => $validated['shoe_size'],
            'assignment_date' => $validated['assignment_date'],
            'assigned_by_professional_id' => $validated['assigned_by_professional_id'] ?? Auth::id(),
            'observations' => $validated['observations'],
        ]);

        return redirect()->route('materialassignments_list')
            ->with('success', 'Assignació de material creada correctament!');
    }

    /**
     * Display the specified resource.
     */
    public function show(MaterialAssignment $materialAssignment)
    {
        $materialAssignment->load(['professional', 'assignedBy', 'documents', 'notes']);
        return view('components.contents.materialassignment.materialAssignmentShow')
            ->with('materialAssignment', $materialAssignment);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MaterialAssignment $materialAssignment)
    {
        $professionals = Professional::where('status', 1)->get();
        return view('components.contents.materialassignment.materialAssignmentEdit')
            ->with('materialAssignment', $materialAssignment)
            ->with('professionals', $professionals);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MaterialAssignment $materialAssignment)
    {
        $validated = $request->validate([
            'professional_id' => 'required|exists:professionals,id',
            'shirt_size' => 'nullable|string|in:XS,S,M,L,XL,2XL,3XL,4XL,36,38,40,42,44,46,48,50,52,54,56',
            'pants_size' => 'nullable|string|in:XS,S,M,L,XL,2XL,3XL,4XL,36,38,40,42,44,46,48,50,52,54,56',
            'shoe_size' => 'nullable|string|in:34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56',
            'assignment_date' => 'required|date',
            'assigned_by_professional_id' => 'nullable|exists:professionals,id',
            'observations' => 'nullable|string|max:1000',
        ]);

        $materialAssignment->update($validated);

        return redirect()->route('materialassignments_list')
            ->with('success', 'Assignació de material actualitzada correctament!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaterialAssignment $materialAssignment)
    {
        $materialAssignment->delete();
        
        return redirect()->route('materialassignments_list')
            ->with('success', 'Assignació de material eliminada correctament!');
    }

    /**
     * Download CSV with all material assignments.
     */
    public function downloadCSV()
    {
        mainlog::log("Iniciando downloadCSV en MaterialAssignmentController, descargando todas las asignaciones de material");
        $materialAssignments = MaterialAssignment::with(['professional', 'assignedBy'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = "registre_assignacions_material_{$timestamp}.csv";
        
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['ID', 'Professional', 'Samarreta', 'Pantaló', 'Sabata', 'Data Assignació', 'Assignat per', 'Observacions']);
        
        foreach ($materialAssignments as $assignment) {
            $professionalName = $assignment->professional ? 
                $assignment->professional->name . ' ' . $assignment->professional->surname1 : 'No especificat';
            $assignedByName = $assignment->assignedBy ? 
                $assignment->assignedBy->name . ' ' . $assignment->assignedBy->surname1 : 'No especificat';
            
            fputcsv($handle, [
                $assignment->id,
                $professionalName,
                $assignment->shirt_size ?: 'No assignat',
                $assignment->pants_size ?: 'No assignat',
                $assignment->shoe_size ?: 'No assignat',
                $assignment->assignment_date->format('d/m/Y'),
                $assignedByName,
                $assignment->observations ?: 'Sense observacions',
            ]);
        }
        
        fclose($handle);
        
        return response()->download($filename)->deleteFileAfterSend(true);
    }

    //// DOCUMENTS ////
    // Upload Document to server
    public function materialassignment_document_add(Request $request, MaterialAssignment $materialAssignment)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
            'document_type' => 'nullable|in:Miscel·lani',
        ]);

        $file = $request->file('file');

        // File name: original_name + fecha
        $timestamp = now()->format('Ymd_His');
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $fileName = $originalName . '_' . $timestamp . '.' . $extension;

        $filePath = $file->storeAs('documents/material-assignments', $fileName, 'public');

        $materialAssignment->documents()->create([
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


    // Download Document to server
    public function materialassignment_document_download(DocumentComponent $document)
    {
        $path = storage_path('app/public/' . $document->file_path);

        if (file_exists($path)) {
            return response()->download($path, $document->original_name);
        }

        return back()->with('error', 'El document no existeix.');
    }

    // Delete Document to server
    public function materialassignment_document_delete(DocumentComponent $document)
    {
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return back()->with('success', 'Document eliminat correctament!');
    }


    //// NOTES ////
    public function materialassignment_note_add(Request $request, MaterialAssignment $materialAssignment)
    {
        $request->validate([
            'notes' => 'required|string|max:1000',
            'restricted' => 'nullable'
        ]);

        // Convert checkbox value: "on" or presence = 1, absence = 0
        $restricted = $request->has('restricted') && $request->input('restricted') !== null ? 1 : 0;

        $materialAssignment->notes()->create([
            'notes' => $request->input('notes'),
            'created_by_professional_id' => Auth::id(),
            'restricted' => $restricted
        ]);

        return redirect()->route('materialassignment_show', $materialAssignment->id . '#notes-section')
                         ->with('success', 'Nota afegida correctament!');
    }

    public function materialassignment_note_update(Request $request, NotesComponent $note)
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

        return redirect()->route('materialassignment_show', $note->noteable->id . '#notes-section')
                         ->with('success', 'Nota actualitzada correctament!');
    }

    public function materialassignment_note_delete(NotesComponent $note)
    {
        $note->delete();

        return redirect()->route('materialassignment_show', $note->noteable->id . '#notes-section')
                         ->with('success', 'Nota eliminada correctament!');
    }

}
