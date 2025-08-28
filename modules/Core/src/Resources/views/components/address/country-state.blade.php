@props([
    'countries' => null,   // optional visible label
    'selectedCountry',
    'selectedState',
    'prefix'
])
<div x-data="countryStateSelect()" x-init="init()" class="space-y-4">
    <!-- Country -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
        <select x-model="country" name="{{$prefix}}country" @change="loadStates" class="w-full border rounded-lg px-3 py-2 text-sm">
            <option value="">-- Select Country --</option>
            @foreach($countries as $country)
                <option value="{{ $country->id }}">
                    {{ $country->name }}
                </option>
            @endforeach
        </select>

        @error('country')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- State -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">State</label>
        <select x-model="state" name="{{$prefix}}state" class="w-full border rounded-lg px-3 py-2 text-sm">
            <option value="">-- Select State --</option>
            <template x-for="s in states" :key="s.id">
                <option :value="s.id" x-text="s.name"></option>
            </template>
        </select>
        @error('state')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>
</div>

<script>
function countryStateSelect() {
    return {
        country: @json($selectedCountry),
        state: @json($selectedState),
        states: [],

        loadStates() {
            
            if (!this.country) {
                this.states = [];
                this.state = null;
                return;
            }

            fetch(`/api/countries/${this.country}/states`)
                .then(res => res.json())
                .then(data => {                    
                    this.states = data;
                     // Set the selected state AFTER the states are loaded
                    if (this.state && data.find(s => String(s.id) === String(this.state))) {
                        this.state = 'asdasd';
                    } else {
                        this.state = null;
                    }
                });
        },

        init() {
            if (this.country) {
                this.loadStates();
            }
        }
    }
}
</script>
