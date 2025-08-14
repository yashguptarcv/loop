<?php

namespace Modules\Payments\Services;

use App\Models\Payment;
use Modules\Orders\Models\Order;
use Modules\Payment\Models\PaymentMethod;
use App\Payments\Contracts\PaymentProcessor;
use Modules\Payment\Models\Transaction;

class PaymentService
{
    public function processOrderPayment(Order $order, PaymentMethod $method, array $paymentData)
    {
        $processor = $method->getProcessorConfig();

        $result = $processor->processPayment(
            $order->total,
            array_merge($paymentData, [
                'order_id' => $order->id,
                'customer_email' => $order->user->email
            ])
        );

        if ($result['success']) {
            $payment = Transaction::create([
                'order_id' => $order->id,
                'payment_method_id' => $method->id,
                'transaction_id' => $result['transaction_id'],
                'amount' => $order->total,
                'status' => 'completed',
                'details' => $result['response'] ?? null
            ]);

            $order->update(['status' => 'processing']);

            return $payment;
        }

        throw new \Exception('Payment processing failed: ' . ($result['message'] ?? 'Unknown error'));
    }

    public function refundPayment(Transaction $payment, $amount = null)
    {
        $amount = $amount ?? $payment->amount;
        $processor = $payment->method->getProcessorConfig();

        $result = $processor->refund(
            $amount,
            $payment->transaction_id,
            ['payment_id' => $payment->id]
        );

        if ($result['success']) {
            $payment->update([
                'status' => 'refunded',
                'details' => array_merge($payment->details ?? [], ['refund' => $result['response']])
            ]);

            return true;
        }

        throw new \Exception('Refund failed: ' . ($result['message'] ?? 'Unknown error'));
    }
}
