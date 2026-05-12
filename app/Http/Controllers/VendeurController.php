<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Vendeur;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class VendeurController extends Controller
{
    public function requestAccess(Request $request): JsonResponse|RedirectResponse
    {
        $user = Auth::user();
        $clientRole = Role::where('nom_role', 'client')->first();

        if (!$user || !$clientRole || (int) $user->role_id !== (int) $clientRole->id) {
            if (!$request->expectsJson()) {
                return back()->with('error', 'Seuls les clients peuvent envoyer une demande.');
            }
            return response()->json(['message' => 'Seuls les clients peuvent envoyer une demande.'], 403);
        }

        $existing = Vendeur::where('user_id', $user->id)->first();
        if ($existing && $existing->statut === 'en_attente') {
            if (!$request->expectsJson()) {
                return back()->with('error', 'Une demande est deja en attente.');
            }
            return response()->json(['message' => 'Une demande est deja en attente.'], 422);
        }

        $data = $request->validate([
            'nom_boutique' => ['required', 'string', 'max:255'],
            'description_boutique' => ['nullable', 'string', 'max:2000'],
            'telephone' => ['nullable', 'string', 'max:40'],
            'adresse' => ['nullable', 'string', 'max:255'],
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

        $user->vendeurProfile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'nom_boutique' => $data['nom_boutique'],
                'description_boutique' => $data['description_boutique'] ?? null,
                'telephone' => $data['telephone'] ?? null,
                'adresse' => $data['adresse'] ?? null,
            ]
        );

        if (!$request->expectsJson()) {
            return back()->with('success', 'Votre demande vendeur a ete envoyee. Un admin doit la valider.');
        }

        return response()->json([
            'message' => 'Demande vendeur envoyee avec succes.',
            'vendeur' => $vendeur,
        ], 201);
    }

    public function index(Request $request): JsonResponse|View
    {
        $vendeurs = Vendeur::with('user')->latest()->paginate(20);

        if (!$request->expectsJson()) {
            return view('vendeurs.index', compact('vendeurs'));
        }

        return response()->json($vendeurs);
    }

    public function show(Request $request, Vendeur $vendeur): JsonResponse|View
    {
        $vendeur->load('user.vendeurProfile', 'produits.categorie');

        if (!$request->expectsJson()) {
            return view('vendeurs.show', compact('vendeur'));
        }

        return response()->json($vendeur);
    }

    public function update(Request $request, Vendeur $vendeur): JsonResponse|RedirectResponse
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

        if (!$request->expectsJson()) {
            return back()->with('success', 'Demande vendeur mise a jour.');
        }

        return response()->json([
            'message' => 'Vendeur mis a jour.',
            'vendeur' => $vendeur->fresh(['user']),
        ]);
    }

    public function destroy(Request $request, Vendeur $vendeur): JsonResponse|RedirectResponse
    {
        $this->setUserRole($vendeur->user_id, 'client');
        $vendeur->delete();

        if (!$request->expectsJson()) {
            return redirect()->route('admin.vendeurs.index')->with('success', 'Demande vendeur supprimee.');
        }

        return response()->json([
            'message' => 'Vendeur supprime.',
        ]);
    }

    public function updateBoutique(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $data = $request->validate([
            'nom_boutique' => ['required', 'string', 'max:255'],
            'description_boutique' => ['nullable', 'string', 'max:2000'],
            'telephone' => ['nullable', 'string', 'max:40'],
            'adresse' => ['nullable', 'string', 'max:255'],
        ]);

        $vendeur = $user->vendeur;
        if (!$vendeur) {
            abort(403, 'Aucun profil vendeur associe a ce compte.');
        }

        $vendeur->update([
            'nom_boutique' => $data['nom_boutique'],
            'name' => $user->name,
        ]);

        $user->vendeurProfile()->updateOrCreate(['user_id' => $user->id], $data);

        return back()->with('success', 'Boutique mise a jour.');
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
