<?php

namespace App\Helpers;

class OrderHelper
{
    /**
     * Formater un statut de commande en français
     */
    public static function formatStatus(string $statut): string
    {
        $statuses = [
            'en_attente' => 'En attente',
            'en_cours' => 'En cours',
            'payee' => 'Payée',
            'annulee' => 'Annulée',
        ];

        return $statuses[$statut] ?? $statut;
    }

    /**
     * Formater le montant en devise
     */
    public static function formatAmount(float $amount): string
    {
        return number_format($amount, 2, ',', ' ') . ' €';
    }

    /**
     * Calculer les frais de port
     */
    public static function calculateShipping(float $amount): float
    {
        // 5% de frais ou minimum 5€
        return max($amount * 0.05, 5);
    }

    /**
     * Vérifier si une commande peut être annulée
     */
    public static function canCancel(string $statut): bool
    {
        return in_array($statut, ['en_attente', 'en_cours']);
    }
}
