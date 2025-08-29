<?php

namespace Modules\Customers\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrUpdateCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // apply policy if needed
    }

    public function rules(): array
    {
        $customerId = $this->route('customer') ?? $this->input('customer_id');

        return [
            // Customer Info
            'name'     => 'required|string|max:191',
            'email'    => 'required|email|unique:users,email,' . ($customerId ?? 'NULL') . ',id',
            'phone'    => 'nullable|string|max:20',
            'password' => $customerId ? 'nullable|string|min:6' : 'required|string|min:6',

            // Billing
            'billing_address_1'  => 'required|string|max:255',
            'billing_address_2'  => 'nullable|string|max:255',
            'billing_city'       => 'required|string|max:100',
            'billing_state'      => 'nullable|string|max:100',
            'billing_zip'        => 'required|string|max:20',
            'billing_country'    => 'required|integer|exists:countries,id',

            // Shipping (required only if sameAsBilling is not checked)
            'shipping_address_1'  => 'nullable|required_unless:sameAsBilling,1|string|max:255',
            'shipping_address_2'  => 'nullable|string|max:255',
            'shipping_city'       => 'nullable|required_unless:sameAsBilling,1|string|max:100',
            'shipping_state'      => 'nullable|string|max:100',
            'shipping_zip'        => 'nullable|required_unless:sameAsBilling,1|string|max:20',
            'shipping_country'    => 'nullable|required_unless:sameAsBilling,1|integer|exists:countries,id',

            // Same as billing checkbox
            'sameAsBilling' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'billing_country.required' => 'Billing country is required.',
            'shipping_country.required' => 'Shipping country is required.',
            'email.unique' => 'This email is already registered with another customer.',
        ];
    }
}
