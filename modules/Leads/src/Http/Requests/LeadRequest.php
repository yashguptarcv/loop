<?php

namespace Modules\Leads\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'source_id' => 'nullable|exists:lead_sources,id',
            'value' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'tags' => 'nullable|string',
            'images.*' => 'nullable|file|max:5120', // 5MB
        ];

        return $rules;
    }
}