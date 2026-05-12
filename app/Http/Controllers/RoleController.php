<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleController extends Controller
{
    /**
     * Afficher la liste des rôles
     */
    public function index(): JsonResponse
    {
        return response()->json(Role::latest()->paginate(20));
    }

    /**
     * Afficher un rôle spécifique
     */
    public function show(Role $role): JsonResponse
    {
        return response()->json($role);
    }

    /**
     * Créer un nouveau rôle
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nom_role' => ['required', 'string', 'max:100', 'unique:roles,nom_role'],
            'description' => ['nullable', 'string'],
        ]);

        $role = Role::create($data);

        return response()->json([
            'message' => 'Rôle créé avec succès.',
            'role' => $role,
        ], 201);
    }

    /**
     * Mettre à jour un rôle
     */
    public function update(Request $request, Role $role): JsonResponse
    {
        $data = $request->validate([
            'nom_role' => ['required', 'string', 'max:100', 'unique:roles,nom_role,'.$role->id],
            'description' => ['nullable', 'string'],
        ]);

        $role->update($data);

        return response()->json([
            'message' => 'Rôle mis à jour.',
            'role' => $role->fresh(),
        ]);
    }

    /**
     * Supprimer un rôle
     */
    public function destroy(Role $role): JsonResponse
    {
        $role->delete();

        return response()->json([
            'message' => 'Rôle supprimé.',
        ]);
    }
}
