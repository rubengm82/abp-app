<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DocumentComponent;
use App\Models\NotesComponent;
use Illuminate\Support\Facades\Storage;


class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $status = 1)
    {
        $query = $maintenances = Maintenance::query()->where('center_id', Auth::user()->center_id)->where('status', $status);

        if ($search = $request->get('search')) {

            $query
            ->whereAny(['name_maintenance', 'responsible_maintenance', 'description', 'opening_date_maintenance'], 'like', "%{$search}%")

            ->orWhereHas('center', fn($q) =>
                $q->where('name', 'like', "%{$search}%")
            );
        }

        $maintenances = $query->get();

        $isDeactivated = ($status == 0);

        return $request->ajax()
            ? view('components.contents.maintenances.tables.maintenancesListTable', compact('maintenances', 'isDeactivated'))->render()
            : view('components.contents.maintenances.maintenancesList', compact('maintenances', 'isDeactivated'))->render();

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("components.contents.maintenances.maintenanceForm");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_maintenance' => 'required|string|max:255',
            'responsible_maintenance' => 'required|string|max:255',
            'description' => 'nullable|string',
            'opening_date_maintenance' => 'required|date',
            'ending_date_maintenance' => 'nullable',
        ]);

        Maintenance::create([
            'name_maintenance' => $validated['name_maintenance'],
            'responsible_maintenance' => $validated['responsible_maintenance'],
            'description' => $validated['description'] ?? null,
            'opening_date_maintenance' => $validated['opening_date_maintenance'],
            'ending_date_maintenance' => $validated['ending_date_maintenance'],
            'center_id' => Auth::user()->center_id, //assign the center_id of the logged in user
        ]);

        return redirect()->route('maintenances_list')->with('success', 'Manteniment creat correctament!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Maintenance $maintenance)
    {
        return view("components.contents.maintenances.maintenancesShow", compact('maintenance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Maintenance $maintenance)
    {
        return view("components.contents.maintenances.maintenanceEdit", compact('maintenance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Maintenance $maintenance)
    {
        $validated = $request->validate([
            'name_maintenance' => 'required|string|max:255',
            'responsible_maintenance' => 'required|string|max:255',
            'description' => 'nullable|string',
            'opening_date_maintenance' => 'required|date',
            'ending_date_maintenance' => 'nullable',
        ]);

        $maintenance->update([
            'name_maintenance' => $validated['name_maintenance'],
            'responsible_maintenance' => $validated['responsible_maintenance'],
            'description' => $validated['description'] ?? $maintenance->description,
            'opening_date_maintenance' => $validated['opening_date_maintenance'],
            'ending_date_maintenance' => $validated['ending_date_maintenance'],
            // center_id is not modified, it remains the existing one
        ]);

        return redirect()->route('maintenances_list')->with('success', 'Manteniment actualitzat correctament!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maintenance $maintenance)
    {
        $maintenance->delete();
        return redirect()->route('maintenances_list')->with('success', 'Manteniment eliminat correctament!');
    }

    /**
     * Activate Status the specified resource in storage.
     */
    public function activateStatus(Request $request, Maintenance $maintenance)
    {
        $maintenance->update(['status' => 1]);

        return redirect()->route('maintenances_desactivated_list')->with('success', 'Manteniment activat correctament!');
    }

    /**
     * Desactivate Status the specified resource in storage.
     */
    public function desactivateStatus(Request $request, Maintenance $maintenance)
    {
        $maintenance->update(['status' => 0]);

        return redirect()->route('maintenances_list')->with('success', 'Manteniment desactivat correctament!');
    }

    //// DOCUMENTS ////
    // Upload Document to server
    public function maintenance_document_add(Request $request, Maintenance $maintenance)
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

        $filePath = $file->storeAs('documents/maintenances', $fileName, 'public');

        $maintenance->documents()->create([
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
    public function maintenance_document_download(DocumentComponent $document)
    {
        $path = storage_path('app/public/' . $document->file_path);

        if (file_exists($path)) {
            return response()->download($path, $document->original_name);
        }

        return back()->with('error', 'El document no existeix.');
    }

    // Delete Document to server
    public function maintenance_document_delete(DocumentComponent $document)
    {
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return back()->with('success', 'Document eliminat correctament!');
    }
    

    //// NOTES ////
    public function maintenance_note_add(Request $request, Maintenance $maintenance)
    {
        $request->validate([
            'notes' => 'required|string|max:1000',
            'restricted' => 'nullable'
        ]);

        // Convert checkbox value: "on" or presence = 1, absence = 0
        $restricted = $request->has('restricted') && $request->input('restricted') !== null ? 1 : 0;

        $maintenance->notes()->create([
            'notes' => $request->input('notes'),
            'created_by_professional_id' => Auth::id(),
            'restricted' => $restricted
        ]);
        return redirect()->route('maintenance_show', $maintenance->id . '#notes-section')
                         ->with('success', 'Nota afegida correctament!');
    }

    public function maintenance_note_update(Request $request, NotesComponent $note)
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

        return redirect()->route('maintenance_show', $note->noteable->id . '#notes-section')
                         ->with('success', 'Nota actualitzada correctament!');
    }

    public function maintenance_note_delete(NotesComponent $note)
    {
        $note->delete();

        return redirect()->route('maintenance_show', $note->noteable->id . '#notes-section')
                         ->with('success', 'Nota eliminada correctament!');
    }

    /**
     * Download CSV from resource in storage
     */
    public function downloadCSV()
    {
        $maintenances = Maintenance::where('center_id', Auth::user()->center->id)->get();

        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = "manteniments_{$timestamp}.csv";

        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['Nom del Manteniment', 'Resposable del Manteniment', 'Descripció', 'Data d\'inici']);

        foreach ($maintenances as $maintenances) {
            fputcsv($handle, [
                $maintenances->name_maintenance,
                $maintenances->responsible_maintenance,
                $maintenances->description,
                $maintenances->opening_date_maintenance,
            ]);
        }

        // Close Pointer File
        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }

}
