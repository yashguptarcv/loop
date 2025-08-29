<?php
use Modules\Acl\Models\Role;
use Modules\Admin\Models\Country;
use Modules\Admin\Models\CountryState;
use Modules\Catalog\Models\Product;
use Modules\Catalog\Models\Category;


if (!function_exists('fn_get_usergroups')) {
    function fn_get_usergroups(): mixed
    {
        return Role::get()->toArray();
    }
}

if (!function_exists('fn_get_category_data')) {
    function fn_get_category_data($id): mixed
    {
        return Category::where('id', (int)$id)->first();
    }
}

if (!function_exists('fn_get_category_name')) {
    function fn_get_category_name($id = 0): mixed
    {
        return Category::where('id', (int)$id)->value('name');
    }
}

if (!function_exists('fn_get_categories')) {
    function fn_get_categories(): mixed
    {
        return Category::get()->toArray();
    }
}

// products

if (!function_exists('fn_get_product_data')) {
    function fn_get_product_data($id): mixed
    {
        return Product::where('id', (int)$id)->first();
    }
}

if (!function_exists('fn_get_product_name')) {
    function fn_get_product_name(int $id = 0): mixed
    {
        return Product::where('id', $id)->value('name');
    }
}

if (!function_exists('fn_get_products')) {
    function fn_get_products(): mixed
    {
        return Product::get();
    }
}

if (!function_exists('fn_get_country_data')) {
    function fn_get_country_data(int $id): mixed
    {
        return Country::where('id', $id)->first();
    }
}

if (!function_exists('fn_get_country_code')) {
    function fn_get_country_code(string $code): mixed
    {
        return Country::where('code', $code)->first();
    }
}

if (!function_exists('fn_get_country_name')) {
    function fn_get_country_name(int $id = 0): mixed
    {
        return Country::where('id', $id)->value('name');
    }
}


if (!function_exists('fn_get_countries')) {
    function fn_get_countries(int $id = 0): mixed
    {
        return Country::get()->toArray();
    }
}

// states

if (!function_exists('fn_get_state_data')) {
    function fn_get_state_data(int $id): mixed
    {
        return CountryState::where('id', $id)->first();
    }
}

if (!function_exists('fn_get_state_code')) {
    function fn_get_state_code(string $code): mixed
    {
        return CountryState::where('code', $code)->first();
    }
}

if (!function_exists('fn_get_state_name')) {
    function fn_get_state_name($id = 0): mixed
    {
        return CountryState::where('id', $id)->value('default_name');
    }
}


if (!function_exists('fn_get_states')) {
    function fn_get_states(int $id = 0): mixed
    {
        return CountryState::get();
    }
}