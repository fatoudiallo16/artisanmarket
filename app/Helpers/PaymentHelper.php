<?php

namespace App\Helpers;

class PaymentHelper
{
    /**
     * Les modes de paiement supportés
     */
    public static function getPaymentMethods(): array
    {
        return [
            'carte_bancaire' => 'Carte bancaire',
            'virement' => 'Virement bancaire',
            'paypal' => 'PayPal',
            'cheque' => 'Chèque',
        ];
    }

    /**
     * Formater un statut de paiement
     */
    public static function formatStatus(string $statut): string
    {
        $statuses = [
            'en_attente' => 'En attente',
            'paye' => 'Payé',
            'echoue' => 'Échoué',
            'rembourse' => 'Remboursé',
        ];

        return $statuses[$statut] ?? $statut;
    }

    /**
     * Vérifier si un paiement peut être remboursé
     */
    public static function canRefund(string $statut): bool
    {
        return $statut === 'paye';
    }

    /**
     * Formater le montant avec devise
     */
    public static function formatAmount(float $amount): string
    {
        return number_format($amount, 2, ',', ' ') . ' €';
    }
}
