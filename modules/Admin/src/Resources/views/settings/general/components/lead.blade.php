<div class="mt-8 bg-white shadow rounded-lg overflow-hidden">

    <div class="px-6 py-6">
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-200">
                <div class="md:col-span-1">
                    <label for="product" class="block text-sm font-medium text-gray-700">Default Application Product</label>
                    <p class="mt-1 text-sm text-gray-500">Set Application Product That Will Use Will Application Send Time.</p>
                </div>
                <div class="md:col-span-2">
                    <select id="products" name="settings[general.lead.product]" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        @foreach (fn_get_products() as $product)
                        <option value="{{ $product->id }}"
                            {{ old('general.lead.product', fn_get_setting('general.lead.product')) == $product->id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- roles -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-200">
                <div class="md:col-span-1">
                    <label for="role" class="block text-sm font-medium text-gray-700">Default Lead Assigne UserGroup</label>
                    <p class="mt-1 text-sm text-gray-500">Selected user group will manage all leads</p>
                </div>
                <div class="md:col-span-2">
                    <select id="roles" name="settings[general.lead.user_group]" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        @foreach (fn_get_usergroups() as $role)
                        <option value="{{ $role->id }}"
                            {{ old('general.lead.user_group', fn_get_setting('general.lead.user_group')) == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- roles -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-200">
                <div class="md:col-span-1">
                    <label for="role" class="block text-sm font-medium text-gray-700">Default Lead Assigne Status</label>
                    <p class="mt-1 text-sm text-gray-500">If no status select then lead will use this status.</p>
                </div>
                <div class="md:col-span-2">
                    <select id="roles" name="settings[general.lead.status]" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        @foreach (fn_get_lead_statuses() as $status)
                        <option value="{{ $status->id }}"
                            {{ old('general.lead.status', fn_get_setting('general.lead.status')) == $status->id ? 'selected' : '' }}>
                            {{ $status->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-200">
                <div class="md:col-span-1">
                    <label for="role" class="block text-sm font-medium text-gray-700">Default Lead Source</label>
                    <p class="mt-1 text-sm text-gray-500">If no status select then lead will use that source.</p>
                </div>
                <div class="md:col-span-2">
                    <select id="roles" name="settings[general.lead.source]" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        @foreach (fn_get_lead_sources() as $status)
                        <option value="{{ $status->id }}"
                            {{ old('general.lead.source', fn_get_setting('general.lead.source')) == $status->id ? 'selected' : '' }}>
                            {{ $status->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-200">
                <div class="md:col-span-1">
                    <label for="role" class="block text-sm font-medium text-gray-700">Default Lead Creation User</label>
                    <p class="mt-1 text-sm text-gray-500">If no status select then lead will use that creation user.</p>
                </div>
                <div class="md:col-span-2">
                    <select id="roles" name="settings[general.lead.default_user]" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        @foreach (fn_get_users() as $status)
                        <option value="{{ $status->id }}"
                            {{ old('general.lead.default_user', fn_get_setting('general.lead.default_user')) == $status->id ? 'selected' : '' }}>
                            {{ $status->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-200">
                <div class="md:col-span-1">
                    <label for="award_category" class="block text-sm font-medium text-gray-700">Award Categories</label>
                </div>
                <div class="md:col-span-2">
                    <input type="text" id="award_category" name="settings[general.lead.award_category]"
                        value="{{ old('general.lead.award_category', fn_get_setting('general.lead.award_category')) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
            </div>
        </div>
    </div>
</div>