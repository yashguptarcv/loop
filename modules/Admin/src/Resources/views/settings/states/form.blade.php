<form id="stateForm" class="form-ajax" method="POST"
    action="@isset($state) {{ route('admin.settings.states.update', $state->id) }} @else {{ route('admin.settings.states.store') }} @endisset">
    @csrf
    @isset($state) @method('PUT') @endisset

    <div class="flex flex-col gap-3">

        <!-- Country Name -->
        <div class="col-span-1">
            <label class="custom-label required" for="country">Country Name</label>
            <select name="country_id" id="country" class="input-field" required>
                <option value="">-- Select Country --</option>
                @foreach ($countries as $country)
                <option value="{{ $country->id }}"
                    data-code="{{ $country->code }}"
                    {{ old('country_id', $state->country_id ?? null) == $country->id ? 'selected' : '' }}>
                    {{ $country->name }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- State Name -->
        <div class="col-span-1">
            <label class="custom-label required">State Name</label>
            <input type="text" name="default_name" id="default_name"
                value="{{ old('default_name', $state->default_name ?? '') }}"
                class="input-field">
        </div>

        <!-- State Code -->
        <div class="col-span-1">
            <label class="custom-label required">Code</label>
            <input type="text" name="code" id="code"
                value="{{ old('code', $state->code ?? '') }}"
                class="input-field">
        </div>


    </div>

    <div class="mt-8 flex justify-end space-x-3">
        <x-button type="submit" class="blue" label="Save" icon='' name='button' />
    </div>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const countrySelect = document.getElementById('country');
        const countryCodeInput = document.getElementById('country_code');

        function setCountryCodeFromSelected() {
            const selectedOption = countrySelect.options[countrySelect.selectedIndex];
            const code = selectedOption.getAttribute('data-code') || '';
            countryCodeInput.value = code;
            console.log(code);

        }

        // On country change
        countrySelect.addEventListener('change', setCountryCodeFromSelected);

        // Auto-fill on page load (for edit mode)
        if (!countryCodeInput.value) {
            setCountryCodeFromSelected();
        }
    })
</script>