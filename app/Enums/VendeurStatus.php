<?php

namespace App\Enums;

enum VendeurStatus: string
{
    case PENDING = 'en_attente';
    case APPROVED = 'approuve';
    case SUSPENDED = 'suspendu';
    case REJECTED = 'rejete';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'En attente',
            self::APPROVED => 'Approuvé',
            self::SUSPENDED => 'Suspendu',
            self::REJECTED => 'Rejeté',
        };
    }
}
