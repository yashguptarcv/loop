@props([
    'label' => null,   // optional visible label
    'field',
    'table',
    'valueField' => 'id',
    'labelField' => 'name',
    'searchFields',
    'listAttributes' => '',
    'multiple' => false,
    'actions' => [],
    'selected' => [], // <-- preselected data
])

<div class="mb-3">
    @if($label)
        <label for="autocomplete-{{ $field }}" class="custom-label">
            {{ $label }}
        </label>
    @endif

    <div id="autocomplete-{{ $field }}" class="autocomplete-component" 
         data-field="{{ $field }}"
         data-table="{{ $table }}"
         data-value-field="{{ $valueField }}"
         data-label-field="{{ $labelField }}"
         data-search-fields="{{ $searchFields }}"
         data-list-attributes="{{ $listAttributes }}"
         data-multiple="{{ $multiple ? 'true' : 'false' }}"
         data-actions='@json($actions)'
         data-selected='@json($selected)'>

        <div class="relative">
            
            <input 
                id="search-input"
                type="text" 
                placeholder="Search..."
                class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300"
            >
            <x-modal 
                buttonText=' <i class="fas fa-list"></i>'
                modalTitle="Select Category"
                id="autocomplete_modal"
                ajaxUrl="/admin/autocomplete/list?table={{$table}}&list_attributes={{$listAttributes}}"
                buttonClass="absolute right-2 top-2 text-gray-500 hover:text-gray-800"
                modalSize="3xl"
            />
        </div>

        <ul id="results-list" class="relative z-10 bg-white border rounded mt-1 w-auto shadow hidden"></ul>

        <div id="selected-items" class="flex flex-wrap gap-2 mt-2"></div>

        <div id="hidden-inputs"></div>
    </div>
</div>
