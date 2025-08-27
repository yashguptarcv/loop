<?php

namespace Modules\Payments\Contracts;

interface PaymentProcessor
{
    /**
     * Charge a payment.
     */
    public function charge(array $payload): array;

    /**
     * Refund a payment.
     */
    public function refund(string $transactionId, float $amount): array;

    /**
     * Handle gateway webhook.
     */
    public function handleWebhook(array $payload): array;

    /**
     * Create/Manage subscription.
     */
    public function subscribe(array $payload): array;
}
