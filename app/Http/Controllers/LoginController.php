<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Professional;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Show login form
    public function show()
    {
        return view('login');
    }

    // Handle login POST
    public function login(Request $request)
    {
        $request->validate([
            'user' => 'required|string',
            'password' => 'required|string',
        ]);

        // Search professional by username
        $professional = Professional::where('user', $request->input('user'))->where('status', 1)->first();

        // Check password and authenticate
        if ($professional && Hash::check($request->input('password'), $professional->password)) {
            Auth::login($professional); // manual login
            $request->session()->regenerate(); // security
            return redirect()->route('home'); // redirect to /home
        }

        // Incorrect credentials
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
