<?php

namespace Modules\Tax\Http\Requests;

use Modules\Tax\Enums\TaxType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaxRateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'rate_value' => 'required|numeric|min:0',
             'type' => ['required', Rule::in(array_column(TaxType::cases(), 'value'))],
            'country_id' => 'required|exists:countries,id',
            'state' => 'nullable|string|max:255',
            'postcode' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'priority' => 'integer|min:0'
        ];
    }
}