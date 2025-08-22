<?php
namespace Modules\Payments\Models;

use Modules\Payments\Models\Payment;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'name',
        'code',
        'type',
        'description',
        'is_active',
        'is_online',
        'config',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_online' => 'boolean',
        'config' => 'array'
    ];

    const TYPE_CREDIT_CARD = 'credit_card';
    const TYPE_PAYPAL = 'paypal';
    const TYPE_BANK_TRANSFER = 'bank_transfer';
    const TYPE_CASH = 'cash';

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOnline($query)
    {
        return $query->where('is_online', true);
    }

    public function getConfigValue(string $key, $default = null)
    {
        return data_get($this->config, $key, $default);
    }
}