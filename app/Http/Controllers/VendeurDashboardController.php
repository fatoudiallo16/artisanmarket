<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Commande;
use App\Models\Lignecommande;
use App\Models\User;
use App\Models\Vendeur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class VendeurDashboardController extends Controller
{
    public function index(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $vendeur = $user->vendeur;
        $produits = $vendeur ? $vendeur->produits()->with('categorie')->latest()->get() : collect();

        $salesCount = 0;
        $productsSold = 0;
        $revenue = 0;
        $recentSales = collect();

        if ($vendeur) {
            $salesCount = Commande::where('statut', OrderStatus::PAID)
                ->whereHas('lignecommandes.produit', function ($q) use ($vendeur) {
                    $q->where('vendeur_id', $vendeur->id);
                })->count();

            $productsSold = (int) Lignecommande::whereHas('commande', function ($q) {
                $q->where('statut', OrderStatus::PAID);
            })->whereHas('produit', function ($q) use ($vendeur) {
                $q->where('vendeur_id', $vendeur->id);
            })->sum('quantite');

            $revenue = (float) Lignecommande::whereHas('commande', function ($q) {
                $q->where('statut', OrderStatus::PAID);
            })->whereHas('produit', function ($q) use ($vendeur) {
                $q->where('vendeur_id', $vendeur->id);
            })->sum(DB::raw('quantite * prix_unitaire'));

            $recentSales = Lignecommande::with(['commande.user', 'produit'])
                ->whereHas('produit', function ($q) use ($vendeur) {
                    $q->where('vendeur_id', $vendeur->id);
                })
                ->latest()
                ->limit(10)
                ->get();
        }

        return view('vendeur.dashboard.index', [
            'vendeur' => $vendeur,
            'produits' => $produits,
            'productsCount' => $produits->count(),
            'approvedProducts' => $produits->where('status', 'approved')->count(),
            'pendingProducts' => $produits->where('status', 'pending')->count(),
            'recentProducts' => $produits->take(5),
            'categoriesCount' => $vendeur ? $vendeur->produits()->distinct('categorie_id')->count('categorie_id') : 0,
            'salesCount' => $salesCount,
            'productsSold' => $productsSold,
            'revenue' => $revenue,
            'recentSales' => $recentSales,
        ]);
    }
}
