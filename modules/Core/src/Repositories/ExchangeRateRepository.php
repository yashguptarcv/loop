<?php

namespace Modules\Core\Repositories;

use Modules\Core\Models\CurrencyExchangeRate;

class ExchangeRateRepository
{
    public function getRateByTargetCurrency(int $targetCurrencyId): ?CurrencyExchangeRate
    {
        return CurrencyExchangeRate::where('target_currency', $targetCurrencyId)->first();
    }

    public function getAllRates(): array
    {
        return CurrencyExchangeRate::with('targetCurrency')->get()
            ->mapWithKeys(function ($rate) {
                return [$rate->targetCurrency->code => $rate->rate];
            })
            ->toArray();
    }

    public function updateOrCreateRate(int $targetCurrencyId, float $rate): CurrencyExchangeRate
    {
        return CurrencyExchangeRate::updateOrCreate(
            ['target_currency' => $targetCurrencyId],
            ['rate' => $rate]
        );
    }
}
