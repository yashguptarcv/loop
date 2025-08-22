<!-- Mail Driver Section -->
<div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-800">
            Mail Server Configuration
        </h2>
        <p class="mt-1 text-sm text-gray-500">Set up your email server settings</p>
    </div>
    <div class="px-6 py-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700">Mail Driver</label>
                <p class="mt-1 text-sm text-gray-500">Select your email delivery method</p>
            </div>
            <div class="md:col-span-2">
                <select name="settings[general.mail.driver]" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    @php
                    $selectedDriver = old('general.mail.driver', fn_get_setting('general.mail.driver'));
                    @endphp
                    <option value="smtp" {{ $selectedDriver == 'smtp' ? 'selected' : '' }}>SMTP</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- SMTP Settings Section -->
<div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-800">
            SMTP Settings
        </h2>
        <p class="mt-1 text-sm text-gray-500">Configure your SMTP server details</p>
    </div>
    <div class="px-6 py-6 space-y-6">
        <!-- Mail Host -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700">Mail Host</label>
                <p class="mt-1 text-sm text-gray-500">Your email server address</p>
            </div>
            <div class="md:col-span-2">
                <input name="settings[general.mail.host]" type="text" value="{{ old('general.mail.host', fn_get_setting('general.mail.host')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <!-- Mail Port -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-200">
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700">Mail Port</label>
                <p class="mt-1 text-sm text-gray-500">Port number for your email server</p>
            </div>
            <div class="md:col-span-2">
                <input name="settings[general.mail.port]" type="text" value="{{ old('general.mail.port', fn_get_setting('general.mail.port')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <!-- Mail Username -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-200">
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700">Mail Username</label>
                <p class="mt-1 text-sm text-gray-500">Your email account username</p>
            </div>
            <div class="md:col-span-2">
                <input name="settings[general.mail.username]" type="text" value="{{ old('general.mail.username', fn_get_setting('general.mail.username')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <!-- Mail Password -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-200">
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700">Mail Password</label>
                <p class="mt-1 text-sm text-gray-500">Your email account password</p>
            </div>
            <div class="md:col-span-2">
                <div class="relative">
                    <input name="settings[general.mail.password]" type="text" value="{{ old('general.mail.password', fn_get_setting('general.mail.password')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
        </div>

        <!-- Mail Encryption -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-200">
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700">Mail Encryption</label>
                <p class="mt-1 text-sm text-gray-500">Encryption method for email transmission</p>
            </div>
            <div class="md:col-span-2">
                <select name="settings[general.mail.encryption]" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    @php
                    $selectedDriver = old('general.mail.encryption', fn_get_setting('general.mail.encryption'));
                    @endphp

                    <option value="tsl" {{ $selectedDriver == 'tsl' ? 'selected' : '' }}>TSL</option>
                    <option value="ssl" {{ $selectedDriver == 'ssl' ? 'selected' : '' }}>SSL</option>
                    <option value="none" {{ $selectedDriver == 'none' ? 'selected' : '' }}>None</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Email Address Configuration -->
<div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-800">
            Email Address Configuration
        </h2>
        <p class="mt-1 text-sm text-gray-500">Set up your email addresses</p>
    </div>
    <div class="px-6 py-6 space-y-6">
        <!-- From Address -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700">Mail From Address</label>
                <p class="mt-1 text-sm text-gray-500">The email address that will appear as sender</p>
            </div>
            <div class="md:col-span-2">
                <input name="settings[general.mail.mail_from]" type="text" value="{{ old('general.mail.mail_from', fn_get_setting('general.mail.mail_from')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <!-- From Name -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-200">
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700">Mail From Name</label>
                <p class="mt-1 text-sm text-gray-500">The name that will appear as sender</p>
            </div>
            <div class="md:col-span-2">
                <input name="settings[general.mail.mail_from_name]" type="text" value="{{ old('general.mail.mail_from_name', fn_get_setting('general.mail.mail_from_name')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <!-- CC Emails -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-200">
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700">Add CC</label>
                <p class="mt-1 text-sm text-gray-500">Use comma separated values to add multiple CC addresses</p>
            </div>
            <div class="md:col-span-2">
                <input name="settings[general.mail.cc]" type="text" placeholder="admin@example.com, manager@example.com" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" value="{{ old('general.mail.cc', fn_get_setting('general.mail.cc')) }}">
            </div>
        </div>
    </div>
</div>

<!-- Test Email Section -->
<div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-800">
            Test Email Configuration
        </h2>
        <p class="mt-1 text-sm text-gray-500">Send a test email to verify your configuration</p>
    </div>
    <div class="px-6 py-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700">Test Email</label>
                <p class="mt-1 text-sm text-gray-500">Send a test email to verify your settings</p>
            </div>
            <div class="md:col-span-2">
                <div class="flex space-x-4">
                    <input name="settings[general.mail.driver]" type="text" placeholder="recipient@example.com" class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <button type="button" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Send Test
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>