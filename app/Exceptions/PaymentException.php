<?php

namespace App\Exceptions;

use RuntimeException;

class PaymentException extends RuntimeException
{
    public static function notRefundable(): self
    {
        return new self('Seuls les paiements payés peuvent être remboursés.');
    }
}
