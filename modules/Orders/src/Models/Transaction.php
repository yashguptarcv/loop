<?php
namespace Modules\Orders\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Orders\Models\Order;
use Modules\Payments\Models\Payment;

class Transaction extends Model
{
    protected $fillable = [
        'transaction_number',
        'order_id',
        'payment_id',
        'type',
        'amount',
        'status',
        'currency',
        'notes',
        'metadata',
        'processed_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'metadata' => 'array',
        'processed_at' => 'datetime'
    ];

    const TYPE_PAYMENT = 'payment';
    const TYPE_REFUND = 'refund';
    const TYPE_ADJUSTMENT = 'adjustment';

    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';
    const STATUS_REVERSED = 'reversed';

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function scopePayments($query)
    {
        return $query->where('type', self::TYPE_PAYMENT);
    }

    public function scopeRefunds($query)
    {
        return $query->where('type', self::TYPE_REFUND);
    }

    public function markAsCompleted(string $notes = null)
    {
        $this->update([
            'status' => self::STATUS_COMPLETED,
            'processed_at' => now(),
            'notes' => $notes ? $this->notes . "\n" . $notes : $this->notes
        ]);
    }
}