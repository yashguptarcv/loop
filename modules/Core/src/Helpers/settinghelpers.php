<?php

use Modules\Acl\Models\Role;
use Modules\Admin\Models\Status;
use Modules\Core\Models\Setting;
use Illuminate\Support\Facades\DB;
use Modules\Leads\Models\LeadStatusModel;
use Intervention\Image\Facades\Image as InterventionImage;
use Modules\Admin\Models\Country;
use Modules\Admin\Models\Currency;
use Modules\Admin\Models\TaxRate;
use Modules\Tax\Models\TaxCategory;

if (!function_exists('fn_get_countries')) {
    function fn_get_countries()
    {
        return Country::get();
    }
}

if (!function_exists('fn_get_order_status')) {
    function fn_get_order_status($type = 'O')
    {
        return Status::where('type_code', $type)->get();
    }
}

if (!function_exists('fn_get_taxes')) {
    function fn_get_taxes()
    {
        return TaxCategory::where('status', true)->get();
    }
}

if (!function_exists('fn_get_currencies')) {
    function fn_get_currencies()
    {
        return Currency::get();
    }
}

if (!function_exists('fn_get_lead_statuses')) {
    function fn_get_lead_statuses()
    {
        return LeadStatusModel::get();
    }
}

if (!function_exists('fn_get_settings')) {

    function fn_get_settings(): array
    {
        return Setting::get()
            ->pluck('value', 'key')
            ->toArray();
    }
}

if (!function_exists('fn_get_setting')) {

    function fn_get_setting(string $key, $default = null)
    {
        $globalSetting = Setting::where('key', $key)
            ->first();
        return $globalSetting ? $globalSetting->value : $default;
    }
}


if (!function_exists('fn_update_setting')) {
    function fn_update_setting(string $key, $value): void
    {
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}

if (!function_exists('fn_delete_setting')) {
    function fn_delete_setting(string $key): bool
    {
        return Setting::where('key', $key)
            ->delete();
    }
}

if (!function_exists('fn_format_bytes')) {
    function fn_format_bytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}


if (!function_exists('fn_convert_currency_rate')) {
    function fn_convert_currency_rate(
        float $amount,
        string $toCurrencyCode
    ): float {
        $fromCurrencyCode = fn_get_setting('general.currency');

        // Validate input
        if ($amount < 0) {
            throw new InvalidArgumentException("Amount must be positive");
        }

        // Check if same currency
        if ($fromCurrencyCode === $toCurrencyCode) {
            return $amount;
        }

        // Get currency records
        $fromCurrency = DB::table('currencies')->where('code', $fromCurrencyCode)->first();
        $toCurrency   = DB::table('currencies')->where('code', $toCurrencyCode)->first();

        if (!$fromCurrency || !$toCurrency) {
            throw new InvalidArgumentException("Invalid currency code(s)");
        }

        // Get exchange rate (assuming rates stored as base → target)
        $rate = DB::table('currency_exchange_rates')
            ->where('target_currency', $toCurrency->id)
            ->value('rate');

        if (!$rate) {
            throw new InvalidArgumentException("Exchange rate not found for {$fromCurrencyCode} → {$toCurrencyCode}");
        }

        // Convert amount
        $convertedAmount = $amount * $rate;

        // Round based on target currency decimal places
        $decimalPlaces = $toCurrency->decimal ?? 2;

        return round($convertedAmount, $decimalPlaces);
    }
}

if (!function_exists('fn_convert_currency')) {
    function fn_convert_currency(
        float $amount,
        string $toCurrencyCode = ''
    ): string {
        try {
            $convertedAmount = fn_convert_currency_rate($amount, $toCurrencyCode);

            $currency = DB::table('currencies')
                ->where('code', $toCurrencyCode)
                ->first();

            $decimalPlaces = $currency->decimal ?? 2;
            $formattedAmount = number_format($convertedAmount, $decimalPlaces);

            // Add symbol if exists, else append code
            return $currency->symbol 
                ? $currency->symbol . $formattedAmount 
                : $formattedAmount . ' ' . $toCurrencyCode;

        } catch(Exception $e) {
            
            return $e->getMessage();
        }
    }
}

if (!function_exists('fn_get_currency')) {
    function fn_get_currency(
        float $amount,
    ): string {
        try {
            $toCurrencyCode = fn_get_setting('general.currency');

            $currency = DB::table('currencies')
                ->where('code', $toCurrencyCode)
                ->first();

            $decimalPlaces = $currency->decimal ?? 2;
            $formattedAmount = number_format($amount, $decimalPlaces);

            // Add symbol if exists, else append code
            return $currency->symbol 
                ? $currency->symbol . $formattedAmount 
                : $formattedAmount . ' ' . $toCurrencyCode;

        } catch(Exception $e) {
            
            return $e->getMessage();
        }
    }
}

if (!function_exists('fn_get_name_placeholder')) {
    function fn_get_name_placeholder($name)
    {
        $nameHash = crc32($name);
        $colors = [
            'bg-red-100 text-red-600',
            'bg-blue-100 text-blue-600',
            'bg-green-100 text-green-600',
            'bg-yellow-100 text-yellow-600',
            'bg-purple-100 text-purple-600',
            'bg-pink-100 text-pink-600',
            'bg-indigo-100 text-indigo-600'
        ];
        $colorIndex = abs($nameHash) % count($colors);
        $colorClass = $colors[$colorIndex];
        $initials = strtoupper(substr($name, 0, 2));

        return [$initials, $colorClass];
    }
}
