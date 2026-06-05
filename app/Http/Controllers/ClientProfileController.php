<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ClientProfileController extends Controller
{
    public function show(): View
    {
        $user = Auth::user();
        $user->loadMissing('role', 'clientProfile');

        return view('client.profil.edit', compact('user'));
    }
}
