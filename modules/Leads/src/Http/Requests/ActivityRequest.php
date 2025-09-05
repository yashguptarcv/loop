<?php

namespace Modules\Leads\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivityRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'type' => 'required|in:general,call,email,meeting,schedule_meeting',
            'description' => 'required|string',
            'duration_minutes' => 'nullable|integer|min:0',
            'outcome' => 'nullable|in:positive,neutral,negative,follow_up',
            'meeting_date'  => 'nullable'
        ];

        return $rules;
    }
}