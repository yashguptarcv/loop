<?php

use Modules\Acl\Models\Admin;
use Modules\Acl\Models\Role;
use Modules\Admin\Models\Country;
use Modules\Admin\Models\CountryState;
use Modules\Catalog\Models\Product;
use Modules\Catalog\Models\Category;


if (!function_exists('fn_get_usergroups')) {
    function fn_get_usergroups(): mixed
    {
        return Role::get();
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
if (!function_exists('fn_get_category_path')) {
    function fn_get_category_path($id)
    {
        $category = Category::find($id);

        if (! $category) {
            return null;
        }

        $path = [$category->name];

        // climb up parents
        while ($category->parent_id) {
            $category = Category::find($category->parent_id);
            if ($category) {
                array_unshift($path, $category->name);
            } else {
                break;
            }
        }

        return implode(' / ', $path);
    }
}

if (!function_exists('fn_get_categories')) {
    function fn_get_categories($parentId = null): mixed
    {
        $query = Category::query()
            ->where('status', 'A');

        if ($parentId) {
            // fetch children
            $query->where('parent_id', $parentId);
        } else {
            // fetch only parent categories
            $query->whereNull('parent_id');
        }

        return $query->orderBy('name')->get();
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
        return Country::get();
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

if (!function_exists('fn_get_users')) {
    function fn_get_users(): mixed
    {
        return Admin::where('status', true)->get();
    }
}

if (!function_exists('fn_get_user_data')) {
    function fn_get_user_data($id): mixed
    {
        return Admin::where('status', true)->where('id', $id)->first();
    }
}
