<?php

namespace App\Http\Controllers;

use App\Models\ProjectCommission;
use App\Models\Professional;
use Illuminate\Http\Request;

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
            'notes' => $request->input('notes'),
            'status' => $status_active,
        ]);

        return redirect()->route('projectcommission_form')->with('success', 'Projecte/Comissió afegit correctament!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectCommission $projectCommission)
    {
        $projectCommission->load(['responsibleProfessional.center', 'projectNotes.professional']);
        return view("components.contents.projectcommission.projectCommissionShow")->with('projectCommission', $projectCommission);
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
            'notes' => $request->input('notes'),
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
}
