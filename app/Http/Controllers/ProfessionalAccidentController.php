<?php

namespace App\Http\Controllers;

use App\Models\ProfessionalAccident;
use App\Models\Professional;
use App\Models\DocumentComponent;
use App\Models\NotesComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        $accidents = $query->orderBy('created_at', 'desc')->get();

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
            ->where('is_on_leave', false)
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
            'type' => 'required|in:Sin baixa,Amb baixa,Baixa Finalitzada',
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

        // If type is "Amb baixa", update the affected professional's leave status
        if ($validated['type'] === 'Amb baixa') {
            $affectedProfessional = Professional::findOrFail($validated['affected_professional_id']);
            $affectedProfessional->update(['is_on_leave' => true]);
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
                $q->where('is_on_leave', false)
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
            'type' => 'required|in:Sin baixa,Amb baixa,Baixa Finalitzada',
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
        if ($validated['type'] === 'Amb baixa') {
            // If changing to "Amb baixa", set is_on_leave to true
            $affectedProfessional->update(['is_on_leave' => true]);
        } elseif ($validated['type'] === 'Baixa Finalitzada') {
            // If type is "Baixa Finalitzada", set is_on_leave to false
            $affectedProfessional->update(['is_on_leave' => false]);
        } else {
            // If changing from "Amb baixa" to "Sin baixa", set is_on_leave to false
            if ($oldType === 'Amb baixa' || $oldType === 'Baixa Finalitzada') {
                $affectedProfessional->update(['is_on_leave' => false]);
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
        
        // If it was an "Amb baixa" type, restore the professional's leave status
        if ($accident->type === 'Amb baixa') {
            $affectedProfessional = $accident->affectedProfessional;
            if ($affectedProfessional) {
                $affectedProfessional->update(['is_on_leave' => false]);
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
        
        // Only allow ending leaves for "Amb baixa" type
        if ($accident->type !== 'Amb baixa') {
            return redirect()->route('professional_accident_show', $accident->id)
                ->with('error', 'Només es poden finalitzar les baixes.');
        }

        // Check if leave is already ended
        if ($accident->type === 'Baixa Finalitzada') {
            return redirect()->route('professional_accident_show', $accident->id)
                ->with('error', 'Aquesta baixa ja està finalitzada.');
        }

        // Update the affected professional's leave status
        $affectedProfessional = $accident->affectedProfessional;
        if ($affectedProfessional) {
            $affectedProfessional->update(['is_on_leave' => false]);
        }

        // Update the accident: change type to 'Baixa Finalitzada' and set end_date if not set
        $updateData = ['type' => 'Baixa Finalitzada'];
        if (!$accident->end_date) {
            $updateData['end_date'] = now()->toDateString();
        }
        $accident->update($updateData);

        return redirect()->route('professional_accident_show', $accident->id)
            ->with('success', 'Baixa finalitzada correctament! El professional ha estat actualitzat.');
    }

    //// DOCUMENTS ////
    // Upload Document to server
    public function professional_accident_document_add(Request $request, ProfessionalAccident $professionalAccident)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
            'document_type' => 'nullable|string',
        ]);

        $file = $request->file('file');

        // File name: original_name + fecha
        $timestamp = now()->format('Ymd_His');
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $fileName = $originalName . '_' . $timestamp . '.' . $extension;

        $filePath = $file->storeAs('documents/professional_accidents', $fileName, 'public');

        $professionalAccident->documents()->create([
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
    public function professional_accident_document_download(DocumentComponent $document)
    {
        $path = storage_path('app/public/' . $document->file_path);

        if (file_exists($path)) {
            return response()->download($path, $document->original_name);
        }

        return back()->with('error', 'El document no existeix.');
    }

    // Delete Document to server
    public function professional_accident_document_delete(DocumentComponent $document)
    {
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return back()->with('success', 'Document eliminat correctament!');
    }

    //// NOTES ////
    public function professional_accident_note_add(Request $request, ProfessionalAccident $professionalAccident)
    {
        $request->validate([
            'notes' => 'required|string|max:1000',
            'restricted' => 'nullable'
        ]);

        // Convert checkbox value: "on" or presence = 1, absence = 0
        $restricted = $request->has('restricted') && $request->input('restricted') !== null ? 1 : 0;

        $professionalAccident->notes()->create([
            'notes' => $request->input('notes'),
            'created_by_professional_id' => Auth::id(),
            'restricted' => $restricted
        ]);

        return redirect()->route('professional_accident_show', $professionalAccident->id . '#notes-section')
                         ->with('success', 'Nota afegida correctament!');
    }

    public function professional_accident_note_update(Request $request, NotesComponent $note)
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

        return redirect()->route('professional_accident_show', $note->noteable->id . '#notes-section')
                         ->with('success', 'Nota actualitzada correctament!');
    }

    public function professional_accident_note_delete(NotesComponent $note)
    {
        $note->delete();

        return redirect()->route('professional_accident_show', $note->noteable->id . '#notes-section')
                         ->with('success', 'Nota eliminada correctament!');
    }
}
