<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Professional;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Mostrar formulario de login
    public function show()
    {
        return view('login');
    }

    // Manejar POST de login
    public function login(Request $request)
    {
        $request->validate([
            'user' => 'required|string',
            'password' => 'required|string',
        ]);

        // Buscar profesional por username
        $professional = Professional::where('user', $request->input('user'))->where('status', 1)->first();

        // Check password and authenticate
        if ($professional && Hash::check($request->input('password'), $professional->password)) {
            Auth::login($professional); // login manual
            $request->session()->regenerate(); // seguridad
            return redirect()->route('home'); // redirige a /home
        }

        // Credenciales incorrectas
        return back()->with('error', 'Usuari o contrasenya incorrectes')->withInput($request->only('user'));
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
