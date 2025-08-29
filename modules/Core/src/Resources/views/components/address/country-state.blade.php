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
<div id="country_state_container" class="space-y-4">
    <!-- Country -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
        <select id="country_select" name="{{ $country_field }}" class="w-full border rounded-lg px-3 py-2 text-sm">
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
        <label class="block text-sm font-medium text-gray-700 mb-1">State</label>
        <select id="state_select" name="{{ $state_field }}" class="w-full border rounded-lg px-3 py-2 text-sm">
            <option value="">-- Select State --</option>
        </select>
        @error($state_field)
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>