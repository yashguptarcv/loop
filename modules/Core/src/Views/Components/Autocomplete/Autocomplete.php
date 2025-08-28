<?php

namespace Modules\Core\Views\Components\Autocomplete;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Autocomplete extends Component
{
    public string $label;
    public string $field;
    public string $table;
    public string $valueField;
    public string $searchFields;
    public string $listAttributes;
    public bool $multiple;
    public array $actions;
    public array $selected;

    public function __construct(
        string $label,
        string $field,
        string $table,
        string $valueField,
        string $searchFields,
        string $listAttributes,
        bool $multiple = false,
        array $actions = [],
        array $selected = []
    ) {
        $this->label = $label;
        $this->field = $field;
        $this->table = $table;
        $this->valueField = $valueField;
        $this->searchFields = $searchFields;
        $this->listAttributes = $listAttributes;
        $this->multiple = $multiple;
        $this->actions = $actions;
        $this->selected = $selected;
    }

    public function render(): View|Closure|string
    {        
        return view('core::components.autocomplete.autocomplete');
    }
}
