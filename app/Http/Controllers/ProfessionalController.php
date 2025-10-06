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
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener todos los centros para el select
        // $centers = Center::all();
        // return view("professional.professionalForm", compact('centers'));
        return view("professional.professionalForm");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        // $request->validate([
        //     'name' => 'required|string|max:100',
        //     'surname1' => 'required|string|max:100',
        //     'surname2' => 'nullable|string|max:100',
        //     'center_id' => 'nullable|exists:centers,id',
        //     'role' => 'nullable|string|max:100',
        //     'phone' => 'nullable|string|max:20',
        //     'email' => 'nullable|email|max:255',
        //     'address' => 'nullable|string|max:500',
        //     'employment_status' => 'nullable|in:Actiu,Suplència,Baixa,No contractat',
        //     'cvitae' => 'nullable|string',
        //     'login' => 'nullable|string|max:50|unique:professionals,login',
        //     'password' => 'nullable|string|max:255',
        //     'key_code' => 'nullable|string|max:50',
        //     'shirt_size' => 'nullable|string|max:10',
        //     'pants_size' => 'nullable|string|max:10',
        //     'shoe_size' => 'nullable|string|max:10',
        // ]);

        // Crear el profesional con los datos del formulario
        Professional::create([
            'name' => $request->input('name'),
            'surname1' => $request->input('surname1'),
            'surname2' => $request->input('surname2'),
            'center_id' => $request->input('center_id'),
            'role' => $request->input('role'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            // 'employment_status' => $request->input('employment_status', 'Actiu'),
            'employment_status' => $request->input('employment_status'),
            'cvitae' => $request->input('cvitae'),
            'login' => $request->input('login'),
            'password' => $request->input('password'),
            'key_code' => $request->input('key_code'),
            'shirt_size' => $request->input('shirt_size'),
            'pants_size' => $request->input('pants_size'),
            'shoe_size' => $request->input('shoe_size'),
        ]);

        // Redirect a la página de bienvenida con mensaje de éxito
        return redirect('/')->with('success', 'Profesional creado correctamente');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
