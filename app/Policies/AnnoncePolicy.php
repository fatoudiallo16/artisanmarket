<?php

namespace App\Policies;

use App\Models\Annonce;
use App\Models\User;

class AnnoncePolicy
{
    /**
     * Determine whether the user can view any annonces.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the annonce.
     */
    public function view(?User $user, Annonce $annonce): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create annonces.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the annonce.
     */
    public function update(User $user, Annonce $annonce): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the annonce.
     */
    public function delete(User $user, Annonce $annonce): bool
    {
        return $user->hasRole('admin');
    }
}
