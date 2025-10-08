<?php

namespace App\Http\Controllers;

use App\Models\Professional;
use App\Models\Center;
use Illuminate\Http\Request;

class ProfessionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // TODO: No utilizar, crear @ filter para que sólo se muestren los profesionales con status = 1
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
            'shirt_size' => 'nullable|string|max:10',
            'pants_size' => 'nullable|string|max:10',
            'shoe_size' => 'nullable|string|max:10',
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
            'employment_status' => $validated['employment_status'],
            'cvitae' => $validated['cvitae'],
            'login' => $validated['login'],
            // 'password' => $validated['password'] ? bcrypt($validated['password']) : null, // Encriptar la contraseña
            'password' => $validated['password'],
            'key_code' => $validated['key_code'],
            'shirt_size' => $validated['shirt_size'],
            'pants_size' => $validated['pants_size'],
            'shoe_size' => $validated['shoe_size'],
            'status' => 1, // Considerar si es necesario o utiliza employment_status
        ]);

        return redirect()->route('professional_form')->with('success', 'Professional afegit correctament!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
            'shirt_size' => 'nullable|string|max:10',
            'pants_size' => 'nullable|string|max:10',
            'shoe_size' => 'nullable|string|max:10',
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
            'shirt_size' => $validated['shirt_size'],
            'pants_size' => $validated['pants_size'],
            'shoe_size' => $validated['shoe_size'],
        ]);

        return redirect()->route('professionals_list')->with('success', 'Professional actualitzat correctament!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
public function indexActive()
{
    // Assuming 'status' is a column in the 'professionals' table
    $professionals = Professional::where('status', '!=', 0)->get();
    return view('components.contents.professional.professionalsList', compact('professionals'));
}
}
