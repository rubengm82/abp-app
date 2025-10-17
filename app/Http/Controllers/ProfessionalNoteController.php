<?php

namespace App\Http\Controllers;

use App\Models\ProfessionalNote;
use App\Models\Professional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfessionalNoteController extends Controller
{
    /**
     * Store a newly created note in storage.
     */
    public function store(Request $request, Professional $professional)
    {
        $request->validate([
            'notes' => 'required|string|max:1000'
        ]);

        $createdByProfessionalId = Auth::user()->professional_id ?? null;
        
        //TODO TEMPORAL
        // Si no hay profesional logueado, usar el primero disponible
        if (!$createdByProfessionalId) {
            $firstProfessional = Professional::where('status', 1)->first();
            if ($firstProfessional) {
                $createdByProfessionalId = $firstProfessional->id;
            }
        }

        ProfessionalNote::create([
            'professional_id' => $professional->id,
            'notes' => $request->input('notes'),
            'created_by_professional_id' => $createdByProfessionalId
        ]);

        return redirect()->route('professional_show', $professional->id . '#notes-section')->with('success', 'Nota afegida correctament!');
    }

    /**
     * Update the specified note in storage.
     */
    public function update(Request $request, ProfessionalNote $note)
    {
        $request->validate([
            'notes' => 'required|string|max:1000'
        ]);

        $note->update([
            'notes' => $request->input('notes')
        ]);

        return redirect()->route('professional_show', $note->professional->id . '#notes-section')->with('success', 'Nota actualitzada correctament!');
    }

    /**
     * Remove the specified note from storage.
     */
    public function destroy(ProfessionalNote $note)
    {
        $professional = $note->professional;
        $note->delete();
        
        return redirect()->route('professional_show', $professional->id . '#notes-section')->with('success', 'Nota eliminada correctament!');
    }
}