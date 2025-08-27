<?php

namespace Modules\Admin\Models;

use Modules\Admin\Models\Currency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CurrencyExchangeRate extends Model
{
    protected $table = 'currency_exchange_rates';
    
    protected $fillable = [
        'rate',
        'target_currency',
    ];

    public function currency():BelongsTo
    {
        return $this->belongsTo(Currency::class, 'target_currency');
    }
}