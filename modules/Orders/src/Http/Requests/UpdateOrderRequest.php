<?php

namespace Modules\Orders\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('update', $this->order);
    }

    public function rules()
    {
        return [
            'status' => 'sometimes|in:pending,processing,completed,declined,cancelled',
            'payment_status' => 'sometimes|in:unpaid,paid,refunded,partially_refunded',
            'notes' => 'nullable|string',
        ];
    }
}