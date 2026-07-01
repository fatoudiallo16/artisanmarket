<?php

namespace App\Http\Controllers;

use App\Enums\VendeurStatus;
use App\Models\Role;
use App\Models\Vendeur;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class VendeurController extends Controller
{
    public function requestAccess(Request $request): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $user = Auth::user();
        $clientRole = Role::where('nom_role', 'client')->first();

        if (!$user || !$clientRole || (int) $user->role_id !== (int) $clientRole->id) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['message' => 'Seuls les clients peuvent envoyer une demande.'], 403);
            }
            return redirect()->back()->with('error', 'Seuls les clients peuvent envoyer une demande.');
        }

        $existing = Vendeur::where('user_id', $user->id)->first();
        if ($existing && $existing->statut === VendeurStatus::PENDING) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['message' => 'Une demande est deja en attente.'], 422);
            }
            return redirect()->back()->with('error', 'Une demande est déjà en attente.');
        }

        $data = $request->validate([
            'nom_boutique' => ['required', 'string', 'max:255'],
        ]);

        $vendeur = Vendeur::updateOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $user->name,
                'nom_boutique' => $data['nom_boutique'],
                'statut' => VendeurStatus::PENDING,
            ]
        );

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Demande vendeur envoyee avec succes.',
                'vendeur' => $vendeur,
            ], 201);
        }

        return redirect()->back()->with('success', 'Votre demande vendeur a été envoyée avec succès.');
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
            'statut' => ['sometimes', 'in:' . implode(',', array_column(VendeurStatus::cases(), 'value'))],
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

    public function destroy(Vendeur $vendeur)
    {
        $this->setUserRole($vendeur->user_id, 'client');
        $vendeur->delete();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'message' => 'Vendeur supprime.',
            ]);
        }

        return redirect()->route('admin.vendeurs.index')->with('success', 'Vendeur supprimé.');
    }

    private function syncUserRoleFromStatus(Vendeur $vendeur): void
    {
        if ($vendeur->statut === VendeurStatus::APPROVED) {
            $this->setUserRole($vendeur->user_id, 'vendeur');
            return;
        }

        if (in_array($vendeur->statut, [VendeurStatus::REJECTED, VendeurStatus::SUSPENDED], true)) {
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
