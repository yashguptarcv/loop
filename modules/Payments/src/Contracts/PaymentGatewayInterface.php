<?php

namespace Modules\Payments\Contracts;

interface PaymentGatewayInterface
{
    public function charge(array $data): array;
    public function refund(string $paymentId, float $amount = null, string $reason = null): array;
    public function createCustomer(array $data): array;
    public function attachPaymentMethod(string $customerId, string $paymentMethodId): array;
    public function createSubscription(array $data): array;
    public function cancelSubscription(string $subscriptionId): array;
    public function handleWebhook(array $payload): array;
    public function getClientSecret(array $data): array;
}
