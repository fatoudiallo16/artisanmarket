<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
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

        $commandes = $query->with('paiement')->paginate(15);

        $view = Auth::user()->hasRole('admin') ? 'admin.commandes.index' : 'client.commandes.index';

        return view($view, compact('commandes'));
    }

    public function show(Commande $commande): View
    {
        $this->authorize('view', $commande);

        $commande->load(['lignecommandes.produit', 'paiement']);

        $view = Auth::user()->hasRole('admin') ? 'admin.commandes.show' : 'client.commandes.show';

        return view($view, compact('commande'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Commande::class);

        $data = $request->validate([
            'statut' => ['nullable', 'in:' . implode(',', array_column(OrderStatus::cases(), 'value'))],
        ]);

        $commande = Commande::create([
            'user_id' => Auth::id(),
            'statut' => $data['statut'] ?? OrderStatus::PENDING,
        ]);

        return redirect()->route($this->routeName('show'), $commande)->with('success', 'Commande creee.');
    }

    public function update(Request $request, Commande $commande): RedirectResponse
    {
        $this->authorize('update', $commande);

        $data = $request->validate([
            'statut' => ['required', 'in:' . implode(',', array_column(OrderStatus::cases(), 'value'))],
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
