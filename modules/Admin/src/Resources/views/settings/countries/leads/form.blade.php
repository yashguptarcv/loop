@extends('admin::layouts.app')

@section('title', 'Country Management')

@section('content')
    @include('admin::components.common.back-button', ['route' => route('admin.settings.countries.leads.index'), 'name' => !empty($country) ? 'Edit country' : 'Add Country'])

    <div class="bg-[var(--color-white)] rounded-xl shadow-sm border border-blue-100 p-6">
        
        <form id="userForm" class="form-ajax" method="POST" 
              action="@isset($country) {{ route('admin.settings.countries.leads.update', $country->id) }} @else {{ route('admin.settings.countries.leads.store') }} @endisset">
            @csrf
            @isset($country) @method('PUT') @endisset

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Code Field -->
                <div class="col-span-1">
                    <label class="custom-label">Code</label>
                    <input type="text" name="code" id="code" 
                           value="{{ $country->code ?? old('code') }}"
                         class="input-field"  required>
                </div>
                <!-- Country Name Field  -->
                <div class="col-span-1">
                    <label class="custom-label">Country</label>
                    <input type="text" name="name" id="name" 
                           value="{{ $country->name ?? old('name') }}"
                         class="input-field"  required>
                </div>
              
            </div>

            <div class="mt-8 flex justify-end space-x-3">
                <x-button type="submit"  class="blue" label="Save" icon='' name='button'/> 
            </div>
        </form>
    </div>

@endsection