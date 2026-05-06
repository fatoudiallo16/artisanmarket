<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;

class CommandeController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Commande::class);

        $query = Commande::query()->latest();
        if (!Auth::user()->hasRole('admin')) {
            $query->where('user_id', Auth::id());
        }

        $commandes = $query->paginate(15);

        return view('commandes.index', compact('commandes'));
    }

    public function show(Commande $commande): View
    {
        $this->authorize('view', $commande);

        return view('commandes.show', compact('commande'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Commande::class);

        $data = $request->validate([
            'statut' => ['nullable', 'in:en_attente,en_cours,payee,annulee'],
        ]);

        $commande = Commande::create([
            'user_id' => Auth::id(),
            'statut' => $data['statut'] ?? 'en_attente',
        ]);

        return redirect()->route($this->routeName('show'), $commande)->with('success', 'Commande creee.');
    }

    public function update(Request $request, Commande $commande): RedirectResponse
    {
        $this->authorize('update', $commande);

        $data = $request->validate([
            'statut' => ['required', 'in:en_attente,en_cours,payee,annulee'],
        ]);

        $commande->update($data);

        return redirect()->route($this->routeName('show'), $commande)->with('success', 'Commande mise a jour.');
    }

    public function destroy(Commande $commande): RedirectResponse
    {
        $this->authorize('delete', $commande);

        $commande->delete();

        return redirect()->route($this->routeName('index'))->with('success', 'Commande supprimee.');
    }

    private function routeName(string $action): string
    {
        $adminRoute = 'admin.commandes.'.$action;
        if (Route::has($adminRoute) && request()->routeIs('admin.*')) {
            return $adminRoute;
        }

        return 'commandes.'.$action;
    }
}
