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
        return view("professional.professionalForm");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        echo "Professional afegit!";
        
        // Crear el profesional con los datos del formulario
        Professional::create([
            'center_id' => $request->input('center_id'),
            'role' => $request->input('role'),
            'name' => $request->input('name'),
            'surname1' => $request->input('surname1'),
            'surname2' => $request->input('surname2'),
            'dni' => $request->input('dni'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'employment_status' => $request->input('employment_status'),
            'cvitae' => $request->input('cvitae'),
            'login' => $request->input('login'),
            'password' => $request->input('password'), // Si quieres, luego puedes encriptarla con bcrypt()
            'key_code' => $request->input('key_code'),
            'shirt_size' => $request->input('shirt_size'),
            'pants_size' => $request->input('pants_size'),
            'shoe_size' => $request->input('shoe_size'),
        ]);

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
