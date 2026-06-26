<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Categorie;
use App\Models\Commande;
use App\Models\Produit;
use App\Models\User;
use App\Models\Vendeur;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        $user->loadMissing('role', 'vendeur', 'vendeurProfile');

        if ($user->hasRole('admin')) {
            return view('admin.dashboards.index', [
                'stats' => [
                    'users' => User::count(),
                    'vendeurs' => Vendeur::count(),
                    'demandes' => Vendeur::where('statut', 'en_attente')->count(),
                    'produits' => Produit::count(),
                    'commandes' => Commande::count(),
                    'annonces' => Annonce::count(),
                ],
                'usersCount' => User::count(),
                'productsCount' => Produit::count(),
                'categoriesCount' => Categorie::count(),
                'pendingProducts' => Produit::where('status', 'pending')->count(),
                'recentProducts' => Produit::with('categorie')->latest()->limit(5)->get(),
                'recent_vendeurs' => Vendeur::with('user')->latest()->limit(6)->get(),
                'recent_annonces' => Annonce::with('user')->latest()->limit(5)->get(),
            ]);
        }

        if ($user->hasRole('vendeur')) {
            $vendeur = $user->vendeur;
            $produits = $vendeur ? $vendeur->produits()->with('categorie')->latest()->get() : collect();

            $salesCount = 0;
            $productsSold = 0;
            $revenue = 0;
            $recentSales = collect();

            if ($vendeur) {
                // Get all paid orders containing products of this seller
                $salesCount = \App\Models\Commande::where('statut', 'payee')
                    ->whereHas('lignecommandes.produit', function ($q) use ($vendeur) {
                        $q->where('vendeur_id', $vendeur->id);
                    })->count();

                // Sum of quantities of products sold in paid orders
                $productsSold = (int) \App\Models\Lignecommande::whereHas('commande', function ($q) {
                    $q->where('statut', 'payee');
                })->whereHas('produit', function ($q) use ($vendeur) {
                    $q->where('vendeur_id', $vendeur->id);
                })->sum('quantite');

                // Sum of revenue (quantite * prix_unitaire) in paid orders
                $revenue = (float) \App\Models\Lignecommande::whereHas('commande', function ($q) {
                    $q->where('statut', 'payee');
                })->whereHas('produit', function ($q) use ($vendeur) {
                    $q->where('vendeur_id', $vendeur->id);
                })->sum(\Illuminate\Support\Facades\DB::raw('quantite * prix_unitaire'));

                // Get recent sales (order lines)
                $recentSales = \App\Models\Lignecommande::with(['commande.user', 'produit'])
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

        if ($user->hasRole('client')) {
            return redirect()->route('client.dashboard');
        }

        return redirect()->route('welcome');
    }
}
