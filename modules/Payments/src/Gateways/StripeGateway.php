<?php

namespace Modules\Payments\Gateways;

use Modules\Payments\Contracts\PaymentGatewayInterface;
use Stripe\StripeClient;
use Stripe\Exception\ApiErrorException;

class StripeGateway implements PaymentGatewayInterface
{
    protected StripeClient $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(config('payments.stripe.secret_key'));
    }

    public function charge(array $data): array
    {
        try {
            $paymentIntent = $this->stripe->paymentIntents->create([
                'amount' => $this->toCents($data['amount']),
                'currency' => $data['currency'] ?? 'usd',
                'customer' => $data['customer_id'] ?? null,
                'payment_method' => $data['payment_method_id'] ?? null,
                'description' => $data['description'] ?? null,
                'metadata' => $data['metadata'] ?? [],
                'confirm' => true,
            ]);

            return [
                'success' => true,
                'id' => $paymentIntent->id,
                'status' => $paymentIntent->status,
                'client_secret' => $paymentIntent->client_secret,
                'payment_method' => $paymentIntent->payment_method,
                'amount' => $paymentIntent->amount,
            ];
        } catch (ApiErrorException $e) {
            return $this->handleError($e);
        }
    }

    public function refund(string $paymentId, float $amount = null, string $reason = null): array
    {
        try {
            $params = ['payment_intent' => $paymentId];
            if ($amount) $params['amount'] = $this->toCents($amount);
            if ($reason) $params['reason'] = $reason;

            $refund = $this->stripe->refunds->create($params);

            return [
                'success' => true,
                'id' => $refund->id,
                'status' => $refund->status,
                'amount' => $refund->amount,
            ];
        } catch (ApiErrorException $e) {
            return $this->handleError($e);
        }
    }

    // Implement other interface methods...

    protected function toCents(float $amount): int
    {
        return (int) round($amount * 100);
    }

    protected function handleError(ApiErrorException $e): array
    {
        return [
            'success' => false,
            'error' => $e->getError()->message,
            'code' => $e->getError()->code,
        ];
    }
}
