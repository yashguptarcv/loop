<?php
use Modules\Core\Models\Setting;

if (!function_exists('fn_get_settings')) {
    
    function fn_get_settings(): array
    {
        return Setting::
            get()
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


