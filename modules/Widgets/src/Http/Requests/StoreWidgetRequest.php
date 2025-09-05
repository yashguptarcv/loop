<?php

namespace Modules\Widgets\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWidgetRequest extends FormRequest
{
    public function authorize(): bool
    {
        // you can add Gate or Role checks here
        return true;
    }

    public function rules(): array
    {
        return [
            'title'        => ['required', 'string', 'max:150'],
            'table_name'   => ['required', 'string'],
            'operation'    => ['required', 'string', 'in:count,sum,avg,min,max,profit_loss,month_compare'],
            'column_name'  => ['nullable', 'string', 'max:150'],

            'revenue_column' => ['nullable', 'string', 'max:150'],
            'cost_column'    => ['nullable', 'string', 'max:150'],

            'date_column'  => ['nullable', 'string', 'max:150'],
            'date_filter'  => ['nullable', 'string', 'in:none,today,week,month,year,custom'],
            'date_from'    => ['nullable', 'date'],
            'date_to'      => ['nullable', 'date', 'after_or_equal:date_from'],
            'group_by'     => ['nullable', 'string', 'max:150'],

            'is_currency'  => ['required', 'in:Y,N'],
            'widget_type'  => ['required', 'in:stat,line,bar,pie,worldmap'],

            'joins'        => ['nullable', 'json'],
            'conditions'   => ['nullable', 'json'],

            'pos_x'        => ['nullable', 'integer', 'min:0'],
            'pos_y'        => ['nullable', 'integer', 'min:0'],
            'width'        => ['nullable', 'integer', 'min:1', 'max:6'],
            'height'       => ['nullable', 'integer', 'min:1', 'max:6'],
        ];
    }

    public function messages(): array
    {
        return [
            'table_name.in' => 'Invalid table selected.',
            'operation.in'  => 'Invalid operation.',
            'widget_type.in'=> 'Unsupported widget type.',
        ];
    }
}
