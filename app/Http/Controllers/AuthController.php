<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate the login credentials
        // ...

        // Attempt to log the user in
        // ...

        return redirect()->intended('dashboard')->with('success', 'Logged in successfully.');
    }

    public function logout()
    {
        // Log the user out
        // ...

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
