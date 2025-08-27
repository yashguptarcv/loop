@extends('admin::layouts.app')

@section('title', 'Currency Management')

@section('content')
    @include('admin::components.common.back-button', ['route' => route('admin.settings.currencies.leads.index'), 'name' => !empty($currency) ? 'Edit currency' : 'Add New currency'])

    <div class="bg-white-100 rounded-xl shadow-sm border border-blue-100 p-6">
         
        <form id="currencyForm" class="form-ajax" method="POST" 
              action="@isset($currency) {{ route('admin.settings.currencies.leads.update', $currency->id) }} @else {{ route('admin.settings.currencies.leads.store') }} @endisset">
            @csrf
            @isset($currency) @method('PUT') @endisset

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Code Field -->
                <div class="col-span-1">
                    <label class="custom-label">Code</label>
                    <input type="text" name="code" id="code" 
                           value="{{ $currency->code ?? old('code') }}"
                         class="input-field"  required>
                </div>
                <!-- Currency Name Field  -->
                <div class="col-span-1">
                    <label class="custom-label">Currency Name</label>
                    <input type="text" name="name" id="name" 
                           value="{{ $currency->name ?? old('name') }}"
                         class="input-field"  required>
                </div>
                <!-- Currency Symbol Field  -->
                <div class="col-span-1">
                    <label class="custom-label">Symbol</label>
                    <input type="text" name="symbol" id="name" 
                           value="{{ $currency->symbol ?? old('name') }}"
                         class="input-field"  required>
                </div>
                <!-- Currency decimal Field  -->
                <div class="col-span-1">
                    <label class="custom-label">Currency Decimal</label>
                    <input type="text" name="decimal" id="name" 
                           value="{{ $currency->decimal ?? old('name') }}"
                         class="input-field"  required>
                </div>
            </div>

            <div class="mt-8 flex justify-end space-x-3">                
                <x-button type="submit"  class="blue" label="Save" icon='' name='button'/>                
                
            </div>
        </form>
    </div>

@endsection