<?php

namespace App\Http\Controllers;

use App\Models\CenterNote;
use App\Models\Center;
use App\Models\Professional;
use Illuminate\Http\Request;

class CenterNoteController extends Controller
{
    /**
     * Store a newly created note in storage.
     */
    public function store(Request $request, Center $center)
    {
        $request->validate([
            'notes' => 'required|string|max:1000'
        ]);

        $createdByProfessionalId = auth()->user()->professional_id ?? null;
        
        //TODO TEMPORAL
        // Si no hay profesional logueado, usar el primero disponible
        if (!$createdByProfessionalId) {
            $firstProfessional = Professional::where('status', 1)->first();
            if ($firstProfessional) {
                $createdByProfessionalId = $firstProfessional->id;
            }
        }

        CenterNote::create([
            'center_id' => $center->id,
            'notes' => $request->input('notes'),
            'created_by_professional_id' => $createdByProfessionalId
        ]);

        return redirect()->route('center_show', $center)->with('success', 'Nota afegida correctament!');
    }

    /**
     * Update the specified note in storage.
     */
    public function update(Request $request, CenterNote $note)
    {
        $request->validate([
            'notes' => 'required|string|max:1000'
        ]);

        $note->update([
            'notes' => $request->input('notes')
        ]);

        return redirect()->route('center_show', $note->center)->with('success', 'Nota actualitzada correctament!');
    }

    /**
     * Remove the specified note from storage.
     */
    public function destroy(CenterNote $note)
    {
        $center = $note->center;
        $note->delete();
        
        return redirect()->route('center_show', $center)->with('success', 'Nota eliminada correctament!');
    }
}