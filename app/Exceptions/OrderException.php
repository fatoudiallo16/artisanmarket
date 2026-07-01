<?php

namespace App\Exceptions;

use RuntimeException;

class OrderException extends RuntimeException
{
    public static function cartNotFound(): self
    {
        return new self('Panier non trouvé.');
    }

    public static function cannotCancel(): self
    {
        return new self('Impossible d\'annuler une commande payée.');
    }
}
