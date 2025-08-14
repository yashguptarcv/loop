<?php

namespace Modules\Payments\Processors;

use Modules\Payments\Contracts\PaymentProcessor;

class StripeProcessor implements PaymentProcessor
{
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function processPayment($amount, array $options = [])
    {
        // Implement Stripe payment processing
        return [
            'success' => true,
            'transaction_id' => 'stripe_' . uniqid(),
            'response' => []
        ];
    }

    public function refund($amount, $transactionId, array $options = [])
    {
        // Implement Stripe refund
        return [
            'success' => true,
            'refund_id' => 'stripe_refund_' . uniqid(),
            'response' => []
        ];
    }

    public function getConfigFields(): array
    {
        return [
            'publishable_key' => [
                'type' => 'text',
                'label' => 'Publishable Key',
                'required' => true
            ],
            'secret_key' => [
                'type' => 'text',
                'label' => 'Secret Key',
                'required' => true
            ],
            'webhook_secret' => [
                'type' => 'text',
                'label' => 'Webhook Secret',
                'required' => false
            ]
        ];
    }
}
