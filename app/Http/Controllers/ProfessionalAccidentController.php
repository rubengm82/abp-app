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
        // Get available professionals for the current center
        $availableProfessionals = Professional::where('status', 1)
            ->where('center_id', Auth::user()->center_id)
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
            'type' => 'required|in:Sense baixa,Amb baixa',
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
        
        // Get available professionals for the current center
        $availableProfessionals = Professional::where('status', 1)
            ->where('center_id', Auth::user()->center_id)
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
            'type' => 'required|in:Sense baixa,Amb baixa',
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

        $accident->update($validated);

        return redirect()->route('professional_accidents_list')->with('success', 'Accident professional actualitzat correctament!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $accident = ProfessionalAccident::findOrFail($id);
        $accident->delete();

        return redirect()->route('professional_accidents_list')->with('success', 'Accident professional eliminat correctament!');
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
            'document_type' => $request->input('document_type') ? $request->input('document_type') : 'Altres' ,
        ]);

        return back()->with('success', 'Document pujat correctament!');
    }

    // Download Document to server
    public function professional_accident_document_download(DocumentComponent $document)
    {
        $path = storage_path('app/public/' . $document->file_path);

        $response = null;
        if (file_exists($path)) {
            $response = response()->download($path, $document->original_name);
        } else {
            $response = back()->with('error', 'El document no existeix.');
        }

        return $response;
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

    /**
     * Download CSV from resource in storage
     */
    public function downloadCSV()
    {
        $accidents = ProfessionalAccident::with(['affectedProfessional', 'createdByProfessional'])
            ->whereHas('affectedProfessional', function($q) {
                $q->where('center_id', Auth::user()->center_id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = "accidents_professionals_{$timestamp}.csv";

        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['Tipus', 'Data', 'Professional Afectat', 'Registrat Per', 'Context', 'Descripció', 'Duració', 'Data Inici', 'Data Fi']);

        foreach ($accidents as $accident) {
            $affectedName = $accident->affectedProfessional 
                ? trim($accident->affectedProfessional->name . ' ' . $accident->affectedProfessional->surname1 . ' ' . ($accident->affectedProfessional->surname2 ?? ''))
                : 'No especificat';
            
            $createdByName = $accident->createdByProfessional 
                ? trim($accident->createdByProfessional->name . ' ' . $accident->createdByProfessional->surname1 . ' ' . ($accident->createdByProfessional->surname2 ?? ''))
                : 'No especificat';

            fputcsv($handle, [
                $accident->type ?? '',
                $accident->date ? $accident->date->format('d/m/Y') : '',
                $affectedName,
                $createdByName,
                $accident->context ?? '',
                $accident->description ?? '',
                $accident->duration ?? '',
                $accident->start_date ? $accident->start_date->format('d/m/Y') : '',
                $accident->end_date ? $accident->end_date->format('d/m/Y') : '',
            ]);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }
}
