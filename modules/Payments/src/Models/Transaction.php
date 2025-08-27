<?php

namespace Modules\Payment\Models;

use Modules\Orders\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Modules\Payment\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_method_id',
        'transaction_id',
        'amount',
        'status',
        'details'
    ];

    protected $casts = [
        'details' => 'array',
        'amount' => 'decimal:2'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function getFormattedStatusAttribute()
    {
        return ucfirst($this->status);
    }
}