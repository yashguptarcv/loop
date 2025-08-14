<?php

use Modules\Core\Models\Setting;
use Illuminate\Support\Facades\DB;
use Modules\Catalog\Models\Category;
use Intervention\Image\Facades\Image as InterventionImage;
use Modules\Catalog\Models\Product;

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


if (!function_exists('fn_set_setting')) {
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

if (!function_exists('fn_convert_currency_rate')) {
    function fn_convert_currency_rate(
        float $amount,
        string $toCurrencyCode,
    ): float {
        $fromCurrencyCode = fn_get_setting('general.settings.default_currency');
        // Validate input
        if ($amount < 0) {
            throw new InvalidArgumentException("Amount must be positive");
        }

        // Check if same currency
        if ($fromCurrencyCode === $toCurrencyCode) {
            return $amount;
        }

        // Get currency IDs
        $fromCurrency = DB::table('currencies')->where('code',)->first();
        $toCurrency = DB::table('currencies')->where('code', $toCurrencyCode)->first();

        if (!$fromCurrency || !$toCurrency) {
            throw new InvalidArgumentException("Invalid currency code");
        }

        // Convert from base currency to target currency
        if ($toCurrencyCode !== $fromCurrencyCode) {
            $toRate = DB::table('currency_exchange_rates')
                ->where('target_currency', $toCurrency->id)
                ->first();

            if (!$toRate) {
                throw new InvalidArgumentException("Exchange rate not found for {$toCurrencyCode}");
            }

            $amount = $amount * $toRate->rate;
        }

        // Round to target currency's decimal places
        $decimalPlaces = $toCurrency->decimal ?? 2;
        return round($amount, $decimalPlaces);
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

if (!function_exists('fn_convert_currency')) {
    function fn_convert_currency(
        float $amount,
        string $toCurrencyCode,

    ): string {
        $convertedAmount = fn_convert_currency_rate($amount, $toCurrencyCode);

        $currency = DB::table('currencies')
            ->where('code', $toCurrencyCode)
            ->first();

        $decimalPlaces = $currency->decimal ?? 2;
        $formattedAmount = number_format($convertedAmount, $decimalPlaces);

        if ($currency->symbol) {
            return $currency->symbol . $formattedAmount;
        }

        return $formattedAmount . ' ' . $toCurrencyCode;
    }
}

if (!function_exists('fn_get_image')) {
    /**
     * Get image URL with optional resizing
     * 
     * @param string|null $image Image path (relative to storage)
     * @param string $path Base storage path (e.g., 'categories/')
     * @param array $options Resize options ['width' => int, 'height' => int, 'quality' => int]
     * @return string Image URL
     */
    function fn_get_image(?string $image, string $path = '', array $options = []): string
    {
        if (empty($image)) {
            return asset('images/default-image.png'); // Fallback image
        }

        $fullPath = $path . $image;

        // If no resize options, return direct asset URL
        if (empty($options)) {
            return asset('storage/' . $fullPath);
        }

        // Handle resizing using Intervention Image
        // try {
        //     $width = $options['width'] ?? null;
        //     $height = $options['height'] ?? null;
        //     $quality = $options['quality'] ?? 80;

        //     $resizedPath = 'cache/' . $width . 'x' . $height . '/' . $fullPath;
        //     $resizedFullPath = storage_path('app/public/' . $resizedPath);

        //     // Return cached resized image if exists
        //     if (file_exists($resizedFullPath)) {
        //         return asset('storage/' . $resizedPath);
        //     }

        //     // Create resized image
        //     $img = InterventionImage::make(storage_path('app/public/' . $fullPath));

        //     // Resize with aspect ratio maintained
        //     $img->resize($width, $height, function ($constraint) {
        //         $constraint->aspectRatio();
        //         $constraint->upsize();
        //     });

        //     // Ensure directory exists
        //     if (!file_exists(dirname($resizedFullPath))) {
        //         mkdir(dirname($resizedFullPath), 0755, true);
        //     }

        //     $img->save($resizedFullPath, $quality);

        //     return asset('storage/' . $resizedPath);
        // } catch (Exception $e) {
            // Fallback to original if resizing fails
            return asset('storage/' . $fullPath);
        // }
    }
}

if (!function_exists('fn_get_category_data')) {
    function fn_get_category_data(int $id): mixed
    {
        return Category::where('id', $id)->first();
    }
}

if (!function_exists('fn_get_category_name')) {
    function fn_get_category_name(int $id = 0): mixed
    {
        return Category::where('id', $id)->value('name');
    }
}

if (!function_exists('fn_get_categories')) {
    function fn_get_categories(int $id = 0): mixed
    {
        return Category::get();
    }
}

// products

if (!function_exists('fn_get_product_data')) {
    function fn_get_product_data(int $id): mixed
    {
        return Product::where('id', $id)->first();
    }
}

if (!function_exists('fn_get_product_name')) {
    function fn_get_product_name(int $id = 0): mixed
    {
        return Product::where('id', $id)->value('name');
    }
}

if (!function_exists('fn_get_products')) {
    function fn_get_products(int $id = 0): mixed
    {
        return Product::get();
    }
}
