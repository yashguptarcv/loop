<?php

namespace Modules\Orders\Enums;

enum OrderStatus: string
{
    case NEW        = 'O'; // Initial draft state
    case INCOMPLETE = 'N'; // Initial draft state
    case PENDING    = 'P'; // Customer started checkout
    case PROCESSING = 'H'; // Payment processing
    case COMPLETED  = 'Z'; // Successful payment
    case FAILED     = 'F'; // Payment failed
    case REFUNDED   = 'R'; // Order refunded
    case CANCELLED  = 'C'; // Order cancelled

    public function label(): string
    {
        return match($this) {
            self::NEW           => 'New',
            self::INCOMPLETE    => 'Incomplete',
            self::PENDING       => 'Pending',
            self::PROCESSING    => 'Processing',
            self::COMPLETED     => 'Completed',
            self::FAILED        => 'Failed',
            self::REFUNDED      => 'Refunded',
            self::CANCELLED     => 'Cancelled'
        };
    }
}