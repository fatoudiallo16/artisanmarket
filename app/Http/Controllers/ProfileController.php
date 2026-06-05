<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

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
}
