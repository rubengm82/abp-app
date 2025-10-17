<?php

namespace App\Http\Controllers;

use App\Models\MaterialAssignment;
use App\Models\Professional;
use Illuminate\Http\Request;

class MaterialAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materialAssignments = MaterialAssignment::with(['professional', 'assignedBy'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('components.contents.materialassignment.materialAssignmentsList')
            ->with('materialAssignments', $materialAssignments);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $professionals = Professional::where('status', 1)->get();
        return view('components.contents.materialassignment.materialAssignmentForm')
            ->with('professionals', $professionals);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'professional_id' => 'required|exists:professionals,id',
            'shirt_size' => 'nullable|string|in:XS,S,M,L,XL,2XL,3XL,4XL,36,38,40,42,44,46,48,50,52,54,56',
            'pants_size' => 'nullable|string|in:XS,S,M,L,XL,2XL,3XL,4XL,36,38,40,42,44,46,48,50,52,54,56',
            'shoe_size' => 'nullable|string|in:34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56',
            'assignment_date' => 'required|date',
            'assigned_by_professional_id' => 'nullable|exists:professionals,id',
            'observations' => 'nullable|string|max:1000',
        ]);

        // TODO: Get assigned_by_professional_id from logged user
        // For now, use the first available professional
        if (!$validated['assigned_by_professional_id']) {
            $firstProfessional = Professional::where('status', 1)->first();
            if ($firstProfessional) {
                $validated['assigned_by_professional_id'] = $firstProfessional->id;
            }
        }

        MaterialAssignment::create($validated);

        return redirect()->route('materialassignments_list')
            ->with('success', 'Assignació de material creada correctament!');
    }

    /**
     * Display the specified resource.
     */
    public function show(MaterialAssignment $materialAssignment)
    {
        $materialAssignment->load(['professional', 'assignedBy', 'documents', 'notes']);
        return view('components.contents.materialassignment.materialAssignmentShow')
            ->with('materialAssignment', $materialAssignment);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MaterialAssignment $materialAssignment)
    {
        $professionals = Professional::where('status', 1)->get();
        return view('components.contents.materialassignment.materialAssignmentEdit')
            ->with('materialAssignment', $materialAssignment)
            ->with('professionals', $professionals);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MaterialAssignment $materialAssignment)
    {
        $validated = $request->validate([
            'professional_id' => 'required|exists:professionals,id',
            'shirt_size' => 'nullable|string|in:XS,S,M,L,XL,2XL,3XL,4XL,36,38,40,42,44,46,48,50,52,54,56',
            'pants_size' => 'nullable|string|in:XS,S,M,L,XL,2XL,3XL,4XL,36,38,40,42,44,46,48,50,52,54,56',
            'shoe_size' => 'nullable|string|in:34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56',
            'assignment_date' => 'required|date',
            'assigned_by_professional_id' => 'nullable|exists:professionals,id',
            'observations' => 'nullable|string|max:1000',
        ]);

        $materialAssignment->update($validated);

        return redirect()->route('materialassignments_list')
            ->with('success', 'Assignació de material actualitzada correctament!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaterialAssignment $materialAssignment)
    {
        $materialAssignment->delete();
        
        return redirect()->route('materialassignments_list')
            ->with('success', 'Assignació de material eliminada correctament!');
    }

    /**
     * Download CSV with material assignments for professionals.
     */
    //TODO: Duplicated method, use only the one from ProfessionalController!, do not delete for now.
    public function downloadCSV()
    {
        $professionals = Professional::where('status', 1)->get();
        
        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = "assignacions_material_professionals_{$timestamp}.csv";
        
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['ID', 'Nom', 'Cognom', 'Samarreta', 'Pantaló', 'Sabata', 'Data Assignació', 'Assignat per']);
        
        foreach ($professionals as $professional) {
            $shirtSize = MaterialAssignment::getLatestShirtSize($professional->id);
            $pantsSize = MaterialAssignment::getLatestPantsSize($professional->id);
            $shoeSize = MaterialAssignment::getLatestShoeSize($professional->id);
            

            //REVISAR -> Asegurar de que no esta utilizando la fecha del ultimo registro, ya que pueden ser dias distintos
            $latestAssignment = MaterialAssignment::getLatestForProfessional($professional->id);
            $assignmentDate = $latestAssignment ? $latestAssignment->assignment_date->format('d/m/Y') : 'No assignat';
            $assignedBy = $latestAssignment && $latestAssignment->assignedBy ? 
                $latestAssignment->assignedBy->name . ' ' . $latestAssignment->assignedBy->surname1 : 'No especificat';
            
            fputcsv($handle, [
                $professional->id,
                $professional->name,
                $professional->surname1,
                $shirtSize ?: 'No assignat',
                $pantsSize ?: 'No assignat',
                $shoeSize ?: 'No assignat',
                $assignmentDate,
                $assignedBy,
            ]);
        }
        
        fclose($handle);
        
        return response()->download($filename)->deleteFileAfterSend(true);
    }
}
