<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Vendeur;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class VendeurController extends Controller
{
    public function requestAccess(Request $request): JsonResponse
    {
        $user = Auth::user();
        $clientRole = Role::where('nom_role', 'client')->first();

        if (!$user || !$clientRole || (int) $user->role_id !== (int) $clientRole->id) {
            return response()->json(['message' => 'Seuls les clients peuvent envoyer une demande.'], 403);
        }

        $existing = Vendeur::where('user_id', $user->id)->first();
        if ($existing && $existing->statut === 'en_attente') {
            return response()->json(['message' => 'Une demande est deja en attente.'], 422);
        }

        $data = $request->validate([
            'nom_boutique' => ['required', 'string', 'max:255'],
        ]);

        $vendeur = Vendeur::updateOrCreate(
            ['user_id' => $user->id],
            [
                'id_utilisateur' => $user->id,
                'name' => $user->name,
                'nom_boutique' => $data['nom_boutique'],
                'statut' => 'en_attente',
            ]
        );

        return response()->json([
            'message' => 'Demande vendeur envoyee avec succes.',
            'vendeur' => $vendeur,
        ], 201);
    }

    public function index(Request $request)
    {
        $vendeurs = Vendeur::with('user')->latest()->paginate(20);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json($vendeurs);
        }

        return view('admin.vendeurs.index', compact('vendeurs'));
    }

    public function show(Vendeur $vendeur): JsonResponse
    {
        $vendeur->load('user', 'produits');

        return response()->json($vendeur);
    }

    public function update(Request $request, Vendeur $vendeur)
    {
        $data = $request->validate([
            'statut' => ['sometimes', 'in:en_attente,approuve,suspendu,rejete'],
            'name' => ['sometimes', 'string', 'max:255'],
            'nom_boutique' => ['sometimes', 'string', 'max:255'],
        ]);

        if (!empty($data)) {
            $vendeur->update($data);
            if (array_key_exists('statut', $data)) {
                $this->syncUserRoleFromStatus($vendeur);
            }
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Vendeur mis a jour.',
                'vendeur' => $vendeur->fresh(['user']),
            ]);
        }

        return back()->with('success', 'Statut du vendeur mis à jour.');
    }

    public function destroy(Vendeur $vendeur): JsonResponse
    {
        $this->setUserRole($vendeur->user_id, 'client');
        $vendeur->delete();

        return response()->json([
            'message' => 'Vendeur supprime.',
        ]);
    }

    private function syncUserRoleFromStatus(Vendeur $vendeur): void
    {
        if ($vendeur->statut === 'approuve') {
            $this->setUserRole($vendeur->user_id, 'vendeur');
            return;
        }

        if (in_array($vendeur->statut, ['rejete', 'suspendu'], true)) {
            $this->setUserRole($vendeur->user_id, 'client');
        }
    }

    private function setUserRole(int $userId, string $roleName): void
    {
        $role = Role::where('nom_role', $roleName)->first();
        if (!$role) {
            return;
        }

        $vendeurUser = \App\Models\User::find($userId);
        if (!$vendeurUser) {
            return;
        }

        $vendeurUser->role_id = $role->id;
        $vendeurUser->save();
        $vendeurUser->load('role');
        $vendeurUser->syncProfileByRole();
    }
}
