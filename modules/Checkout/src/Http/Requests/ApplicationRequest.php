<?php

namespace Modules\Checkout\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'full_name'         => 'required|string|max:255',
            'email'             => 'required|email|max:255',
            'mobile'            => 'required|string|max:15',
            'alternate_contact' => 'nullable|string|max:15',
            'designation'       => 'nullable|string|max:255',
            'organization'      => 'nullable|string|max:255',

            // Award categories
            'award_categories'            => 'required|integer|min:1|max:'.fn_get_setting('general.lead.award_category'),
            'award_category'              => 'required|array',
            'award_category.*.parent'     => 'required|integer|exists:categories,id',
            'award_category.*.child'      => 'required|string', // can be "other" or ID
            'award_category.*.custom'     => 'nullable|required_if:award_category.*.child,other|string|max:255',

            // Terms checkbox
            'terms' => 'accepted',
        ];
    }

     public function messages(): array
    {
        return [
            'award_category.*.custom.required_if' => 'Please provide a custom category name when selecting "other".',
        ];
    }
}