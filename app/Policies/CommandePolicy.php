<?php

namespace App\Policies;

use App\Models\Commande;
use App\Models\User;

class CommandePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('client', 'admin');
    }

    public function view(User $user, Commande $commande): bool
    {
        return $user->hasRole('admin') || (int) $commande->user_id === (int) $user->id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('client', 'admin');
    }

    public function update(User $user, Commande $commande): bool
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, Commande $commande): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return $user->hasRole('client')
            && (int) $commande->user_id === (int) $user->id
            && in_array($commande->statut, ['en_attente', 'en_cours'], true);
    }
}
