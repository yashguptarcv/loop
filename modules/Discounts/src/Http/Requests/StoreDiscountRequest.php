<?php

namespace Modules\Discounts\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDiscountRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => ['required', Rule::in(['F', 'P'])],
            'amount' => 'required|numeric|min:0',
            'apply_to' => ['nullable', Rule::in(['subtotal', 'total'])],
            'is_active' => 'boolean',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'user_groups' => 'nullable|array',
            'user_groups.*' => 'integer|exists:user_groups,id',
            
            'coupons' => 'nullable|array',
            'coupons.*.code' => 'required|string|unique:coupons,code',
            'coupons.*.description' => 'nullable|string',
            'coupons.*.starts_at' => 'nullable|date',
            'coupons.*.expires_at' => 'nullable|date|after_or_equal:coupons.*.starts_at',
            'coupons.*.usage_limit' => 'nullable|integer|min:1',
            'coupons.*.usage_limit_per_user' => 'nullable|integer|min:1',
            'coupons.*.min_order_amount' => 'nullable|numeric|min:0',
            'coupons.*.is_active' => 'boolean',
            
            'rules' => 'nullable|array',
            'rules.*.rule_type' => ['required', Rule::in(['product', 'category'])],
            'rules.*.rule_id' => 'required|integer',
            'rules.*.rule_value' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'coupons.*.code.unique' => 'The coupon code :input has already been taken.',
            'expires_at.after_or_equal' => 'The expiration date must be after or equal to the start date.',
            'coupons.*.expires_at.after_or_equal' => 'The coupon expiration date must be after or equal to the start date.',
        ];
    }
}