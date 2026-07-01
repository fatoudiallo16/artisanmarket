<?php

namespace App\Helpers;

use App\Enums\OrderStatus;

class OrderHelper
{
    /**
     * Formater un statut de commande en français
     */
    public static function formatStatus(string $statut): string
    {
        $enum = OrderStatus::tryFrom($statut);

        return $enum ? $enum->label() : $statut;
    }

    /**
     * Formater le montant en devise (FCFA)
     */
    public static function formatAmount(float $amount): string
    {
        return number_format($amount, 0, ',', ' ') . ' FCFA';
    }

    /**
     * Calculer les frais de port
     */
    public static function calculateShipping(float $amount): float
    {
        // 5% de frais ou minimum 500 FCFA
        return max($amount * 0.05, 500);
    }

    /**
     * Vérifier si une commande peut être annulée
     */
    public static function canCancel(string $statut): bool
    {
        $enum = OrderStatus::tryFrom($statut);

        return $enum !== null && in_array($enum, [OrderStatus::PENDING, OrderStatus::IN_PROGRESS], true);
    }
}
