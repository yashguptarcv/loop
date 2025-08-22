<div class="mt-8 bg-white shadow rounded-lg overflow-hidden">
    <div class="px-6 py-6">
        <div class="space-y-6">

            <!-- Google app name  -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6">
                <div class="md:col-span-1">
                    <label for="tax" class="block text-sm font-medium text-gray-700">Google Setting</label>
                    <p class="mt-1 text-sm text-gray-500">Set Google Keys to use Google Meetings.</p>
                </div>
                <div class="md:col-span-2">
                    <p class="mb-3 text-sm text-gray-500">App name.</p>
                    <input type="text" id="app_name" name="settings[general.google.app_name]"
                        value="{{ old('general.google.app_name', fn_get_setting('general.google.app_name')) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
            </div>

            <!-- Google client id -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 ">
                <div class="md:col-span-1"></div>
                <div class="md:col-span-2">
                    <p class="mb-3 text-sm text-gray-500">Client ID</p>
                    <input type="text" id="general.google.client_id" name="settings[general.google.client_id]"
                        value="{{ old('general.google.client_id', fn_get_setting('general.google.client_id')) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md">

                </div>
            </div>

            <!-- Google client_secret -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 ">
                <div class="md:col-span-1">
                </div>
                <div class="md:col-span-2">
                    <p class="mb-3 text-sm text-gray-500">Client Secret</p>
                    <input type="text" id="general.google.client_secret" name="settings[general.google.client_secret]"
                        value="{{ old('general.google.client_secret', fn_get_setting('general.google.client_secret')) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md">

                </div>
            </div>

            <!-- Google redirect -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 ">
                <div class="md:col-span-1">
                </div>
                <div class="md:col-span-2">
                    <p class="mb-3 text-sm text-gray-500">Redirect URL</p>
                    <input type="text" id="redirect" name="settings[general.google.redirect_url]"
                        value="{{ old('general.google.redirect_url', fn_get_setting('general.google.redirect_url')) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md">

                </div>
            </div>


            <!-- whatsapp access_token -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-200">
                <div class="md:col-span-1">
                    <label for="tax" class="block text-sm font-medium text-gray-700">Whatsapp Setting</label>
                    <p class="mt-1 text-sm text-gray-500">Set Whatsapp Credentials to use whatsapp notification and promotion.</p>
                </div>
                <div class="md:col-span-2">
                    <p class="mb-3 text-sm text-gray-500">Access Token.</p>
                    <input type="text" id="access_token" name="settings[general.whatsapp.access_token]"
                        value="{{ old('general.whatsapp.access_token', fn_get_setting('general.whatsapp.access_token')) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md">

                </div>
            </div>

            <!-- whatsapp phone number -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6">
                <div class="md:col-span-1">
                </div>
                <div class="md:col-span-2">
                    <p class="mb-3 text-sm text-gray-500">Phone ID.</p>
                    <input type="text" id="phone_number" name="settings[general.whatsapp.phone_number]"
                        value="{{ old('general.whatsapp.phone_number', fn_get_setting('general.whatsapp.phone_number')) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md">

                </div>
            </div>

            <!-- whatsapp business account id -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6">
                <div class="md:col-span-1">

                </div>
                <div class="md:col-span-2">
                    <p class="mb-3 text-sm text-gray-500">Business Account ID.</p>
                    <input type="text" id="business_account_id" name="settings[general.whatsapp.business_account_id]"
                        value="{{ old('general.whatsapp.business_account_id', fn_get_setting('general.whatsapp.business_account_id')) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6">
                <div class="md:col-span-1">

                </div>
                <div class="md:col-span-2">
                    <p class="mb-3 text-sm text-gray-500">Meeting Gap</p>
                    <input type="text" id="business_account_id" name="settings[general.google.meeting_gap]"
                        value="{{ old('general.google.meeting_gap', fn_get_setting('general.google.meeting_gap')) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6">
                <div class="md:col-span-1">

                </div>
                <div class="md:col-span-2">
                    <p class="mb-3 text-sm text-gray-500">Meeting Default Color</p>
                    <input type="text" id="business_account_id" name="settings[general.google.meeting_color]"
                        value="{{ old('general.google.meeting_color', fn_get_setting('general.google.meeting_color')) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
            </div>
        </div>
    </div>

</div>