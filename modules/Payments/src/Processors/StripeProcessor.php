<?php

namespace Modules\Payments\Processors;

use Modules\Payments\Contracts\PaymentProcessor;

class StripeProcessor implements PaymentProcessor
{
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
        Stripe::setApiKey($config['secret_key']);
    }

    public function charge(array $payload): array
    {
        $charge = Charge::create([
            'amount' => $payload['amount'] * 100, // cents
            'currency' => $payload['currency'],
            'source' => $payload['token'],
            'description' => $payload['description'] ?? 'Payment',
        ]);

        return $charge->toArray();
    }

    public function refund(string $transactionId, float $amount): array
    {
        $refund = Refund::create([
            'charge' => $transactionId,
            'amount' => $amount * 100,
        ]);

        return $refund->toArray();
    }

    public function handleWebhook(array $payload): array
    {
        // handle Stripe webhook event
        return ['status' => 'ok', 'event' => $payload['type']];
    }

    public function subscribe(array $payload): array
    {
        // implement subscription handling
        return ['status' => 'subscription_created'];
    }
}
