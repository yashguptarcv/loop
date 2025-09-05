<?php

namespace Modules\Square\Processors;

use Exception;
use Square\Legacy\SquareClient;
use Square\Models\Money;
use Square\Models\CreatePaymentRequest;
use Modules\Payments\Contracts\PaymentProcessor;

class SquareProcessor implements PaymentProcessor
{
    protected $client;

    public function __construct(array $config = [])
    {
        $this->client = new SquareClient([
            'accessToken' => 'EAAAl1R-04JzLUtwCFkM4nNqK77e7rUgP-mQ6LkykQHxxzaov61nlrL8wwoUTJMa',
            'environment' => 'sandbox', // or 'production'
        ]);
    }

    public function getName(): string
    {
        return 'Square';
    }

    public function getTemplate(): ?string
    {
        return 'square::settings.square_template';
    }

    public function getProcessorTemplate(): ?string
    {
        return 'square::processors.square_template';
    }

    /**
     * Charge customer using Square
     */
    public function charge(array $payload, $request = null): array
    {
        try {
            $paymentsApi = $this->client->getPaymentsApi();

            $amountMoney = new Money();
            $amountMoney->setAmount((int) ($payload['total'] * 100)); // cents
            $amountMoney->setCurrency($payload['currency'] ?? 'USD');

            $paymentRequest = new CreatePaymentRequest(
                $request['nonce'] ?? $request['token'],  // Square payment token (nonce)
                uniqid(),                                // idempotency key
                $amountMoney
            );

            $paymentRequest->setNote("Order #" . $payload['order_number']);
            $paymentRequest->setCustomerEmail($payload['customer_details']['email'] ?? null);

            $response = $paymentsApi->createPayment($paymentRequest);

            if ($response->isError()) {
                return [
                    'success' => false,
                    'errors' => $response->getErrors(),
                ];
            }

            $result = $response->getResult()->getPayment();

            return [
                'success' => true,
                'transaction_id' => $result->getId(),
                'status' => $result->getStatus(),
                'amount' => $result->getAmountMoney()->getAmount() / 100,
                'currency' => $result->getAmountMoney()->getCurrency(),
            ];
        } catch (Exception $e) {
            dd($e->getMessage());
            return [
                'success' => false,
                'errors' => $e->getMessage(),
            ];
        }
    }

    public function refund(string $transactionId, float $amount): array
    {
        // implement refunds later
        return ['status' => 'not_implemented'];
    }

    public function handleWebhook(array $payload): array
    {
        return ['status' => 'ok', 'event' => $payload['type'] ?? 'unknown'];
    }

    public function subscribe(array $payload): array
    {
        return ['status' => 'subscription_created'];
    }
}
