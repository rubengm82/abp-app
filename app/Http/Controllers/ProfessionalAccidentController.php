<?php

namespace App\Http\Controllers;

use App\Models\ProfessionalAccident;
use App\Models\Professional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfessionalAccidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ProfessionalAccident::query()
            ->whereHas('affectedProfessional', function($q) {
                $q->where('center_id', Auth::user()->center_id);
            });

        if ($search = $request->get('search')) {
            $query->where(function($q) use ($search) {
                $q->where('type', 'like', "%{$search}%")
                  ->orWhere('context', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('affectedProfessional', fn($q) =>
                      $q->whereAny(['name', 'surname1', 'surname2'], 'like', "%{$search}%")
                  )
                  ->orWhereHas('createdByProfessional', fn($q) =>
                      $q->whereAny(['name', 'surname1', 'surname2'], 'like', "%{$search}%")
                  );
            });
        }

        $accidents = $query->orderBy('created_at', 'desc')->paginate(10)->appends(['search' => $search]);

        return $request->ajax()
            ? view('components.contents.professionalAccident.tables.professionalAccidentsListTable', with(['accidents' => $accidents]))->render()
            : view("components.contents.professionalAccident.professionalAccidentsList", with(['accidents' => $accidents]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get available professionals (not on leave) for the current center
        $availableProfessionals = Professional::where('status', 1)
            ->where('center_id', Auth::user()->center_id)
            ->where('employment_status', '!=', 'Baixa')
            ->orderBy('name')
            ->get();

        return view("components.contents.professionalAccident.professionalAccidentForm", [
            'availableProfessionals' => $availableProfessionals
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:Sin baixa,Con baixa,Baixa Finalitzada',
            'date' => 'required|date',
            'context' => 'nullable|string|max:5000',
            'description' => 'nullable|string|max:5000',
            'affected_professional_id' => 'required|exists:professionals,id',
            'duration' => 'nullable|integer|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Set the professional who created the record (logged user)
        $validated['created_by_professional_id'] = Auth::user()->id;

        ProfessionalAccident::create($validated);

        // If type is "Con baixa", update the affected professional's employment_status to 'Baixa'
        if ($validated['type'] === 'Con baixa') {
            $affectedProfessional = Professional::findOrFail($validated['affected_professional_id']);
            $affectedProfessional->update(['employment_status' => 'Baixa']);
        }

        return redirect()->route('professional_accidents_list')->with('success', 'Accident professional registrat correctament!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $accident = ProfessionalAccident::with(['createdByProfessional', 'affectedProfessional'])
            ->findOrFail($id);

        return view('components.contents.professionalAccident.professionalAccidentShow')->with([
            'accident' => $accident,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $accident = ProfessionalAccident::findOrFail($id);
        
        // Get available professionals (not on leave) for the current center
        // Include the affected professional even if on leave
        $availableProfessionals = Professional::where('status', 1)
            ->where('center_id', Auth::user()->center_id)
            ->where(function($q) use ($accident) {
                $q->where('employment_status', '!=', 'Baixa')
                  ->orWhere('id', $accident->affected_professional_id);
            })
            ->orderBy('name')
            ->get();

        return view("components.contents.professionalAccident.professionalAccidentEdit", [
            'accident' => $accident,
            'availableProfessionals' => $availableProfessionals
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $accident = ProfessionalAccident::findOrFail($id);

        $validated = $request->validate([
            'type' => 'required|in:Sin baixa,Con baixa,Baixa Finalitzada',
            'date' => 'required|date',
            'context' => 'nullable|string|max:5000',
            'description' => 'nullable|string|max:5000',
            'affected_professional_id' => 'required|exists:professionals,id',
            'duration' => 'nullable|integer|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Ensure affected_professional_id cannot be changed
        $validated['affected_professional_id'] = $accident->affected_professional_id;

        $oldType = $accident->type;

        // Prevent changing type to 'Baixa Finalitzada' manually - only through endLeave method
        if ($validated['type'] === 'Baixa Finalitzada' && $oldType !== 'Baixa Finalitzada') {
            return redirect()->route('professional_accident_edit', $accident->id)
                ->with('error', 'No es pot canviar el tipus a "Baixa Finalitzada" manualment. Utilitza el botó "Finalitzar Baixa".');
        }

        // If it was 'Baixa Finalitzada', keep it as such
        if ($oldType === 'Baixa Finalitzada') {
            $validated['type'] = 'Baixa Finalitzada';
        }

        $accident->update($validated);

        $affectedProfessional = Professional::findOrFail($validated['affected_professional_id']);

        // Handle automatic status updates
        if ($validated['type'] === 'Con baixa') {
            // If changing to "Con baixa" or already is "Con baixa", set to 'Baixa'
            $affectedProfessional->update(['employment_status' => 'Baixa']);
        } elseif ($validated['type'] === 'Baixa Finalitzada') {
            // If type is "Baixa Finalitzada", ensure professional is 'Actiu'
            $affectedProfessional->update(['employment_status' => 'Actiu']);
        } else {
            // If changing from "Con baixa" to "Sin baixa", set back to 'Actiu'
            if ($oldType === 'Con baixa' || $oldType === 'Baixa Finalitzada') {
                $affectedProfessional->update(['employment_status' => 'Actiu']);
            }
        }

        return redirect()->route('professional_accidents_list')->with('success', 'Accident professional actualitzat correctament!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $accident = ProfessionalAccident::findOrFail($id);
        
        // If it was a "Con baixa" type, restore the professional's status
        if ($accident->type === 'Con baixa') {
            $affectedProfessional = $accident->affectedProfessional;
            if ($affectedProfessional) {
                $affectedProfessional->update(['employment_status' => 'Actiu']);
            }
        }

        $accident->delete();

        return redirect()->route('professional_accidents_list')->with('success', 'Accident professional eliminat correctament!');
    }

    /**
     * End the leave for a professional accident
     */
    public function endLeave(string $id)
    {
        $accident = ProfessionalAccident::findOrFail($id);
        
        // Only allow ending leaves for "Con baixa" type
        if ($accident->type !== 'Con baixa') {
            return redirect()->route('professional_accident_show', $accident->id)
                ->with('error', 'Només es poden finalitzar les baixes.');
        }

        // Check if leave is already ended
        if ($accident->type === 'Baixa Finalitzada') {
            return redirect()->route('professional_accident_show', $accident->id)
                ->with('error', 'Aquesta baixa ja està finalitzada.');
        }

        // Update the affected professional's status back to 'Actiu'
        $affectedProfessional = $accident->affectedProfessional;
        if ($affectedProfessional) {
            $affectedProfessional->update(['employment_status' => 'Actiu']);
        }

        // Update the accident: change type to 'Baixa Finalitzada' and set end_date if not set
        $updateData = ['type' => 'Baixa Finalitzada'];
        if (!$accident->end_date) {
            $updateData['end_date'] = now()->toDateString();
        }
        $accident->update($updateData);

        return redirect()->route('professional_accident_show', $accident->id)
            ->with('success', 'Baixa finalitzada correctament! El professional ha estat actualitzat a Actiu.');
    }
}
