<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
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
                'recent_vendeurs' => Vendeur::with('user')->latest()->limit(6)->get(),
                'recent_annonces' => Annonce::with('user')->latest()->limit(5)->get(),
            ]);
        }

        if ($user->hasRole('vendeur')) {
            $vendeur = $user->vendeur;

            return view('vendeur.dashboard.index', [
                'vendeur' => $vendeur,
                'produits' => $vendeur ? $vendeur->produits()->with('categorie')->latest()->get() : collect(),
                'categoriesCount' => $vendeur ? $vendeur->produits()->distinct('categorie_id')->count('categorie_id') : 0,
            ]);
        }

        return redirect()->route('welcome');
    }
}
