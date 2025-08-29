<form id="userForm" class="form-ajax" method="POST"
    action="{{ isset($customer) ? route('admin.customers.update', $customer->id) : route('admin.customers.store') }}">
    @csrf

    @if(isset($customer))
        @method('PUT')
    @endif

    <!-- Customer Info -->
    <div class="bg-white pb-6 ">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Customer Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input id="name" type="text" name="name"
                    value="{{ old('name', $customer->name ?? '') }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"
                    placeholder="John Doe">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" name="email"
                    value="{{ old('email', $customer->email ?? '') }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"
                    placeholder="john@example.com">
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                <input id="phone" type="text" name="phone"
                    value="{{ old('phone', $customer->phone ?? '') }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"
                    placeholder="+91 xxx xxx xxxx">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" type="password" name="password"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"
                    placeholder="********">
            </div>
        </div>
    </div>

    <!-- Billing Address -->
    <div class="bg-white pb-6 ">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Billing Address</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="billing_address_1" class="block text-sm font-medium text-gray-700">Address 1</label>
                <input id="billing_address_1" type="text" name="billing_address_1"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>
            <div>
                <label for="billing_address_2" class="block text-sm font-medium text-gray-700">Address 2</label>
                <input id="billing_address_2" type="text" name="billing_address_2"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>
            <div>
                <label for="billing_city" class="block text-sm font-medium text-gray-700">City</label>
                <input id="billing_city" type="text" name="billing_city"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>
            <div>
                <x-country-state
                    input_id_prefix="billing"
                    :state_name="'billing_state'"
                    :country_name="'billing_country'"
                    :countries="fn_get_countries()->toArray()"
                    :selectedCountry="$lead->country ?? null"
                    :selectedState="$lead->state ?? null"
                />
            </div>
            <div>
                <label for="billing_zip" class="block text-sm font-medium text-gray-700">Zip Code</label>
                <input id="billing_zip" type="text" name="billing_zip"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>
        </div>
    </div>

    <!-- Shipping Address -->
    <div class="bg-white pb-6 ">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Shipping Address</h2>
            <label for="sameAsBilling" class="inline-flex items-center text-sm text-gray-600">
                <input type="checkbox" id="sameAsBilling"
                    class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <span class="ml-2">Same as Billing</span>
            </label>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="shippingFields">
            <div>
                <label for="shipping_address_1" class="block text-sm font-medium text-gray-700">Address 1</label>
                <input id="shipping_address_1" type="text" name="shipping_address_1"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>
            <div>
                <label for="shipping_address_2" class="block text-sm font-medium text-gray-700">Address 2</label>
                <input id="shipping_address_2" type="text" name="shipping_address_2"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>
            <div>
                <label for="shipping_city" class="block text-sm font-medium text-gray-700">City</label>
                <input id="shipping_city" type="text" name="shipping_city"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>
            <div>
                <x-country-state
                    input_id_prefix="shipping"
                    :state_name="'shipping_state'"
                    :country_name="'shipping_country'"
                    :countries="fn_get_countries()->toArray()"
                    :selectedCountry="$lead->country ?? null"
                    :selectedState="$lead->state ?? null"
                />
            </div>
            <div>
                <label for="shipping_zip" class="block text-sm font-medium text-gray-700">Zip Code</label>
                <input id="shipping_zip" type="text" name="shipping_zip"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>
        </div>
    </div>

    <div class="mt-6">
        <x-button type="submit"
            class="primary"
            label="Add Items"
            icon=""
            name="button" />
    </div>
</form>
