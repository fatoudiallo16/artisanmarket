<?php

namespace App\Policies;

use App\Models\Paiement;
use App\Models\User;

class PaiementPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('client', 'admin');
    }

    public function view(User $user, Paiement $paiement): bool
    {
        return $user->hasRole('admin')
            || ((int) ($paiement->commande->user_id ?? 0) === (int) $user->id);
    }

    public function create(User $user): bool
    {
        return $user->hasRole('client', 'admin');
    }

    public function update(User $user, Paiement $paiement): bool
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, Paiement $paiement): bool
    {
        return $user->hasRole('admin');
    }
}
