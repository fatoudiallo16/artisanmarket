<?php

namespace App\Policies;

use App\Models\Produit;
use App\Models\User;

class ProduitPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Produit $produit): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('vendeur', 'admin');
    }

    public function update(User $user, Produit $produit): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        if (!$user->hasRole('vendeur') || !$user->vendeur) {
            return false;
        }

        return (int) $produit->vendeur_id === (int) $user->vendeur->id;
    }

    public function delete(User $user, Produit $produit): bool
    {
        return $this->update($user, $produit);
    }
}
