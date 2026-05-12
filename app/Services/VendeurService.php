<?php

namespace App\Services;

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
        $vendeur->update(['statut' => 'approuve']);
        
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
        $vendeur->update(['statut' => 'rejete']);
        
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
        $vendeur->update(['statut' => 'suspendu']);
        
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
        return [
            'total_produits' => $vendeur->produits()->count(),
            'total_ventes' => $vendeur->produits()->sum('stock'),
            'produits_actifs' => $vendeur->produits()->where('stock', '>', 0)->count(),
            'note_moyenne' => 0, // TODO: implémenter système de notation
        ];
    }
}
