<?php

namespace Modules\Leads\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Leads\Models\Application;

class ApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // You can modify this based on your authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Application::rules();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // If your billing address comes as separate fields, you might need to combine them
        if ($this->has(['address_line1', 'city', 'state', 'postal_code', 'country'])) {
            $this->merge([
                'billing_address' => [
                    'address_line1' => $this->address_line1,
                    'address_line2' => $this->address_line2 ?? null,
                    'city' => $this->city,
                    'state' => $this->state,
                    'postal_code' => $this->postal_code,
                    'country' => $this->country,
                ]
            ]);
        }
    }
}