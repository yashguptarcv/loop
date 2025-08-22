@extends('admin::layouts.app')

@section('title', isset($taxes) ? 'Edit taxes' : 'Create Tax')

@section('content')
@include('admin::components.common.back-button', ['route' => route('admin.settings.taxes.index'), 'name' => isset($taxes) ? 'Edit Tax' : 'Create Tax'])

<form id="taxesForm" class="form-ajax grid grid-cols-1 lg:grid-cols-3 gap-6" method="POST"
    action="@isset($taxes) {{ route('admin.settings.taxes.update', $taxes->id) }} @else {{ route('admin.settings.taxes.store') }} @endisset"
    enctype="multipart/form-data">
    @csrf
    @isset($taxes) @method('PUT') @endisset

    <!-- Left Column (2/3) -->
    <div class="lg:col-span-2 bg-white rounded-lg  p-6 space-y-6">

        <!-- taxes_message -->
        <input type="hidden" name="taxes_message" value="{{ old('taxes_message', $taxes->taxes_message ?? '') }}" id="activity-description">
        <div>
            <label class="custom-label">taxes Message</label>
            <textarea id="message-editor" rows="8"
                class="hidden">{{ old('taxes_message', $taxes->taxes_message ?? '') }}</textarea>
        </div>

        <!-- taxes type -->
        <div>
            <label for="taxes_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                taxes Type: <span class="text-red-500">*</span>
            </label>
            <select id="taxes_type" name="taxes_type"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200"
                required>
                <option value="F" {{ old('taxes_type', $taxes->taxes_type ?? '') == 'F' ? 'selected' : '' }}>Fixed</option>
                <option value="P" {{ old('taxes_type', $taxes->taxes_type ?? '') == 'P' ? 'selected' : '' }}>Percentage</option>

            </select>

        </div>

        <!-- Value taxes -->
        <div id="auto-complete">
            <label for="country" class="block text-sm font-medium text-gray-700 mb-1">taxes Value <span class="text-red-500">*</span></label>
            <input
                type="text"
                autocomplete="dropdown"
                name="taxes_value"
                value=""
                placeholder=""
                id="taxes_value"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                data-table="categories"
                data-select_columns="id, name"
                data-search_column="name"
                data-target="parent_id"
                data-original-value="" />
            <input
                type="hidden"
                name="parent_id"
                id="parent_id"
                value=""
                class="mt-1"
                data-original-value="" />

            @error('taxes_value')
            <div class="text-red-500 text-sm mt-1">
                {{ $message }}
            </div>
            @enderror
        </div>

        <!-- taxes Used Count -->
        <div>
            <label class="custom-label">taxes Used Count</label>
            <input type="text" name="taxes_used_count" class="input-field"
                value="{{ old('taxes_used_count', $taxes->taxes_used_count ?? '') }}">
        </div>

        <!-- taxes Per User -->
        <div>
            <label class="custom-label">taxes Per User</label>
            <input type="text" name="taxes_per_user" class="input-field"
                value="{{ old('taxes_per_user', $taxes->taxes_per_user ?? '') }}">
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="custom-label">taxes Start Date</label>
                <input type="date" name="start_date" class="input-field"
                    value="{{ old('start_date', $taxes->start_date ?? '') }}">
            </div>
            <div>
                <label class="custom-label">taxes End Date</label>
                <input type="date" name="end_date" class="input-field"
                    value="{{ old('end_date', $taxes->end_date ?? '') }}">
            </div>
        </div>



    </div>

    <!-- Right Column (1/3) -->
    <div class="bg-white rounded-lg  p-6 space-y-6">
        <!-- Name -->
        <div>
            <label class="custom-label">Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $taxes->name ?? '') }}"
                class="input-field">
            @error('name')
            <div class="text-red-500 text-sm mt-1">
                {{ $message }}
            </div>
            @enderror
        </div>

        <!-- taxes Code -->
        <div>
            <label class="custom-label">taxes Code <span class="text-red-500">*</span></label>
            <input type="text" name="taxes_code" id="taxes_code" value="{{ old('taxes_code', $taxes->taxes_code ?? '') }}"
                class="input-field">
            @error('taxes_code')
            <div class="text-red-500 text-sm mt-1">
                {{ $message }}
            </div>
            @enderror

        </div>

        <!-- taxes Status -->
        <div>
            <label class="custom-label">taxes Status</label>
            <input type="text" name="taxes_status" id="taxes_status"
                value="{{ old('taxes_status', $taxes->taxes_status ?? 0) }}" class="input-field">
        </div>



        <div class="flex justify-end">

            <x-button type="submit"
                class="blue"
                label="Save"
                icon=''
                name="button" />
        </div>
    </div>
</form>

@endsection

@section('scripts')
<script>
    document.getElementById('taxes_code').addEventListener('input', function() {
        this.value = this.value
            .toLowerCase()
            .replace(/\s+/g, '-')
            .replace(/[^a-z0-9\-]/g, '');
    });
</script>

<script>
    // TinyMCE
    tinymce.init({
        selector: '#message-editor',
        plugins: 'link lists mentions',
        toolbar: 'undo redo | bold italic | bullist numlist | link | mentions',
        menubar: false,
        statusbar: false,
        height: 200,
        setup: function(editor) {
            editor.on('change', function() {
                document.getElementById('activity-description').value = editor.getContent();
            });
        }
    });
</script>
@endsection