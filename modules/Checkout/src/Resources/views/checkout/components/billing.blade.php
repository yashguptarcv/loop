<div>
    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
        <i class="fas fa-user-circle text-primary mr-2"></i> Billing Information
    </h2>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center" for="email">
            <i class="fas fa-envelope text-gray-400 mr-2 text-xs"></i> Email address
        </label>
        <div class="relative">
            <input type="email" value="{{$order['billing_address']['email'] ?? ''}}" id="email" class="w-full px-4 py-3 pl-10 border border-gray-200 rounded-lg input-focus focus:ring-2 focus:ring-primary focus:border-transparent transition duration-200" placeholder="your@email.com">
            <i class="fas fa-envelope absolute left-3 top-3.5 text-gray-400"></i>
        </div>
    </div>

    <div class="mt-2">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2" for="first-name">Full Name</label>
            <input type="text" value="{{$order['billing_address']['name'] ?? ''}}" id="first-name" class="w-full px-4 py-3 border border-gray-200 rounded-lg input-focus focus:ring-2 focus:ring-primary focus:border-transparent transition duration-200" placeholder="John">
        </div>
    </div>

    <div class="mt-2">
        <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center" for="address">
            <i class="fas fa-home text-gray-400 mr-2 text-xs"></i> Billing Address
        </label>
        <input type="text" value="{{$order['billing_address']['address_1'] ?? ''}}" id="address" class="w-full px-4 py-3 border border-gray-200 rounded-lg input-focus focus:ring-2 focus:ring-primary focus:border-transparent transition duration-200" placeholder="123 Main St">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2" for="city">City</label>
            <input type="text" value="{{$order['billing_address']['city'] ?? ''}}" id="city" class="w-full px-4 py-3 border border-gray-200 rounded-lg input-focus focus:ring-2 focus:ring-primary focus:border-transparent transition duration-200" placeholder="New York">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2" for="zip">ZIP Code</label>
            <input type="text" value="{{$order['billing_address']['postcode'] ?? ''}}" id="zip" class="w-full px-4 py-3 border border-gray-200 rounded-lg input-focus focus:ring-2 focus:ring-primary focus:border-transparent transition duration-200" placeholder="10001">
        </div>
    </div>

    <div class="mt-2">
        <x-country-state
            input_id_prefix="billing"
            :state_name="'state'"
            :country_name="'country'"
            :countries="fn_get_countries()->toArray()"
            :selectedCountry="$order['billing_address']['country'] ?? null"
            :selectedState="$order['billing_address']['state'] ?? null" />
    </div>

    <div class="mt-2">
        <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center" for="phone">
            <i class="fas fa-phone text-gray-400 mr-2 text-xs"></i> Phone Number (optional)
        </label>
        <input type="tel" value="{{$order['billing_address']['phone'] ?? ''}}" id="phone" class="w-full px-4 py-3 border border-gray-200 rounded-lg input-focus focus:ring-2 focus:ring-primary focus:border-transparent transition duration-200" placeholder="+1 (555) 000-0000">
    </div>

    <button id="update-billing-btn" class="mt-4 px-5 py-2.5 text-sm font-medium text-white gradient-bg rounded-lg hover:opacity-90 transition duration-200 flex items-center shadow-md hover:shadow-lg">
        Update Billing Address
    </button>

</div>