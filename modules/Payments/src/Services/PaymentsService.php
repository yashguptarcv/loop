<?php

namespace Modules\Payments\Services;

use Modules\Payments\Models\PaymentMethod;
use Modules\Payments\Contracts\PaymentProcessor;

class PaymentsService
{
    protected function getProcessor(string $code): PaymentProcessor
    {
        $method = PaymentMethod::where('code', $code)->where('is_active', true)->firstOrFail();
        $class = $method->class_name;
        return new $class(json_decode($method->config, true));
    }

    public function charge(string $code, $order)
    {
        return $this->getProcessor($code)->charge($order);
    }

    public function refund(string $code, string $transactionId, $reason = null)
    {
        return $this->getProcessor($code)->refund($transactionId, $reason);
    }

    public function handleWebhook(string $code, array $payload)
    {
        return $this->getProcessor($code)->handleWebhook($payload);
    }

    public function subscribe(string $code, array $payload)
    {
        return $this->getProcessor($code)->subscribe($payload);
    }
}
