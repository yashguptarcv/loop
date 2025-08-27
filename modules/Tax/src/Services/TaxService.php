<?php

namespace Modules\Tax\Services;

use Modules\Customers\Models\User;
use Modules\Tax\Models\TaxRate;
use Modules\Tax\Enums\TaxType;
use Illuminate\Support\Facades\Cache;

class TaxService
{
    /**
     * Calculate tax for order items
     */
    public function calculate(
        array $items,
        array $shippingAddress,
        array $billingAddress,
        User $customer
    ): float {
        $taxTotal = 0;
        $taxAddress = $this->getTaxableAddress($shippingAddress, $billingAddress);

        foreach ($items as $item) {
            $taxTotal += $this->calculateItemTax(
                $item['price'] * $item['quantity'],
                $taxAddress,
                $customer
            );
        }

        // Calculate shipping tax if applicable
        if (config('tax.tax_shipping')) {
            $taxTotal += $this->calculateItemTax(
                $this->getShippingAmount($items, $shippingAddress),
                $taxAddress,
                $customer
            );
        }

        return round($taxTotal, 2);
    }

    /**
     * Calculate tax for a single item
     */
    protected function calculateItemTax(
        float $amount,
        array $address,
        User $customer
    ): float {
        if ($this->isTaxExempt($customer)) {
            return 0;
        }

        $taxRates = $this->getTaxRatesForLocation(
            $address['country'],
            $address['state'],
            $address['postcode'],
            $address['city']
        );

        return $taxRates->reduce(function ($carry, $rate) use ($amount) {
            return $carry + $this->calculateRateTax($rate, $amount);
        }, 0);
    }

    /**
     * Calculate tax for a single rate
     */
    protected function calculateRateTax(TaxRate $rate, float $amount): float
    {
        return match($rate->type) {
            TaxType::FIXED => $rate->rate_value,
            TaxType::PERCENTAGE => ($amount * $rate->rate_value) / 100,
            default => 0
        };
    }

    /**
     * Get applicable tax rates for a location
     */
    protected function getTaxRatesForLocation(
        string $country,
        ?string $state = null,
        ?string $postcode = null,
        ?string $city = null
    ) {
        $cacheKey = "tax_rates_{$country}_{$state}_{$postcode}_{$city}";

        return Cache::remember($cacheKey, now()->addDay(), function () use (
            $country,
            $state,
            $postcode,
            $city
        ) {
            return TaxRate::query()
                ->where(function ($query) use ($country, $state, $postcode, $city) {
                    $query->where('country_id', $country)
                        ->where(function ($query) use ($state) {
                            $query->where('state', $state)
                                ->orWhereNull('state');
                        })
                        ->where(function ($query) use ($postcode) {
                            $query->where('postcode', $postcode)
                                ->orWhereNull('postcode');
                        })
                        ->where(function ($query) use ($city) {
                            $query->where('city', $city)
                                ->orWhereNull('city');
                        });
                })
                ->where('is_active', true)
                ->orderBy('priority', 'desc')
                ->get();
        });
    }

    /**
     * Determine which address to use for tax calculation
     */
    protected function getTaxableAddress(array $shippingAddress, array $billingAddress): array
    {
        return config('tax.use_shipping_address_for_tax') 
            ? $shippingAddress 
            : $billingAddress;
    }

    /**
     * Check if customer is tax exempt
     */
    protected function isTaxExempt(User $customer): bool
    {
        return $customer->tax_exempt || 
               ($customer->group && $customer->group->tax_exempt);
    }

    /**
     * Get shipping amount (simplified - would normally come from ShippingService)
     */
    protected function getShippingAmount(array $items, array $address): float
    {
        // Implement your shipping calculation logic here
        return 10.00; // Default flat rate example
    }

    /**
     * Create or update a tax rate
     */
    public function saveTaxRate(array $data): TaxRate
    {
        $taxRate = isset($data['id']) 
            ? TaxRate::findOrFail($data['id'])
            : new TaxRate();

        $taxRate->fill($data);
        $taxRate->save();

        $this->clearTaxRateCache();

        return $taxRate;
    }

    /**
     * Clear tax rate caches
     */
    public function clearTaxRateCache(): void
    {
        Cache::tags(['tax_rates'])->flush();
    }
}