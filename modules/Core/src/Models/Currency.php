<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\CurrencyExchangeRate;

class Currency extends Model
{
    protected $table = 'currencies';
    
    protected $fillable = [
        'code',
        'name',
        'symbol',
        'decimal',
    ];

    public function exchangeRate()
    {
        return $this->hasOne(CurrencyExchangeRate::class, 'target_currency');
    }
}