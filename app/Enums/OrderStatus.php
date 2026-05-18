<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'en_attente';
    case IN_PROGRESS = 'en_cours';
    case PAID = 'payee';
    case CANCELLED = 'annulee';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'En attente',
            self::IN_PROGRESS => 'En cours',
            self::PAID => 'Payée',
            self::CANCELLED => 'Annulée',
        };
    }
}
