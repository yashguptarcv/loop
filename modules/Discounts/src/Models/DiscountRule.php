<?php

namespace Modules\Discounts\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiscountRule extends Model
{
    protected $fillable = [
        'discount_id',
        'rule_type',
        'rule_id',
        'rule_value'
    ];

    public function discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class);
    }
}