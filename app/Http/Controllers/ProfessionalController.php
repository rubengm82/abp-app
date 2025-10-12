<?php

namespace App\Http\Controllers;

use App\Models\Professional;
use App\Models\Center; //TODO: Necesario?
use App\Models\MaterialAssignment;
use Illuminate\Http\Request;

class ProfessionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // TODO: Considerar añadir un filtro en la sql
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
        // Validar los datos del formulario
        $validated = $request->validate([
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
            'login' => 'nullable|string|max:100|unique:professionals,login',
            'password' => 'nullable|string|min:6',
            'key_code' => 'nullable|string|max:50',
        ]);

        // Crear el profesional con los datos validados
        Professional::create([
            'center_id' => $validated['center_id'] ?? null,
            'role' => $validated['role'],
            'name' => $validated['name'],
            'surname1' => $validated['surname1'],
            'surname2' => $validated['surname2'],
            'dni' => $validated['dni'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'employment_status' => $validated['employment_status'] ?? 'Actiu',
            'cvitae' => $validated['cvitae'],
            'login' => $validated['login'],
            // 'password' => $validated['password'] ? bcrypt($validated['password']) : null, // Encriptar la contraseña
            'password' => $validated['password'],
            'key_code' => $validated['key_code'],
            'status' => 1, // Considerar si es necesario o utiliza employment_status
        ]);

        return redirect()->route('professional_form')->with('success', 'Professional afegit correctament!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $professional = Professional::findOrFail($id);
        return view('components.contents.professional.professionalShow')->with('professional', $professional);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $professional = Professional::findOrFail($id);// Why findOrFail? Because if the professional is not found, it will throw an error
        return view("components.contents.professional.professionalEdit")->with('professional', $professional);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $professional = Professional::findOrFail($id);
        
        // Validar los datos del formulario
        $validated = $request->validate([
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
            'login' => 'nullable|string|max:100|unique:professionals,login,' . $id,
            'password' => 'nullable|string|min:6',
            'key_code' => 'nullable|string|max:50',
        ]);

        // Actualizar el profesional con los datos validados
        $professional->update([
            'center_id' => $validated['center_id'] ?? $professional->center_id, // keep the center_id if it is not provided
            'role' => $validated['role'],
            'name' => $validated['name'],
            'surname1' => $validated['surname1'],
            'surname2' => $validated['surname2'],
            'dni' => $validated['dni'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'employment_status' => $validated['employment_status'],
            'cvitae' => $validated['cvitae'],
            'login' => $validated['login'],
            'password' => $validated['password'] ?: $professional->password, // keep the password if it is not provided
            'key_code' => $validated['key_code'],
        ]);

        return redirect()->route('professionals_list')->with('success_updated', 'Professional actualitzat correctament!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /* *********** */
    /* OWN METHODS */
    /* *********** */
    
    /**
     * Display a listing of the resource.
     */
    public function index_desactivatedCenters()
    {
        $professionals = Professional::all();
        return view("components.contents.professional.professionalsDesactivatedList")->with('professionals', $professionals);
    }

    /**
     * Activate Status the specified resource in storage.
     */
    public function activateStatus(Request $request, String $professional_id)
    {
        $professional = Professional::findOrFail($professional_id);
        $professional->update(['status' => 1]);

        // $professional->status = 1;
        // $professional->save();
        
        return redirect()->route('professionals_desactivated_list')->with('success_activated', 'Professional activat correctament!');;;
    }

    /**
     * Desactivate Status the specified resource in storage.
     */
    public function desactivateStatus(Request $request, String $professional_id)
    {

        $professional = Professional::findOrFail($professional_id);

        $professional->update(['status' => 0]);

        // $professional->status = 0;
        // $professional->save();
        syslog(1, "Professional desactivat correctament!");
        return redirect()->route('professionals_list')->with('success_desactivated', 'Professional desactivat correctament!');;
    }

    /**
     * Download CSV from resource in storage
     */
    public function downloadCSV(int $statusParam)
    {
        $professionals = Professional::where('status', $statusParam)->get();

        $filename = $statusParam == 1 ? "professionals_actius.csv" : "professionals_actius_no_actius.csv";

        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['ID', 'Centre ID', 'Rol', 'Nom', 'Cognom 1', 'Cognom 2', 'DNI', 'Telèfon', 'Email', 'Adreça', 'Situació laboral', 'Currículum', 'Usuari', 'Contrasenya', 'Codi clau', 'Estat']);

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
                $professional->login,
                $professional->password,
                $professional->key_code,
                $professional->status == 1 ? 'Actiu' : 'No actiu',
            ]);
        }

        // Close Pointer File
        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }

    /**
     * Download CSV with material assignments for professionals (new method).
     */
    //TODO: Revisar si es necesario tenerlo aquí o en el modelo de MaterialAssignment
    public function downloadCSVMaterialAssignments()
    {
        $professionals = Professional::where('status', 1)->get();
        
        $filename = "professionals_assignacions_material.csv";
        
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['ID', 'Nom', 'Cognom', 'Samarreta', 'Pantaló', 'Sabata', 'Data Assignació', 'Assignat per']);
        
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
