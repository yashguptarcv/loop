<?php

namespace Modules\Core\Models;

use Modules\Core\Models\Currency;
use Illuminate\Database\Eloquent\Model;

class CurrencyExchangeRate extends Model
{
    protected $table = 'currency_exchange_rates';
    
    protected $fillable = [
        'rate',
        'target_currency',
    ];

    public function targetCurrency()
    {
        return $this->belongsTo(Currency::class, 'target_currency');
    }
}