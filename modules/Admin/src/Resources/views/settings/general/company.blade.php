<div class="mt-8 bg-white shadow rounded-lg overflow-hidden">

    <div class="px-6 py-6">
        <div class="space-y-6">
            <!-- set company mail -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-200">
                <div class="md:col-span-1">
                    <label for="mail" class="block text-sm font-medium text-gray-700">Company name</label>
                </div>
                <div class="md:col-span-2">
                    <input type="text" id="mail" name="settings[general.company.name]"
                        value="{{ old('general.company.name', fn_get_setting('general.company.name')) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-200">
                <div class="md:col-span-1">
                    <label for="mail" class="block text-sm font-medium text-gray-700">Company Default Mail</label>
                    <p class="mt-1 text-sm text-gray-500">Add mail to send notification to this mail.</p>
                </div>
                <div class="md:col-span-2">
                    <input type="text" id="mail" name="settings[general.company.mail]"
                        value="{{ old('general.company.mail', fn_get_setting('general.company.mail')) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
            </div>

            <!-- company business address -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-200">
                <div class="md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700">Company Business Address</label>
                    <p class="mt-1 text-sm text-gray-500">Enter detailed business address.</p>
                </div>
                <div class="md:col-span-2 space-y-4">
                    <div>
                        <label for="address_street" class="block text-sm font-medium text-gray-700">Street</label>
                        <input type="text" id="address_street" name="settings[general.company.address_street]"
                            value="{{ old('general.company.address_street', fn_get_setting('general.company.address_street')) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="address_city" class="block text-sm font-medium text-gray-700">City</label>
                            <input type="text" id="address_city" name="settings[general.company.address_city]"
                                value="{{ old('general.company.address_city', fn_get_setting('general.company.address_city')) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="address_state" class="block text-sm font-medium text-gray-700">State</label>
                            <input type="text" id="address_state" name="settings[general.company.address_state]"
                                value="{{ old('general.company.address_state', fn_get_setting('general.company.address_state')) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="address_postal" class="block text-sm font-medium text-gray-700">Postal Code</label>
                            <input type="text" id="address_postal" name="settings[general.company.address_postal]"
                                value="{{ old('general.company.address_postal', fn_get_setting('general.company.address_postal')) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        </div>
                        <div>
                            <select id="country" name="settings[general.company.country]" class="w-full mt-6 px-3 py-2 border border-gray-300 rounded-md">
                                @foreach (fn_get_countries() as $country)
                                <option value="{{ $country->code }}"
                                    {{ old('settings[general.company.country]') == $country->code ? 'selected' : '' }}>
                                    {{ $country->name }} ({{ $country->code }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>



            <!-- company logo upload -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-200">
                <div class="md:col-span-1">
                    <label for="company_logo" class="block text-sm font-medium text-gray-700">Company Logo</label>
                    <p class="mt-1 text-sm text-gray-500">Upload the company logo.</p>
                </div>
                <div class="md:col-span-2">
                    @include('filemanager::components.file-uploader', ['object_type' => 'company_logo', 'object_id' => 0, 'name' => 'company_logo'])
                </div>
            </div>

            <!-- company Fav icon upload -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-200">
                <div class="md:col-span-1">
                    <label for="company_logo" class="block text-sm font-medium text-gray-700">Company Fav icon</label>
                    <p class="mt-1 text-sm text-gray-500">Upload the company Favicon.</p>
                </div>
                <div class="md:col-span-2">
                    @include('filemanager::components.file-uploader', ['object_type' => 'company_favicon', 'object_id' => 0, 'name' => 'company_favicon'])
                </div>
            </div>

            <!-- signature editor -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-200">
                <div class="md:col-span-1">
                    <label for="signature" class="block text-sm font-medium text-gray-700">Signature</label>
                    <p class="mt-1 text-sm text-gray-500">Add your signature with formatting.</p>
                </div>
                <div class="md:col-span-2">
                    <textarea id="signature" editor="true" name="settings[general.company.signature]" rows="6"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md">{{ old('general.company.signature', fn_get_setting('general.company.signature')) }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>