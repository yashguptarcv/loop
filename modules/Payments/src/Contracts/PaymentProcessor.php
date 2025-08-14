<?php

namespace Modules\Payments\Contracts;

interface PaymentProcessor
{
    public function processPayment($amount, array $options = []);
    public function refund($amount, $transactionId, array $options = []);
    public function getConfigFields(): array;
}
