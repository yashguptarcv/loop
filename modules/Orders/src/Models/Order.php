<?php

namespace Modules\Orders\Models;

use Modules\Customers\Models\User;
use Modules\Orders\Models\OrderItem;
use Modules\Payments\Models\Payment;
use Modules\Payments\Models\Payments;
use Illuminate\Database\Eloquent\Model;
use Modules\Orders\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'admin_id',
        'order_number',
        'status',
        'subtotal',
        'discount',
        'tax',
        'shipping',
        'total',
        'notes',
        'currency',
        'coupon_code',
        'payment_method',
        'payment_status',
        'shipping_address',
        'billing_address',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'shipping_address' => 'array',
        'billing_address' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payments::class);
    }

    public function payment()
    {
        return $this->hasOne(Payments::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getFormattedStatusAttribute()
    {
        return ucfirst($this->status);
    }

    public function pendingTransaction()
    {
        return $this->hasOne(Transaction::class, 'order_id')
            ->where('status', TransactionStatus::PENDING)
            ->latest();
    }

    public function pendingTransactions()
    {
        return $this->hasMany(Transaction::class, 'order_id')
            ->where('status', TransactionStatus::PENDING)
            ->orderBy('created_at', 'desc');
    }
}
