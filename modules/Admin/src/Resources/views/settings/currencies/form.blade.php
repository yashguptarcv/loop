<form id="currencyForm" class="form-ajax" method="POST"
    action="@isset($currency) {{ route('admin.settings.currencies.update', $currency->id) }} @else {{ route('admin.settings.currencies.store') }} @endisset">
    @csrf
    @isset($currency) @method('PUT') @endisset


    <!-- Code Field -->
    <div class="mb-2">
        <label class="custom-label required" for="code">Code</label>
        <input type="text" name="code" id="code"
            value="{{ $currency->code ?? old('code') }}"
            class="input-field">
    </div>
    <!-- Currency Name Field  -->
    <div class="mb-2">
        <label class="custom-label required">Currency Name</label>
        <input type="text" name="name" id="name"
            value="{{ $currency->name ?? old('name') }}"
            class="input-field">
    </div>
    <!-- Currency Symbol Field  -->
    <div class="mb-2">
        <label class="custom-label ">Symbol</label>
        <input type="text" name="symbol" id="name"
            value="{{ $currency->symbol ?? old('name') }}"
            class="input-field">
    </div>
    <!-- Currency decimal Field  -->
    <div class="mb-2">
        <label class="custom-label">Currency Decimal</label>
        <input type="text" name="decimal" id="name"
            value="{{ $currency->decimal ?? old('name') }}"
            class="input-field">
    </div>

    <!-- Currency decimal Field  -->
    <div class="mb-2">
        <label class="custom-label">Currency Rate</label>
        <input type="text" name="target_currency" id="target_currency"
            value="{{ old('rate', $rate->rate ?? '') }}"
            class="input-field">
    </div>


    <div class="mt-8 flex justify-end space-x-3">
        <x-button type="submit" class="blue" label="Save" icon='' name='button' />

    </div>
</form>