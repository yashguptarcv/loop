<?php

namespace App\Services;

use InvalidArgumentException;
use Modules\Core\Repositories\CurrencyRepository;
use Modules\Core\Repositories\ExchangeRateRepository;

class CurrencyConverterService
{
    private CurrencyRepository $currencyRepository;
    private ExchangeRateRepository $exchangeRateRepository;
    private string $baseCurrencyCode;

    public function __construct(
        CurrencyRepository $currencyRepository,
        ExchangeRateRepository $exchangeRateRepository,
        string $baseCurrencyCode = 'USD'
    ) {
        $this->currencyRepository = $currencyRepository;
        $this->exchangeRateRepository = $exchangeRateRepository;
        $this->baseCurrencyCode = $baseCurrencyCode;
    }

    public function convert(float $amount, string $fromCurrencyCode, string $toCurrencyCode): float
    {
        // Validate currencies
        $fromCurrency = $this->currencyRepository->findByCode($fromCurrencyCode);
        $toCurrency = $this->currencyRepository->findByCode($toCurrencyCode);

        if (!$fromCurrency || !$toCurrency) {
            throw new InvalidArgumentException('Invalid currency code provided');
        }

        // If same currency, return same amount
        if ($fromCurrencyCode === $toCurrencyCode) {
            return $amount;
        }

        // Convert from source currency to base currency
        if ($fromCurrencyCode !== $this->baseCurrencyCode) {
            $fromRate = $this->exchangeRateRepository->getRateByTargetCurrency($fromCurrency->id);
            if (!$fromRate) {
                throw new InvalidArgumentException("Exchange rate not found for {$fromCurrencyCode}");
            }
            $amount = $amount / $fromRate->rate;
        }

        // Convert from base currency to target currency
        if ($toCurrencyCode !== $this->baseCurrencyCode) {
            $toRate = $this->exchangeRateRepository->getRateByTargetCurrency($toCurrency->id);
            if (!$toRate) {
                throw new InvalidArgumentException("Exchange rate not found for {$toCurrencyCode}");
            }
            $amount = $amount * $toRate->rate;
        }

        return $amount;
    }

    public function getExchangeRates(): array
    {
        $rates = $this->exchangeRateRepository->getAllRates();
        $currencies = $this->currencyRepository->getAll();

        // Add base currency with rate 1
        $rates[$this->baseCurrencyCode] = 1.0;

        // Format output with currency details
        $result = [];
        foreach ($rates as $currencyCode => $rate) {
            $currency = $currencies->firstWhere('code', $currencyCode);
            $result[$currencyCode] = [
                'rate' => $rate,
                'name' => $currency->name,
                'symbol' => $currency->symbol,
                'decimal' => $currency->decimal,
            ];
        }

        return $result;
    }

    public function setBaseCurrency(string $currencyCode): void
    {
        $currency = $this->currencyRepository->findByCode($currencyCode);
        if (!$currency) {
            throw new InvalidArgumentException("Currency {$currencyCode} not found");
        }
        $this->baseCurrencyCode = $currencyCode;
    }

    public function getBaseCurrency(): string
    {
        return $this->baseCurrencyCode;
    }

    public function updateExchangeRate(string $currencyCode, float $rate): void
    {
        $currency = $this->currencyRepository->findByCode($currencyCode);
        if (!$currency) {
            throw new InvalidArgumentException("Currency {$currencyCode} not found");
        }

        if ($currencyCode === $this->baseCurrencyCode) {
            throw new InvalidArgumentException("Cannot update exchange rate for base currency");
        }

        $this->exchangeRateRepository->updateOrCreateRate($currency->id, $rate);
    }
}
