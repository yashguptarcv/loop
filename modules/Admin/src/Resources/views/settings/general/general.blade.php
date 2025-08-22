<div class="mt-8 bg-white shadow rounded-lg overflow-hidden">
    <div class="px-6 py-6">
        <div class="space-y-6">
            <!-- Timezone -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-1">
                    <label for="timezone" class="block text-sm font-medium text-gray-700">Timezone</label>
                    <p class="mt-1 text-sm text-gray-500">Set the timezone for your organization.</p>
                </div>
                <div class="md:col-span-2">
                    <select id="timezone" name="settings[general.timezone]" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        @foreach ($timezones as $tzValue => $tzLabel)
                        <option value="{{ $tzValue }}" {{ old('settings[general.timezone]', fn_get_setting('general.timezone')) == $tzValue ? 'selected' : '' }}>
                            {{ $tzLabel }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Date Format -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-200">
                <div class="md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700">Date Format</label>
                    <p class="mt-1 text-sm text-gray-500">How dates should be displayed throughout the system.</p>
                </div>
                <div class="md:col-span-2">
                    <div class="flex space-x-4">
                        <div class="flex items-center">
                            <input id="date-format-1" name="settings[general.timestamp]" type="radio" checked class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                            <label for="date-format-1" class="ml-3 block text-sm font-medium text-gray-700">MM/DD/YYYY</label>
                        </div>
                        <div class="flex items-center">
                            <input id="date-format-2" name="settings[general.timestamp]" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                            <label for="date-format-2" class="ml-3 block text-sm font-medium text-gray-700">DD/MM/YYYY</label>
                        </div>
                        <div class="flex items-center">
                            <input id="date-format-3" name="settings[general.timestamp]" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                            <label for="date-format-3" class="ml-3 block text-sm font-medium text-gray-700">YYYY-MM-DD</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-200">
                <div class="md:col-span-1">
                    <label for="image_driver" class="block text-sm font-medium text-gray-700">Files Store</label>
                    <p class="mt-1 text-sm text-gray-500">Store Files (s3, local, etc)</p>
                </div>
                <div class="md:col-span-2">
                    <select id="image_driver" name="settings[general.image_driver]" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        @foreach (fn_get_upload_driver() as $fileDriver)
                        <option value="{{ $fileDriver }}"
                            {{ old('general.image_driver', fn_get_setting('general.image_driver')) == $fileDriver ? 'selected' : '' }}>
                            {{ $fileDriver }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Currency -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-200">
                <div class="md:col-span-1">
                    <label for="currency" class="block text-sm font-medium text-gray-700">Currency</label>
                    <p class="mt-1 text-sm text-gray-500">Set the currency for financial values.</p>
                </div>
                <div class="md:col-span-2">
                    <select id="currency" name="settings[general.currency]" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        @foreach (fn_get_currencies() as $currency)
                        <option value="{{ $currency->code }}" {{ old('general.currency', fn_get_setting('general.currency')) == $currency->code ? 'selected' : '' }}>
                            {{ $currency->name }} ({{ $currency->code }})
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Tax -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-200">
                <div class="md:col-span-1">
                    <label for="tax" class="block text-sm font-medium text-gray-700">Default Tax</label>
                    <p class="mt-1 text-sm text-gray-500">Set the default tax.</p>
                </div>
                <div class="md:col-span-2">
                    <select id="tax" name="settings[general.tax]" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        @foreach (fn_get_taxes() as $tax)
                        <option value="{{ $tax->id }}"
                            {{ old('general.tax', fn_get_setting('general.tax')) == $tax->id ? 'selected' : '' }}>
                            {{ $tax->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- general.per_page -->
        </div>
    </div>

</div>