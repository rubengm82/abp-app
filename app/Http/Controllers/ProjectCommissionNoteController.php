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
        
        $request->validate([
            'notes' => 'required|string|max:1000'
        ]);

        $professionalId = auth()->user()->professional_id ?? null;
        
        //TODO TEMPORAL
        // Si no hay profesional logueado, usar el primero disponible
        if (!$professionalId) {
            $firstProfessional = \App\Models\Professional::where('status', 1)->first();
            if ($firstProfessional) {
                $professionalId = $firstProfessional->id;
            }
        }

        ProjectCommissionNote::create([
            'project_commission_id' => $projectCommission->id,
            'notes' => $request->input('notes'),
            'professional_id' => $professionalId
        ]);

        return redirect()->route('projectcommission_show', $projectCommission)->with('success_note_added', 'Nota afegida correctament!');
    }

    /**
     * Update the specified note in storage.
     */
    public function update(Request $request, ProjectCommissionNote $note)
    {
        $request->validate([
            'notes' => 'required|string|max:1000'
        ]);

        $note->update([
            'notes' => $request->input('notes')
        ]);

        return redirect()->route('projectcommission_show', $note->projectCommission)->with('success_note_updated', 'Nota actualitzada correctament!');
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
