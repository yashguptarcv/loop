<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Tax\Models\TaxRate;
use Modules\Admin\Models\Country;
use Modules\Tax\Enums\TaxType;
use Modules\Tax\Models\TaxCategory;

class TaxSeeder extends Seeder
{
    public function run()
    {
        $us = Country::where('code', 'US')->first();
        $uk = Country::where('code', 'GB')->first();

        // Create tax categories
        $standardCategory = TaxCategory::create([
            'name' => 'Standard',
            'priority' => 1,
            'status' => true
        ]);

        $reducedCategory = TaxCategory::create([
            'name' => 'Reduced',
            'priority' => 2,
            'status' => true
        ]);

        // Create US tax rates
        $usStandardRate = TaxRate::create([
            'name' => 'US Standard Rate',
            'rate_value' => 7.25,
            'type' => TaxType::PERCENTAGE,
            'country_id' => $us->id,
            'is_active' => true,
            'priority' => 1
        ]);

        $usCaliforniaRate = TaxRate::create([
            'name' => 'California Rate',
            'rate_value' => 7.25,
            'type' => TaxType::PERCENTAGE,
            'country_id' => $us->id,
            'state' => 'CA',
            'is_active' => true,
            'priority' => 2
        ]);

        // Create UK tax rates
        $ukStandardRate = TaxRate::create([
            'name' => 'UK VAT Standard',
            'rate_value' => 20.0,
            'type' => TaxType::PERCENTAGE,
            'country_id' => $uk->id,
            'is_active' => true,
            'priority' => 1
        ]);

        $ukReducedRate = TaxRate::create([
            'name' => 'UK VAT Reduced',
            'rate_value' => 5.0,
            'type' => TaxType::PERCENTAGE,
            'country_id' => $uk->id,
            'is_active' => true,
            'priority' => 2
        ]);

        // Assign rates to categories
        $standardCategory->taxRates()->attach([
            $usStandardRate->id => ['priority' => 1],
            $usCaliforniaRate->id => ['priority' => 2],
            $ukStandardRate->id => ['priority' => 1]
        ]);

        $reducedCategory->taxRates()->attach([
            $ukReducedRate->id => ['priority' => 1]
        ]);
    }
}