@extends('admin::layouts.app')

@section('title', 'State Management')

@section('content')

    @include('admin::components.common.back-button', ['route' => route('admin.settings.states.leads.index'), 'name' => !empty($state) ? 'Edit state' : 'Add State'])


    <div class="bg-[var(--color-white)] rounded-xl shadow-sm border border-blue-100 p-6">
        <form id="stateForm" class="form-ajax" method="POST"
            action="@isset($state) {{ route('admin.settings.states.leads.update', $state->id) }} @else {{ route('admin.settings.states.leads.store') }} @endisset">
            @csrf
            @isset($state) @method('PUT') @endisset

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Country Code Field -->
                <div class="col-span-1">
                    <label class="custom-label">Country Code</label>
                    <input type="text" name="country_code" id="country_code"
                        value="{{ $state->country_code ?? old('country_code') }}"
                        class="input-field" required>
                </div>
                <!-- Code Field  -->
                <div class="col-span-1">
                    <label class="custom-label">Code</label>
                    <input type="text" name="code" id="code"
                        value="{{ $state->code ?? old('code') }}"
                        class="input-field" required>
                </div>
                <!-- Country name -->
                <div class="col-span-1">
                    <label class="custom-label" for="country">Country name</label>
                    <select name="country_id" id="country" class="input-field" required>
                        <option value="">-- Select Country --</option>
                        @foreach ($countries as $country)
                        <option value="{{ $country->id }}"
                            {{ (old('country_name', $country->country_id ?? null) == $country->name) ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <!-- State name -->
                <div class="col-span-1">
                    <label class="custom-label">State name</label>
                    <input type="text" name="default_name" id="code"
                        value="{{ $state->default_name ?? old('default_name') }}"
                        class="input-field" required>
                </div>

            </div>

            <div class="mt-8 flex justify-end space-x-3">
                <x-button type="submit"  class="blue" label="Save" icon='' name='button' />
            </div>
        </form>
    </div>

@endsection