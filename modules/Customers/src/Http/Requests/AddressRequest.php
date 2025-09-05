<?php

namespace Modules\Customers\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // You can implement custom authorization if needed
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'user_id'     => ['nullable', 'exists:users,id'], // required if admin creates for user
            'type'        => ['required', 'in:billing,shipping,both'],
            'name'        => ['required', 'string', 'max:255'],
            'company'     => ['nullable', 'string', 'max:255'],
            'address_1'   => ['required', 'string', 'max:255'],
            'address_2'   => ['nullable', 'string', 'max:255'],
            'city'        => ['required', 'string', 'max:150'],
            'state'       => ['nullable', 'string', 'max:150', 'exists:country_states,id'],
            'postcode'    => ['required', 'string', 'max:20'],
            'country'     => ['required', 'string', 'max:150', 'exists:countries,id'],
            'email'       => ['nullable', 'email', 'max:255'],
            'phone'       => ['nullable', 'string', 'max:20'],
            'is_default'  => ['boolean'],
            'additional'  => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * Custom messages (optional).
     */
    public function messages(): array
    {
        return [
            'type.required'      => 'Address type is required (billing, shipping, or both).',
            'name.required'      => 'Please enter the full name.',
            'address_1.required' => 'Address line 1 is required.',
            'city.required'      => 'City is required.',
            'postcode.required'  => 'Postal code is required.',
            'country.required'   => 'Country is required.',
        ];
    }
}
