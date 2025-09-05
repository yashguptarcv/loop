<?php

namespace Modules\Tax\Services;

use Modules\Customers\Models\User;
use Modules\Tax\Models\TaxRate;
use Modules\Tax\Enums\TaxType;
use Modules\Catalog\Models\Product;
use Illuminate\Support\Facades\Cache;

class TaxService
{
    /**
     * Calculate tax for order items with product-specific tax rates
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
            $product = Product::find($item['product_id']);
            $itemTotal = $item['price'] * $item['quantity'];

            $taxTotal += $this->calculateItemTax(
                $itemTotal,
                $taxAddress,
                $customer,
                $product->tax_id ?? null
            );
        }

        // Calculate shipping tax if applicable
        if (fn_get_setting('tax.tax_shipping')) {
            $taxTotal += $this->calculateItemTax(
                $this->getShippingAmount($items, $shippingAddress),
                $taxAddress,
                $customer,
                null // Shipping typically uses default tax rates
            );
        }

        return round($taxTotal, 2);
    }

    /**
     * Calculate tax for a single item with product-specific tax rate
     */
    protected function calculateItemTax(
        float $amount,
        array $address,
        User $customer,
        ?int $taxCategoryId = null
    ): float {
        if ($this->isTaxExempt($customer)) {
            return 0;
        }

        // Get all applicable tax rates from the category (federal + state + city)
        $taxRates = $this->getTaxRatesForCategory($taxCategoryId, $address);

        return $taxRates->reduce(function ($carry, $rate) use ($amount) {
            return $carry + $this->calculateRateTax($rate, $amount);
        }, 0);
    }

    protected function getTaxRatesForCategory(?int $taxCategoryId, array $address)
    {
        if (!$taxCategoryId) {
            return collect();
        }

        $cacheKey = "tax_category_rates_{$taxCategoryId}_" .
            ($address['country'] ?? 'any') . "_" .
            ($address['state'] ?? 'any');

        // return Cache::remember($cacheKey, now()->addDay(), function () use ($taxCategoryId, $address) {
        return TaxRate::query()
            ->whereHas('taxCategories', function ($q) use ($taxCategoryId) {
                $q->where('tax_category_id', $taxCategoryId);
            })
            ->where('country_id', $address['country'] ?? 0) 
            ->when(!empty($address['state']), function ($q) use ($address) {
                $state = $address['state'];
                $q->where(function ($qq) use ($state) {
                    $qq->where('state', $state)->orWhereNull('state');
                });
            })
            ->where('is_active', true)
            ->orderBy('priority', 'desc')
            ->get();


        // });
    }

    /**
     * Calculate tax for a single rate
     */
    protected function calculateRateTax(TaxRate $rate, float $amount): float
    {
        return match ($rate->type) {
            TaxType::FIXED => $rate->rate_value,
            TaxType::PERCENTAGE => ($amount * $rate->rate_value) / 100,
            default => 0
        };
    }

    /**
     * Determine which address to use for tax calculation
     */
    protected function getTaxableAddress(array $shippingAddress, array $billingAddress): array
    {
        return (fn_get_setting('general.tax_applicable') == 'billing')
            ? $billingAddress
            : $shippingAddress;
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
     * Get shipping amount
     */
    protected function getShippingAmount(array $items, array $address): float
    {
        return 0.0; // Implement your shipping calculation logic
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

    public function getProductTaxRates(?int $taxCategoryId, $address)
    {
        return $this->getTaxRatesForCategory($taxCategoryId, $address);
    }

    public function calculateRateTaxFromOrder($rate, $amount)
    {
        return $this->calculateRateTax($rate, $amount);
    }
}
