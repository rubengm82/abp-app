<?php

namespace App\Http\Controllers;

use App\Models\ProjectCommissionNote;
use App\Models\ProjectCommission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $createdByProfessionalId = Auth::user()->id ?? null;
        
        ProjectCommissionNote::create([
            'project_commission_id' => $projectCommission->id,
            'notes' => $request->input('notes'),
            'professional_id' => $createdByProfessionalId
        ]);

        return redirect()->route('projectcommission_show', $projectCommission)->with('success', 'Nota afegida correctament!');
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

        return redirect()->route('projectcommission_show', $note->projectCommission)->with('success', 'Nota actualitzada correctament!');
    }

    /**
     * Remove the specified note from storage.
     */
    public function destroy(ProjectCommissionNote $note)
    {
        $projectCommission = $note->projectCommission;
        $note->delete();
        
        return redirect()->route('projectcommission_show', $projectCommission)->with('success', 'Nota eliminada correctament!');
    }
}
