<?php

namespace Modules\Discounts\Models;

use Modules\Customers\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Coupon extends Model
{
    protected $fillable = [
        'discount_id',
        'code',
        'description',
        'starts_at',
        'expires_at',
        'usage_limit',
        'usage_limit_per_user',
        'min_order_amount',
        'times_used',
        'is_active'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'min_order_amount' => 'float'
    ];

    public function discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot(['order_id', 'discount_amount', 'used_at'])
            ->withTimestamps();
    }

    public function getIsValidAttribute(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now();
        
        if ($this->starts_at && $this->starts_at->gt($now)) {
            return false;
        }
        
        if ($this->expires_at && $this->expires_at->lt($now)) {
            return false;
        }
        
        if ($this->usage_limit && $this->times_used >= $this->usage_limit) {
            return false;
        }
        
        return true;
    }
}