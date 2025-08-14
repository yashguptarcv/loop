@extends('admin::layouts.app')

@section('title', isset($coupons) ? 'Edit Coupons' : 'Create Coupons')

@section('content')
@include('admin::components.common.back-button', ['route' => route('admin.coupons.index'), 'name' => isset($coupons) ? 'Edit Coupons' : 'Create Coupons'])

<form id="CouponsForm" class="form-ajax grid grid-cols-1 lg:grid-cols-3 gap-6" method="POST"
    action="@isset($coupons) {{ route('admin.coupons.update', $coupons->id) }} @else {{ route('admin.coupons.store') }} @endisset"
    enctype="multipart/form-data">
    @csrf
    @isset($coupons) @method('PUT') @endisset

    <!-- Left Column (2/3) -->
    <div class="lg:col-span-2 bg-white rounded-lg  p-6 space-y-6">

        <!-- coupon_message -->
        <input type="hidden" name="coupon_message" value="{{ old('coupon_message', $coupons->coupon_message ?? '') }}" id="activity-description">
        <div>
            <label class="custom-label">Coupon Message</label>
            <textarea id="message-editor" rows="8"
                class="hidden">{{ old('coupon_message', $coupons->coupon_message ?? '') }}</textarea>
        </div>

        <!-- Coupons type -->
        <div>
            <label for="coupon_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Coupon Type: <span class="text-red-500">*</span>
            </label>
            <select id="coupon_type" name="coupon_type"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200"
                required>
                <option value="F" {{ old('coupon_type', $coupons->coupon_type ?? '') == 'F' ? 'selected' : '' }}>Fixed</option>
                <option value="P" {{ old('coupon_type', $coupons->coupon_type ?? '') == 'P' ? 'selected' : '' }}>Percentage</option>

            </select>

        </div>

        <!-- Value Coupons -->
        <div id="auto-complete">
            <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Coupon Value <span class="text-red-500">*</span></label>
            <input type="text" name="coupon_value" class="input-field"
                value="{{ old('coupon_value', $coupons->coupon_value ?? '') }}">
            

            @error('coupon_value')
            <div class="text-red-500 text-sm mt-1">
                {{ $message }}
            </div>
            @enderror
        </div>

        <!-- Coupon Used Count -->
        <div>
            <label class="custom-label">Coupon Used Count</label>
            <input type="text" name="coupon_used_count" class="input-field"
                value="{{ old('coupon_used_count', $coupons->coupon_used_count ?? '') }}">
        </div>

        <!-- Coupon Per User -->
        <div>
            <label class="custom-label">Coupon Per User</label>
            <input type="text" name="coupon_per_user" class="input-field"
                value="{{ old('coupon_per_user', $coupons->coupon_per_user ?? '') }}">
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="custom-label">Coupon Start Date <span class="text-red-500">*</span></label>
                <input type="date" name="start_date" class="input-field"
                    value="{{ old('start_date', $coupons->start_date ?? '') }}">
            </div>
            <div>
                <label class="custom-label">Coupon End Date <span class="text-red-500">*</span></label>
                <input type="date" name="end_date" class="input-field"
                    value="{{ old('end_date', $coupons->end_date ?? '') }}">
            </div>
        </div>



    </div>

    <!-- Right Column (1/3) -->
    <div class="bg-white rounded-lg  p-6 space-y-6">
        <!-- Name -->
        <div>
            <label class="custom-label">Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $coupons->name ?? '') }}"
                class="input-field">
            @error('name')
            <div class="text-red-500 text-sm mt-1">
                {{ $message }}
            </div>
            @enderror
        </div>

        <!-- Coupon Code -->
        <div>
            <label class="custom-label">Coupon Code <span class="text-red-500">*</span></label>
            <input type="text" name="coupon_code" id="coupon_code" value="{{ old('coupon_code', $coupons->coupon_code ?? '') }}"
                class="input-field">
            @error('coupon_code')
            <div class="text-red-500 text-sm mt-1">
                {{ $message }}
            </div>
            @enderror

        </div>

        <!-- Coupon Status -->

       <div>
            <label class="custom-label">Status</label>
            
                <select name="coupon_status" class="w-full bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-md leading-tight">
                    <option value="0" @if(!empty($coupons->coupon_status) && $coupons->coupon_status == '0')selected @endif>Active</option>
                    <option value="1" @if(!empty($coupons->coupon_status) && $coupons->coupon_status == '1')selected @endif>Inactive</option>
                </select>
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