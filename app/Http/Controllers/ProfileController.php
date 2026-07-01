<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show(): JsonResponse
    {
        $user = Auth::user();
        $user->loadMissing('role', 'clientProfile', 'vendeurProfile', 'adminProfile', 'vendeur');

        $profile = match ($user->role?->nom_role) {
            'client' => $user->clientProfile,
            'vendeur' => $user->vendeurProfile,
            'admin' => $user->adminProfile,
            default => null,
        };

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role?->nom_role,
            ],
            'profile' => $profile,
            'vendeur_request' => $user->vendeur,
        ]);
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        $user = Auth::user();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return back()->withErrors([
                'password' => 'Le mot de passe est incorrect.',
            ]);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome')->with('success', 'Votre compte a été supprimé avec succès.');
    }
}
