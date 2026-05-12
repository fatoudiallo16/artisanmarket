<?php

namespace App\Traits;

/**
 * Trait pour les méthodes de rôle et profil utilisateur
 * Note: Ce trait est une référence. Les méthodes sont définies dans le modèle User directement.
 */
trait HasRoleAndProfile
{
    /**
     * Vérifier si l'utilisateur a un des rôles
     *
     * @param  string  ...$roles
     * @return bool
     */
    abstract public function hasRole(string ...$roles): bool;

    /**
     * Synchroniser le profil en fonction du rôle
     *
     * @return void
     */
    abstract public function syncProfileByRole(): void;
}

