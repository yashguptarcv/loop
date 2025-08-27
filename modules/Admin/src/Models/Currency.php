<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Models\CurrencyExchangeRate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Currency extends Model
{
    use HasFactory;

    protected $table = 'currencies';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'code',
        'name',
        'symbol',
        'decimal'
    ];

     public function exchangeRate(): HasOne
    {
        return $this->hasOne(CurrencyExchangeRate::class, 'target_currency');
    }



}