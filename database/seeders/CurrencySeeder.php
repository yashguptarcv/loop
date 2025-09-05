<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    protected $currencies = [
        'USD' => ['US Dollar', '$', 1.0],
        'INR' => ['Indian Rupee', '₹', 83.10],
        'GBP' => ['British Pound', '£', 0.79],
        'AED' => ['United Arab Emirates Dirham', 'د.إ', 3.67],
        'EUR' => ['Euro', '€', 0.92],
        'PLN' => ['Polish Złoty', 'zł', 4.05],
    ];

    public function run($parameters = [])
    {
        // Clear old data
        DB::table('currency_exchange_rates')->delete();
        DB::table('currencies')->delete();

        $data = [];
        $rates = [];
        $id = 1;

        foreach ($this->currencies as $code => [$name, $symbol, $rate]) {
            $data[] = [
                'id'     => $id,
                'code'   => $code,
                'name'   => $name,
                'symbol' => $symbol,
            ];

            // Insert exchange rate if not USD
            if ($code !== 'USD') {
                $rates[] = [
                    'target_currency' => $id,
                    'rate'            => $rate,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ];
            }

            $id++;
        }

        DB::table('currencies')->insert($data);
        DB::table('currency_exchange_rates')->insert($rates);
    }
}
