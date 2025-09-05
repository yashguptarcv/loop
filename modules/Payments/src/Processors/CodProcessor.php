<?php

namespace Modules\Payments\Processors;

use Modules\Payments\Contracts\PaymentProcessor;

class CodProcessor implements PaymentProcessor
{

    public function getName(): string
    {
        return 'Cod';
    }

    public function getTemplate(): ?string
    {
        return 'payments::settings.cod';
    }

    public function getProcessorTemplate(): ?string {
        return 'payments::processors.cod';
    }

    public function charge(array $payload): array
    {
        
        return [];
    }

    public function refund(string $transactionId, float $amount): array
    {
        return [];
    }

    public function handleWebhook(array $payload): array
    {
        return [];
    }

    public function subscribe(array $payload): array
    {
        return [];
    }
}
