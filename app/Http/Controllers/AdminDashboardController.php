<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Enums\VendeurStatus;
use App\Models\Annonce;
use App\Models\Categorie;
use App\Models\Commande;
use App\Models\Paiement;
use App\Models\Produit;
use App\Models\User;
use App\Models\Vendeur;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_users' => User::count(),
            'total_vendeurs' => Vendeur::count(),
            'vendeurs_approuves' => Vendeur::where('statut', VendeurStatus::APPROVED)->count(),
            'vendeurs_en_attente' => Vendeur::where('statut', VendeurStatus::PENDING)->count(),
            'total_produits' => Produit::count(),
            'total_commandes' => Commande::count(),
            'commandes_payees' => Commande::where('statut', OrderStatus::PAID)->count(),
            'commandes_en_cours' => Commande::where('statut', OrderStatus::IN_PROGRESS)->count(),
            'total_paiements' => Paiement::count(),
            'paiements_valides' => Paiement::where('statut', PaymentStatus::PAID)->count(),
            'montant_total_paiements' => Paiement::where('statut', PaymentStatus::PAID)->sum('montant'),
        ];

        return view('admin.dashboards.index', [
            'stats' => [
                'users' => $stats['total_users'],
                'vendeurs' => $stats['total_vendeurs'],
                'demandes' => $stats['vendeurs_en_attente'],
                'produits' => $stats['total_produits'],
                'commandes' => $stats['total_commandes'],
                'annonces' => Annonce::count(),
            ],
            'usersCount' => $stats['total_users'],
            'sellersCount' => $stats['total_vendeurs'],
            'productsCount' => $stats['total_produits'],
            'ordersCount' => $stats['total_commandes'],
            'categoriesCount' => Categorie::count(),
            'pendingProducts' => Produit::where('status', 'pending')->count(),
            'recentProducts' => Produit::with('categorie')->latest()->limit(5)->get(),
            'recent_commandes' => Commande::with('user')->latest()->limit(10)->get(),
            'recent_paiements' => Paiement::with('commande')->latest()->limit(10)->get(),
            'recent_vendeurs' => Vendeur::with('user')->latest()->limit(5)->get(),
            'recent_annonces' => Annonce::with('user')->latest()->limit(5)->get(),
        ]);
    }
}
