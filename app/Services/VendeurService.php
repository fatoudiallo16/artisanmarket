<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Enums\VendeurStatus;
use App\Models\Lignecommande;
use App\Models\Vendeur;
use App\Models\Role;
use App\Models\User;

class VendeurService
{
    /**
     * Approuver une demande de vendeur
     */
    public function approveVendeur(Vendeur $vendeur): void
    {
        $vendeur->update(['statut' => VendeurStatus::APPROVED]);
        
        // Mettre à jour le rôle de l'utilisateur
        $role = Role::where('nom_role', 'vendeur')->first();
        if ($role) {
            $vendeur->user->update(['role_id' => $role->id]);
        }
    }

    /**
     * Rejeter une demande de vendeur
     */
    public function rejectVendeur(Vendeur $vendeur): void
    {
        $vendeur->update(['statut' => VendeurStatus::REJECTED]);
        
        // Remettre le rôle client
        $role = Role::where('nom_role', 'client')->first();
        if ($role) {
            $vendeur->user->update(['role_id' => $role->id]);
        }
    }

    /**
     * Suspendre un vendeur
     */
    public function suspendVendeur(Vendeur $vendeur): void
    {
        $vendeur->update(['statut' => VendeurStatus::SUSPENDED]);
        
        // Remettre le rôle client
        $role = Role::where('nom_role', 'client')->first();
        if ($role) {
            $vendeur->user->update(['role_id' => $role->id]);
        }
    }

    /**
     * Obtenir les statistiques d'un vendeur
     */
    public function getVendeurStats(Vendeur $vendeur): array
    {
        $produitIds = $vendeur->produits()->pluck('id');

        $totalVentes = (int) Lignecommande::query()
            ->whereIn('produit_id', $produitIds)
            ->whereHas('commande', fn ($q) => $q->whereIn('statut', [OrderStatus::PAID, OrderStatus::IN_PROGRESS]))
            ->sum('quantite');

        return [
            'total_produits' => $vendeur->produits()->count(),
            'total_ventes' => $totalVentes,
            'produits_actifs' => $vendeur->produits()->where('stock', '>', 0)->count(),
            'note_moyenne' => 0,
        ];
    }
}
