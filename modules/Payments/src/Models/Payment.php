<?php
namespace Modules\Payments\Models;

use Modules\Orders\Models\Order;
use Modules\Orders\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Modules\Payments\Models\PaymentMethod;

class Payment extends Model
{
    protected $table = 'payments';
    
    protected $fillable = [
        'order_id',
        'payment_method_id',
        'transaction_id',
        'amount',
        'status',
        'currency',
        'details',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'details' => 'array'
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';
    const STATUS_REFUNDED = 'refunded';
    const STATUS_PARTIALLY_REFUNDED = 'partially_refunded';

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function markAsCompleted(string $gatewayTransactionId, array $response = [])
    {
        $this->update([
            'status' => self::STATUS_COMPLETED,
            'transaction_id' => $gatewayTransactionId,
            'details' => array_merge($this->details ?? [], ['gateway_response' => $response])
        ]);
    }

    public function markAsFailed(string $reason, array $response = [])
    {
        $this->update([
            'status' => self::STATUS_FAILED,
            'details' => array_merge($this->details ?? [], [
                'gateway_response' => $response,
                'failure_reason' => $reason
            ])
        ]);
    }

    public function isSuccessful(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }
}