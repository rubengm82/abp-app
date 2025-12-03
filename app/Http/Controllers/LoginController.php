<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Professional;
use App\Models\Center;
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
            if ($professional->role === 'Gerent') {
                // For Gerent, show center selection modal
                $request->session()->put('pending_professional', $professional->id);
                $centers = Center::where('status', 1)->get();  // get all active centers
                return view('login', ['centers' => $centers, 'show_modal' => true]);
            } else {
                Auth::login($professional); // manual login
                $request->session()->regenerate(); // security
                return redirect()->route('home'); // redirect to /home
            }
        }

        // Incorrect credentials
        return back()->with('error', 'Usuari o contrasenya incorrectes')->withInput($request->only('user'));
    }

    // Handle center selection for Gerent role
    public function selectCenter(Request $request)
    {
        $request->validate([
            'center_id' => 'required|exists:centers,id',
        ]);

        $redirectRoute = null; 

        $professional_id = $request->session()->get('pending_professional');

        if (!$professional_id) {
            $redirectRoute = redirect()->route('login')->with('error', 'Sessió expirada');
        }

        if ($professional_id) {
            $professional = Professional::find($professional_id);

            if (!$professional || $professional->role !== 'Gerent') {
                $redirectRoute = redirect()->route('login')->with('error', 'Accés denegat');
            } else {
                $professional->update(['center_id' => $request->center_id]);
                $request->session()->forget('pending_professional');
                Auth::login($professional);
                $request->session()->regenerate();

                $redirectRoute = redirect()->route('home');
            }
        }

        return $redirectRoute;
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
