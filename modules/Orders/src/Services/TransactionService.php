<?php

namespace Modules\Orders\Services;

use Illuminate\Support\Str;
use Modules\Orders\Models\Order;
use Illuminate\Support\Facades\DB;
use Modules\Payments\Models\Payment;
use Modules\Orders\Models\Transaction;
use Modules\Orders\Enums\TransactionStatus;
use Modules\Orders\Enums\TransactionType;

class TransactionService
{
    /**
     * Record a new transaction
     *
     * @param Order $order
     * @param string $type
     * @param float $amount
     * @param string $status
     * @param Payment|null $payment
     * @param array $metadata
     * @param string|null $notes
     * @return Transaction
     */
    public function record(
        Order $order,
        string $type,
        float $amount,
        string $status = TransactionStatus::PENDING,
        ?Payment $payment = null,
        array $metadata = [],
        ?string $notes = null
    ): Transaction {
        return DB::transaction(function () use ($order, $type, $amount, $status, $payment, $metadata, $notes) {
            // Calculate running balance
            $balance = $this->calculateNewBalance($order, $amount, $type);

            $transaction = Transaction::create([
                'order_id' => $order->id,
                'payment_id' => $payment?->id,
                'transaction_number' => $this->generateTransactionNumber(),
                'type' => $type,
                'amount' => $amount,
                'balance' => $balance,
                'currency' => $order->currency,
                'status' => $status,
                'processed_at' => $status === TransactionStatus::COMPLETED ? now() : null,
                'gateway_reference' => $metadata['gateway_reference'] ?? null,
                'metadata' => $metadata,
                'notes' => $notes,
            ]);

            // Update order balance if needed
            $this->updateOrderBalance($order, $balance);

            return $transaction;
        });
    }

    /**
     * Update transaction status
     *
     * @param Transaction $transaction
     * @param string $status
     * @param string|null $notes
     * @return Transaction
     */
    public function updateStatus(
        Transaction $transaction,
        string $status,
        ?string $notes = null
    ): Transaction {
        $updates = ['status' => $status];

        if ($status === TransactionStatus::COMPLETED) {
            $updates['processed_at'] = now();
        }

        if ($notes) {
            $updates['notes'] = $transaction->notes 
                ? $transaction->notes . "\n" . $notes 
                : $notes;
        }

        $transaction->update($updates);

        // Update order balance if this affects the running total
        if (in_array($status, [TransactionStatus::COMPLETED, TransactionStatus::FAILED])) {
            $this->updateOrderBalance($transaction->order);
        }

        return $transaction->fresh();
    }

    /**
     * Refund a transaction
     *
     * @param Transaction $originalTransaction
     * @param float $amount
     * @param string $reason
     * @param array $metadata
     * @return Transaction
     */
    public function refund(
        Transaction $originalTransaction,
        float $amount,
        string $reason,
        array $metadata = []
    ): Transaction {
        if ($amount > $originalTransaction->amount) {
            throw new \InvalidArgumentException("Refund amount cannot exceed original transaction amount");
        }

        return $this->record(
            $originalTransaction->order,
            string: TransactionType::REFUND,
            amount: $amount,
            string: TransactionStatus::COMPLETED,
            payment: $originalTransaction->payment,
            metadata: array_merge($metadata, [
                'original_transaction_id' => $originalTransaction->id,
                'refund_reason' => $reason
            ]),
            notes: "Refund of {$amount} for transaction #{$originalTransaction->transaction_number}. Reason: {$reason}"
        );
    }

    /**
     * Generate unique transaction number
     */
    protected function generateTransactionNumber(): string
    {
        do {
            $number = 'TXN-' . date('Ymd') . '-' . strtoupper(Str::random(8));
        } while (Transaction::where('transaction_number', $number)->exists());

        return $number;
    }

    /**
     * Calculate new balance after transaction
     */
    protected function calculateNewBalance(Order $order, float $amount, string $type): float
    {
        $currentBalance = $order->transactions()
            ->whereIn('status', [TransactionStatus::COMPLETED, TransactionStatus::PENDING])
            ->latest()
            ->value('balance') ?? 0;

        return match($type) {
            TransactionType::PAYMENT, TransactionType::CAPTURE => $currentBalance - $amount,
            TransactionType::REFUND, TransactionType::ADJUSTMENT => $currentBalance + $amount,
            default => $currentBalance
        };
    }

    /**
     * Update order balance based on transactions
     */
    protected function updateOrderBalance(Order $order, ?float $newBalance = null): void
    {
        if ($newBalance === null) {
            $newBalance = $order->transactions()
                ->where('status', TransactionStatus::COMPLETED)
                ->latest()
                ->value('balance') ?? $order->total;
        }

        $order->update(['balance_due' => max(0, $newBalance)]);
    }

    /**
     * Get order transaction history
     */
    public function getOrderTransactions(Order $order, array $filters = [])
    {
        return $order->transactions()
            ->when($filters['type'] ?? null, fn($q, $type) => $q->where('type', $type))
            ->when($filters['status'] ?? null, fn($q, $status) => $q->where('status', $status))
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get transaction by reference
     */
    public function findByReference(string $reference): ?Transaction
    {
        return Transaction::where('transaction_number', $reference)
            ->orWhere('gateway_reference', $reference)
            ->first();
    }
}