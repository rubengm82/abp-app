<?php

namespace App\Http\Controllers;

use App\Models\Professional;
use App\Models\User;
use App\Models\Center;
use App\Models\MaterialAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfessionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $professionals = Professional::all();
        return view("components.contents.professional.professionalsList")->with('professionals', $professionals);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("components.contents.professional.professionalForm");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'center_id' => 'nullable|exists:centers,id',
            'name' => 'required|string|max:255',
            'surname1' => 'required|string|max:255',
            'surname2' => 'nullable|string|max:255',
            'dni' => 'required|string|max:20|unique:professionals,dni',
            'role' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:professionals,email',
            'address' => 'nullable|string|max:500',
            'employment_status' => 'nullable|string|max:50',
            'cvitae' => 'nullable|string',
            'user' => 'nullable|string|max:100|unique:professionals,user',
            'password' => 'nullable|string|min:4',
            'key_code' => 'nullable|string|max:50',
        ]);

        // Create professional
        $professional = Professional::create([
            'center_id' => $validated['center_id'] ?? null,
            'role' => $validated['role'] ?? null,
            'name' => $validated['name'],
            'surname1' => $validated['surname1'],
            'surname2' => $validated['surname2'] ?? null,
            'dni' => $validated['dni'],
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'address' => $validated['address'] ?? null,
            'employment_status' => $validated['employment_status'] ?? 'Actiu',
            'cvitae' => $validated['cvitae'] ?? null,
            'user' => $validated['user'],
            'password' => $validated['password'], // Will be hashed in the model booted()
            'key_code' => $validated['key_code'] ?? null,
            'status' => 1,
        ]);

        return redirect()->route('professionals_list')->with('success', 'Professional afegit correctament!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $professional = Professional::with(['documents', 'notes'])->findOrFail($id);
        return view('components.contents.professional.professionalShow')->with('professional', $professional);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $professional = Professional::findOrFail($id);
        return view("components.contents.professional.professionalEdit")->with('professional', $professional);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $professional = Professional::findOrFail($id);

        $validated = $request->validate([
            'center_id' => 'nullable|exists:centers,id',
            'name' => 'required|string|max:255',
            'surname1' => 'required|string|max:255',
            'surname2' => 'nullable|string|max:255',
            'dni' => 'required|string|max:20|unique:professionals,dni,' . $id,
            'role' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:professionals,email,' . $id,
            'address' => 'nullable|string|max:500',
            'employment_status' => 'nullable|string|max:50',
            'cvitae' => 'nullable|string',
            'user' => 'nullable|string|max:100|unique:professionals,user,' . $id,
            'password' => 'nullable|string|min:4',
            'key_code' => 'nullable|string|max:50',
        ]);

        $professional->update([
            'center_id' => $validated['center_id'] ?? $professional->center_id,
            'role' => $validated['role'] ?? $professional->role,
            'name' => $validated['name'],
            'surname1' => $validated['surname1'],
            'surname2' => $validated['surname2'] ?? $professional->surname2,
            'dni' => $validated['dni'],
            'phone' => $validated['phone'] ?? $professional->phone,
            'email' => $validated['email'] ?? $professional->email,
            'address' => $validated['address'] ?? $professional->address,
            'employment_status' => $validated['employment_status'] ?? $professional->employment_status,
            'cvitae' => $validated['cvitae'] ?? $professional->cvitae,
            'user' => $validated['user'] ?? $professional->user,
            'password' => $validated['password'] ?: $professional->password,
            'key_code' => $validated['key_code'] ?? $professional->key_code,
        ]);

        // Update associated user if exists
        if ($professional->userAccount && $validated['password']) {
            $professional->userAccount->update([
                'password' => Hash::make($validated['password'])
            ]);
        }

        return redirect()->route('professionals_list')->with('success', 'Professional actualitzat correctament!');
    }

    /**
     * Activate Status
     */
    public function activateStatus(Request $request, String $professional_id)
    {
        $professional = Professional::findOrFail($professional_id);
        $professional->update(['status' => 1]);
        return redirect()->route('professionals_desactivated_list')->with('success', 'Professional activat correctament!');
    }

    /**
     * Deactivate Status
     */
    public function desactivateStatus(Request $request, String $professional_id)
    {
        $professional = Professional::findOrFail($professional_id);
        $professional->update(['status' => 0]);
        syslog(1, "Professional desactivat correctament!");
        return redirect()->route('professionals_list')->with('success', 'Professional desactivat correctament!');
    }

    /**
     * Display a listing of the desactivated professionals
     */
    public function index_desactivatedCenters()
    {
        $professionals = Professional::all();
        return view("components.contents.professional.professionalsDesactivatedList")->with('professionals', $professionals);
    }

    /**
     * Download CSV by status
     */
    public function downloadCSV(int $statusParam)
    {
        $professionals = Professional::where('status', $statusParam)->get();

        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = $statusParam == 1 ? "professionals_actius_{$timestamp}.csv" : "professionals_no_actius_{$timestamp}.csv";

        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['ID','Centre ID','Role','Name','Surname1','Surname2','DNI','Phone','Email','Address','Employment Status','CV','User','Password','Key Code','Status']);

        foreach ($professionals as $professional) {
            fputcsv($handle, [
                $professional->id,
                $professional->center_id,
                $professional->role,
                $professional->name,
                $professional->surname1,
                $professional->surname2,
                $professional->dni,
                $professional->phone,
                $professional->email,
                $professional->address,
                $professional->employment_status,
                $professional->cvitae,
                $professional->user,
                $professional->password,
                $professional->key_code,
                $professional->status == 1 ? 'Actiu' : 'No actiu',
            ]);
        }

        fclose($handle);
        return response()->download($filename)->deleteFileAfterSend(true);
    }

    /**
     * Download CSV with material assignments
     */
    public function downloadCSVMaterialAssignments()
    {
        $professionals = Professional::where('status', 1)->get();
        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = "professionals_assignacions_material_{$timestamp}.csv";
        $handle = fopen($filename, 'w+');

        fputcsv($handle, ['ID','Name','Surname','Shirt','Pants','Shoes','Assignment Date','Assigned By']);

        foreach ($professionals as $professional) {
            $shirtSize = MaterialAssignment::getLatestShirtSize($professional->id);
            $pantsSize = MaterialAssignment::getLatestPantsSize($professional->id);
            $shoeSize = MaterialAssignment::getLatestShoeSize($professional->id);
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
