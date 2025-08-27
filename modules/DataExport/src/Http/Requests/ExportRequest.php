<?php

namespace Modules\DataExport\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'table' => [
                'required',
                'string',
                Rule::in($this->getAvailableTables())
            ],
            'columns' => 'sometimes|array',
            'columns.*' => 'string',
            'filters' => 'sometimes|array',
            'filters.*.column' => 'required_with:filters|string',
            'filters.*.operator' => 'required_with:filters|string|in:=,!=,<,>,<=,>=,like',
            'filters.*.value' => 'required_with:filters',
            'format' => [
                'required',
                'string',
                Rule::in(array_keys(config('dataexport.export_formats')))
            ],
            'limit' => 'sometimes|integer|min:1|max:' . config('dataexport.max_export_limit')
        ];
    }

    protected function getAvailableTables(): array
    {
        return app(\Modules\DataExport\Services\ExportService::class)->getAvailableTables();
    }
}