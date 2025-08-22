<?php

namespace Modules\Orders\Models;

use Modules\Customers\Models\User;
use Modules\Orders\Models\OrderItem;
use Modules\Payments\Models\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
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
        return $this->hasMany(Payment::class);
    }

    public function getFormattedStatusAttribute()
    {
        return ucfirst($this->status);
    }
}
