<?php
namespace Modules\Orders\Enums;

enum TransactionType: string
{
    case PAYMENT = 'payment';
    case REFUND = 'refund';
    case CAPTURE = 'capture';
    case AUTHORIZATION = 'authorization';
    case ADJUSTMENT = 'adjustment';
    case CHARGEBACK = 'chargeback';

    public function label(): string
    {
        return match ($this) {
            self::PAYMENT => 'Payment',
            self::REFUND => 'Refund',
            self::CAPTURE => 'Capture',
            self::AUTHORIZATION => 'Authorization',
            self::ADJUSTMENT => 'Adjustment',
            self::CHARGEBACK => 'Chargeback',
        };
    }
}
