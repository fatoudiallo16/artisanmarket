<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Commande;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ClientDashboardController extends Controller
{
    public function __construct(private CartService $cartService)
    {
    }

    public function index(): View
    {
        $user = Auth::user();

        $commandes = Commande::where('user_id', $user->id)
            ->with('lignecommandes.produit', 'paiement')
            ->latest()
            ->get();

        $totalDepense = $commandes
            ->where('statut', OrderStatus::PAID)
            ->flatMap->lignecommandes
            ->sum(fn ($l) => $l->quantite * $l->prix_unitaire);

        $cartCount = $this->cartService->getCartCount();
        $favorisCount = $user->favoris()->count();

        $recentCommandes = $commandes->take(5);

        return view('client.dashboard.index', [
            'commandesCount' => $commandes->count(),
            'cartCount' => $cartCount,
            'favorisCount' => $favorisCount,
            'totalDepense' => $totalDepense,
            'recentCommandes' => $recentCommandes,
        ]);
    }
}
