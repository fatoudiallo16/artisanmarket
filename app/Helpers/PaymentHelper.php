<?php

namespace App\Helpers;

use App\Enums\PaymentStatus;

class PaymentHelper
{
    /**
     * Les modes de paiement supportés
     */
    public static function getPaymentMethods(): array
    {
        return [
            'orange_money' => 'Orange Money',
            'wave' => 'Wave',
            'moov_money' => 'Moov Money',
            'especes' => 'Espèces à la livraison',
            'virement' => 'Virement bancaire',
        ];
    }

    /**
     * Formater un statut de paiement
     */
    public static function formatStatus(string $statut): string
    {
        $enum = PaymentStatus::tryFrom($statut);

        return $enum ? $enum->label() : $statut;
    }

    /**
     * Vérifier si un paiement peut être remboursé
     */
    public static function canRefund(string $statut): bool
    {
        $enum = PaymentStatus::tryFrom($statut);

        return $enum === PaymentStatus::PAID;
    }

    /**
     * Formater le montant avec devise (FCFA)
     */
    public static function formatAmount(float $amount): string
    {
        return number_format($amount, 0, ',', ' ') . ' FCFA';
    }
}
