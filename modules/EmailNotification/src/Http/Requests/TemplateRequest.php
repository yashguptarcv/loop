<?php

namespace Modules\EmailNotification\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TemplateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'subject' => 'required|string',
            'content' => 'required',
            'status' => 'required|in:1,0'
        ];
    }
}