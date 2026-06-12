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

            return view('vendeur.dashboard.index', [
                'vendeur' => $vendeur,
                'produits' => $produits,
                'productsCount' => $produits->count(),
                'approvedProducts' => $produits->where('status', 'approved')->count(),
                'pendingProducts' => $produits->where('status', 'pending')->count(),
                'recentProducts' => $produits->take(5),
                'categoriesCount' => $vendeur ? $vendeur->produits()->distinct('categorie_id')->count('categorie_id') : 0,
                'revenue' => 0,
            ]);
        }

        if ($user->hasRole('client')) {
            return redirect()->route('client.dashboard');
        }

        return redirect()->route('welcome');
    }
}
