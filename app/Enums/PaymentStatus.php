<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case PENDING = 'en_attente';
    case PAID = 'paye';
    case FAILED = 'echoue';
    case REFUNDED = 'rembourse';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'En attente',
            self::PAID => 'Payé',
            self::FAILED => 'Échoué',
            self::REFUNDED => 'Remboursé',
        };
    }
}
