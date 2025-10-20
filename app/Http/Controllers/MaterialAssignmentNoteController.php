<?php

namespace App\Http\Controllers;

use App\Models\MaterialAssignmentNote;
use App\Models\MaterialAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialAssignmentNoteController extends Controller
{
    /**
     * Store a newly created note in storage.
     */
    public function store(Request $request, MaterialAssignment $materialAssignment)
    {
        $request->validate([
            'notes' => 'required|string|max:1000'
        ]);

        $createdByProfessionalId = Auth::user()->id ?? null;

        MaterialAssignmentNote::create([
            'material_assignment_id' => $materialAssignment->id,
            'notes' => $request->input('notes'),
            'created_by_professional_id' => $createdByProfessionalId
        ]);

        return redirect()->route('materialassignment_show', $materialAssignment->id . '#notes-section')->with('success', 'Nota afegida correctament!');
    }

    /**
     * Update the specified note in storage.
     */
    public function update(Request $request, MaterialAssignmentNote $note)
    {
        $request->validate([
            'notes' => 'required|string|max:1000'
        ]);

        $note->update([
            'notes' => $request->input('notes')
        ]);

        return redirect()->route('materialassignment_show', $note->materialAssignment->id . '#notes-section')->with('success', 'Nota actualitzada correctament!');
    }

    /**
     * Remove the specified note from storage.
     */
    public function destroy(MaterialAssignmentNote $note)
    {
        $materialAssignment = $note->materialAssignment;
        $note->delete();
        
        return redirect()->route('materialassignment_show', $materialAssignment->id . '#notes-section')->with('success', 'Nota eliminada correctament!');
    }
}