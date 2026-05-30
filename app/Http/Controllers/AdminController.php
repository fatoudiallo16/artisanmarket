<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Annonce;
use App\Models\Paiement;
use App\Models\Produit;
use App\Models\User;
use App\Models\Vendeur;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Afficher le dashboard admin avec les statistiques
     */
    public function dashboard(): View
    {
        $stats = [
            'total_users' => User::count(),
            'total_vendeurs' => Vendeur::count(),
            'vendeurs_approuves' => Vendeur::where('statut', 'approuve')->count(),
            'vendeurs_en_attente' => Vendeur::where('statut', 'en_attente')->count(),
            'total_produits' => Produit::count(),
            'total_commandes' => Commande::count(),
            'commandes_payees' => Commande::where('statut', 'payee')->count(),
            'commandes_en_cours' => Commande::where('statut', 'en_cours')->count(),
            'total_paiements' => Paiement::count(),
            'paiements_valides' => Paiement::where('statut', 'paye')->count(),
            'montant_total_paiements' => Paiement::where('statut', 'paye')->sum('montant'),
        ];

        $recent_commandes = Commande::with('user')->latest()->limit(10)->get();
        $recent_paiements = Paiement::with('commande')->latest()->limit(10)->get();
        $recent_vendeurs = Vendeur::with('user')->latest()->limit(5)->get();

        $recent_annonces = Annonce::with('user')->latest()->limit(5)->get();

        return view('admin.dashboards.index', [
            'stats' => [
                'users' => $stats['total_users'],
                'vendeurs' => $stats['total_vendeurs'],
                'demandes' => $stats['vendeurs_en_attente'],
                'produits' => $stats['total_produits'],
                'commandes' => $stats['total_commandes'],
                'annonces' => Annonce::count(),
            ],
            'recent_commandes' => $recent_commandes,
            'recent_paiements' => $recent_paiements,
            'recent_vendeurs' => $recent_vendeurs,
            'recent_annonces' => $recent_annonces,
        ]);
    }

    /**
     * Afficher les statistiques détaillées
     */
    public function statistics(): RedirectResponse
    {
        $stats = [
            'users_by_role' => User::selectRaw('role_id, count(*) as count')
                ->with('role')
                ->groupBy('role_id')
                ->get(),
            'produits_by_categorie' => Produit::selectRaw('categorie_id, count(*) as count, SUM(stock) as total_stock')
                ->groupBy('categorie_id')
                ->get(),
            'commandes_by_statut' => Commande::selectRaw('statut, count(*) as count')
                ->groupBy('statut')
                ->get(),
            'paiements_by_statut' => Paiement::selectRaw('statut, count(*) as count')
                ->groupBy('statut')
                ->get(),
        ];

        return redirect()->route('admin.dashboard');
    }

    /**
     * Afficher la page de gestion des rôles et permissions
     */
    public function settings(): RedirectResponse
    {
        return redirect()->route('admin.dashboard');
    }
}
