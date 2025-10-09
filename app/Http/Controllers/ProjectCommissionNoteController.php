<?php

namespace App\Http\Controllers;

use App\Models\ProjectCommissionNote;
use App\Models\ProjectCommission;
use Illuminate\Http\Request;

class ProjectCommissionNoteController extends Controller
{
    /**
     * Store a newly created note in storage.
     */
    public function store(Request $request, ProjectCommission $projectCommission)
    {
        error_log('Datos recibidos: ' . json_encode($request->all()));
        
        $request->validate([
            'notes' => 'required|string|max:1000'
        ]);

        $professionalId = $request->input('professional_id');
        
        // Si no se selecciona un profesional, usar el primero disponible TODO TEMPORAL 
        if (!$professionalId) {
            $firstProfessional = \App\Models\Professional::where('status', 1)->first();
            if ($firstProfessional) {
                $professionalId = $firstProfessional->id;
            }
        }

        error_log('Professional ID a usar: ' . $professionalId);

        ProjectCommissionNote::create([
            'project_commission_id' => $projectCommission->id,
            'notes' => $request->input('notes'),
            'professional_id' => $professionalId
        ]);
        error_log('Nota añadida: ' . $request->input('notes'));

        return redirect()->route('projectcommission_show', $projectCommission)->with('success_note_added', 'Nota afegida correctament!');
    }

    /**
     * Remove the specified note from storage.
     */
    public function destroy(ProjectCommissionNote $note)
    {
        $projectCommission = $note->projectCommission;
        $note->delete();
        
        return redirect()->route('projectcommission_show', $projectCommission)->with('success_note_deleted', 'Nota eliminada correctament!');
    }
}
