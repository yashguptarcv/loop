<?php

namespace Modules\Payments\Services;

use Modules\Payments\Models\PaymentMethod;
use Modules\Payments\Contracts\PaymentProcessor;
use Modules\Payments\Models\PaymentConfiguration;

class PaymentsService
{
    protected function getProcessor(string $code)
    {
        
        $paymentConfiguration = PaymentConfiguration::where('payment_method_id', $code)->firstOrFail();
        $class = $paymentConfiguration->method->class_name;
        
        return new $class(json_decode($paymentConfiguration->config, true));
    }

    public function charge(string $code, $order, $request = null)
    {
        return $this->getProcessor($code)->charge($order, $request);
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
