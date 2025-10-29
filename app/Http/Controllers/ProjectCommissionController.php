<?php

namespace App\Http\Controllers;

use App\Models\ProjectCommission;
use App\Models\Professional;
use App\Models\DocumentComponent;
use App\Models\ProjectCommissionAssignment;
use App\Models\NotesComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Helpers\mainlog;

class ProjectCommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projectCommissions = ProjectCommission::with('responsibleProfessional')->get(); //Es para mostrar el nombre del profesional responsable
        return view("components.contents.projectcommission.projectCommissionsList")->with('projectCommissions', $projectCommissions);
    }
   
    /**
     * Display a listing of the resource.
     */
    public function indexDesactivated()
    {
        $projectCommissions = ProjectCommission::all();
        return view("components.contents.projectcommission.projectCommissionsDesactivatedList")->with('projectCommissions', $projectCommissions);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $professionals = Professional::where('status', 1)->get();
        return view("components.contents.projectcommission.projectCommissionForm")->with('professionals', $professionals);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $status_active = 'Actiu';

        ProjectCommission::create([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'start_date' => $request->input('start_date'),
            'estimated_end_date' => $request->input('estimated_end_date'),
            'responsible_professional_id' => $request->input('responsible_professional_id'),
            'description' => $request->input('description'),
            'status' => $status_active,
        ]);

        return redirect()->route('projectcommission_form')->with('success', 'Projecte/Comissió afegit correctament!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectCommission $projectCommission)
    {
        $projectCommission->load([
            'responsibleProfessional.center',
            'notes.createdByProfessional',
            'assignments.professional.center'
        ]);

        return view('components.contents.projectcommission.projectCommissionShow', [
            'projectCommission' => $projectCommission
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectCommission $projectCommission)
    {
        $professionals = Professional::where('status', 1)->get();
        return view("components.contents.projectcommission.projectCommissionEdit")->with([
            'projectCommission' => $projectCommission,
            'professionals' => $professionals
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjectCommission $projectCommission)
    {
        $projectCommission->update([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'start_date' => $request->input('start_date'),
            'estimated_end_date' => $request->input('estimated_end_date'),
            'responsible_professional_id' => $request->input('responsible_professional_id'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('projectcommissions_list', $projectCommission)->with('success', 'Projecte/Comissió actualitzat correctament!');
    }

    /**
     * Activate Status the specified resource in storage.
     */
    public function activateStatus(Request $request, ProjectCommission $projectCommission)
    {
        $projectCommission->status = 'Actiu';
        $projectCommission->save();
        
        return redirect()->route('projectcommissions_desactivated_list')->with('success', 'Projecte/Comissió activat correctament!');
    }

    /**
     * Desactivate Status the specified resource in storage.
     */
    public function desactivateStatus(Request $request, ProjectCommission $projectCommission)
    {
        $projectCommission->update(['status' => 'Inactiu']);
        $projectCommission->status = 'Inactiu';
        $projectCommission->save();
        
        return redirect()->route('projectcommissions_list')->with('success', 'Projecte/Comissió desactivat correctament!');
    }

    /**
     * Download CSV from resource in storage
     */
    public function downloadCSV(string $statusParam)
    {
        $projectCommissions = ProjectCommission::where('status', $statusParam)->with('responsibleProfessional')->get();

        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = $statusParam == 'Actiu' ? "projectes_comissions_actius_{$timestamp}.csv" : "projectes_comissions_inactius_{$timestamp}.csv";

        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['ID', 'Nom', 'Tipus', 'Data Inici', 'Data Fi Est.', 'Professional Responsable', 'Descripció']);

        foreach ($projectCommissions as $projectCommission) {
            fputcsv($handle, [
                $projectCommission->id,
                $projectCommission->name,
                $projectCommission->type,
                $projectCommission->start_date ? \Carbon\Carbon::parse($projectCommission->start_date)->format('d/m/Y') : '',
                $projectCommission->estimated_end_date ? \Carbon\Carbon::parse($projectCommission->estimated_end_date)->format('d/m/Y') : '',
                $projectCommission->responsibleProfessional ? $projectCommission->responsibleProfessional->name . ' ' . $projectCommission->responsibleProfessional->surname1 : '',
                $projectCommission->description,
            ]);
        }

        // Close Pointer File
        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }

    //// DOCUMENTS ////
    // Upload Document to server
    public function projectcommission_document_add(Request $request, ProjectCommission $projectCommission)
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

        $filePath = $file->storeAs('documents/project-commissions', $fileName, 'public');

        $projectCommission->documents()->create([
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
    public function projectcommission_document_download(DocumentComponent $document)
    {
        $path = storage_path('app/public/' . $document->file_path);

        if (file_exists($path)) {
            return response()->download($path, $document->original_name);
        }

        return back()->with('error', 'El document no existeix.');
    }

    // Delete Document to server
    public function projectcommission_document_delete(DocumentComponent $document)
    {
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return back()->with('success', 'Document eliminat correctament!');
    }


    //// NOTES ////
    public function projectcommission_note_add(Request $request, ProjectCommission $projectCommission)
    {
        $request->validate([
            'notes' => 'required|string|max:1000'
        ]);

        $projectCommission->notes()->create([
            'notes' => $request->input('notes'),
            'created_by_professional_id' => Auth::id()
        ]);

        return redirect()->route('projectcommission_show', $projectCommission->id . '#notes-section')
                         ->with('success', 'Nota afegida correctament!');
    }

    public function projectcommission_note_update(Request $request, NotesComponent $note)
    {
        $request->validate([
            'notes' => 'required|string|max:1000'
        ]);

        $note->update(['notes' => $request->input('notes')]);

        return redirect()->route('projectcommission_show', $note->noteable->id . '#notes-section')
                         ->with('success', 'Nota actualitzada correctament!');
    }

    public function projectcommission_note_delete(NotesComponent $note)
    {
        $note->delete();

        return redirect()->route('projectcommission_show', $note->noteable->id . '#notes-section')
                         ->with('success', 'Nota eliminada correctament!');
    }
    
    //// PROFESSIONAL ASSIGNMENTS ////
    /**
     * Show the form to assign professionals to a project commission
     */
    public function assignProfessionals(ProjectCommission $projectCommission)
    {
        // Get all active professionals
        $allProfessionals = Professional::where('status', 1)->orderBy('name')->get();
        
        // Get assigned professional IDs
        // pluck(): method that extracts a single column
        $assignedProfessionalIds = $projectCommission->assignments->pluck('professional_id')->toArray();
        
        // Separate assigned and unassigned professionals
        $unassignedProfessionals = $allProfessionals->whereNotIn('id', $assignedProfessionalIds);
        $assignedProfessionals = $allProfessionals->whereIn('id', $assignedProfessionalIds);
        
        return view('components.contents.projectcommission.assignProfessionals', [
            'projectCommission' => $projectCommission,
            'unassignedProfessionals' => $unassignedProfessionals,
            'assignedProfessionals' => $assignedProfessionals
        ]);
    }

    /**
     * Update professional assignments for a project commission
     */
    public function updateProfessionalAssignments(Request $request, ProjectCommission $projectCommission)
    {
        mainlog::log("Empieza el método updateProfessionalAssignments");
        // Validate the request
        $request->validate([
            'professional_ids' => 'nullable|array',
            'professional_ids.*' => 'exists:professionals,id'
        ]);
        mainlog::log("Validación completada");

        // Get the professional IDs from the request
        $professionalIds = $request->input('professional_ids', []);
        mainlog::log("Profesionales IDs:". json_encode($professionalIds));
        // Delete existing assignments
        $projectCommission->assignments()->delete();
        mainlog::log("Asignaciones eliminadas");

        // Create new assignments
        foreach ($professionalIds as $professionalId) {
            $projectCommission->assignments()->create([
                'professional_id' => $professionalId
            ]);
        }
        mainlog::log("Asignaciones creadas");

        return redirect()->route('projectcommission_show', $projectCommission)
                         ->with('success', 'Professionals assignats correctament!');
    }
    
}
