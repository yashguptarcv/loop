@props([
    'countries' => null,   // optional visible label
    'selectedCountry',
    'selectedState',
    'prefix'    => null,
    'country_name'  => null,
    'state_name'    => null,
])

@php
    $country_field = $prefix.'country';
    if(!empty($country_name)) {
        $country_field = $country_name;
    }

    $state_field = $prefix.'state';
    if(!empty($state_name)) {
        $state_field = $state_name;
    }
@endphp
<div class="country_state_container grid grid-cols-1 md:grid-cols-2 mt-4 gap-4">
    <!-- Country -->
    <div>
        <label class="custom-label">Country</label>
        <select data-country name="{{ $country_field }}" class="input-field">
            <option value="">-- Select Country --</option>
            @foreach($countries as $country)
                <option value="{{ $country->id }}" 
                    {{ (string)$selectedCountry === (string)$country->id ? 'selected' : '' }}>
                    {{ $country->name }}
                </option>
            @endforeach
        </select>
        @error($country_field)
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- State -->
    <div>
        <label class="custom-label">State</label>
        <input type="hidden" data-selected-state value="{{ $selectedState }}">
        <select data-state name="{{ $state_field }}" class="input-field">
            <option value="">-- Select State --</option>
        </select>
        @error($state_field)
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>