<?php

namespace Modules\Stripe\Processors;

use Modules\Payments\Contracts\PaymentProcessor;

class StripeProcessor implements PaymentProcessor
{

    public function getName(): string
    {
        return 'Stripe';
    }

    public function getTemplate(): ?string
    {
        return 'stripe::settings.stripe_template';
    }

    public function getProcessorTemplate(): ?string {
        return 'stripe::processors.cod';
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
