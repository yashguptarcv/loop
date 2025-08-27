<?php

namespace Modules\Discounts\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Discounts\Enums\DiscountType;
use Modules\Discounts\Enums\DiscountApplyTo;

class Discount extends Model
{
    protected $fillable = [
        'name',
        'description',
        'admin_id',
        'type',
        'amount',
        'apply_to',
        'is_active',
        'starts_at',
        'expires_at',
        'user_groups'
    ];

    protected $casts = [
        'amount' => 'float',
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'user_groups' => 'array',
        'type' => DiscountType::class,
        'apply_to' => DiscountApplyTo::class,
    ];

    public function rules()
    {
        return $this->hasMany(DiscountRule::class);
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }

    public function admins() {
        // return $this->hasMany()
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getIsValidAttribute(): bool
    {
        $now = now();
        
        if ($this->starts_at && $this->starts_at->gt($now)) {
            return false;
        }
        
        if ($this->expires_at && $this->expires_at->lt($now)) {
            return false;
        }
        
        return $this->is_active;
    }
}