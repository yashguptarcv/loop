@if(bouncer()->hasPermission('admin.application.create'))
<form class="form-ajax max-w-4xl mx-auto" method="POST" action="{{ route('admin.application.store') }}">
    @csrf
    <!-- Customer Details Section -->
    <div class="mb-8">
        <h3 class="text-xl font-semibold text-gray-700 mb-4 pb-2 border-b divide-gray-100">Customer Details</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Full Name -->
            <div>
                <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                <input type="text" id="full_name" name="full_name" value="{{$lead->name}}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <input type="hidden" value="{{$lead->id}}" name="lead_id">
            </div>

            <!-- Mobile -->
            <div>
                <label for="mobile" class="block text-sm font-medium text-gray-700 mb-1">Mobile Number *</label>
                <input type="tel" id="mobile" name="mobile" value="{{$lead->phone}}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                <input type="email" id="email" name="email" value="{{$lead->email}}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Alternate Contact -->
            <div>
                <label for="alternate_contact" class="block text-sm font-medium text-gray-700 mb-1">Alternate Contact (Email or Mobile)</label>
                <input type="text" id="alternate_contact" name="alternate_contact"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
    </div>

    <!-- Organization Details Section -->
    <div class="mb-8">
        <h3 class="text-xl font-semibold text-gray-700 mb-4 pb-2 border-b divide-gray-100">Organization Details</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Organization -->
            <div>
                <label for="organization" class="block text-sm font-medium text-gray-700 mb-1">Organization</label>
                <input type="text" id="organization" name="organization"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Designation -->
            <div>
                <label for="designation" class="block text-sm font-medium text-gray-700 mb-1">Designation</label>
                <input type="text" id="designation" name="designation"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
    </div>

    <!-- Billing Address Section -->
    <div class="mb-8 hidden">
        <h3 class="text-xl font-semibold text-gray-700 mb-4 pb-2 border-b divide-gray-100">Billing Address</h3>

        <div class="grid grid-cols-1 gap-6">
            <!-- Address Line 1 -->
            <div>
                <label for="address_line1" class="block text-sm font-medium text-gray-700 mb-1">Address Line 1 </label>
                <input type="text" id="address_line1" name="billing_address[address_line1]" x-value="{{$lead->address ?? ''}}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Address Line 2 -->
            <div>
                <label for="address_line2" class="block text-sm font-medium text-gray-700 mb-1">Address Line 2</label>
                <input type="text" id="address_line2" name="billing_address[address_line2]" x-value="{{$lead->address_2 ?? ''}}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- City -->
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City </label>
                    <input type="text" id="city" name="billing_address[city]" x-value="{{$lead->city ?? ''}}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <x-country-state
                    :countries="fn_get_countries()->toArray()"
                    :selectedCountry="$lead->country ?? null"
                    :selectedState="$lead->state ?? null"
                    :country_name="'billing_address[country]'"
                    :state_name="'billing_address[state]'" />

                <!-- Postal Code -->
            </div>
            <div>
                <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">Postal Code </label>
                <input type="text" id="postal_code" name="billing_address[postal_code]" x-value="{{$lead->postal_code ?? ''}}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

        </div>
    </div>

    <!-- Award Categories Section -->
    <div class="mb-8 hidden">
        <h3 class="text-xl font-semibold text-gray-700 mb-4 pb-2 border-b divide-gray-100">Award Categories</h3>

        <div class="space-y-4">
            @foreach($awardCategories as $awardCategory)
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input id="award_category_{{ $awardCategory->id }}" name="award_categories[]"
                        type="checkbox" value="{{ $awardCategory->id }}"
                        class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                </div>
                <div class="ml-3 text-sm">
                    <label for="award_category_{{ $awardCategory->id }}" class="font-medium text-gray-700">
                        {{ $awardCategory->name }} ({{ $awardCategory->country->name }})
                    </label>
                    <p class="text-gray-500">
                        Main: {{ $awardCategory->mainCategory->name }} |
                        Sub: {{ $awardCategory->subCategory->name }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @if(!empty($application))
    <div class="mb-8">
        <h3 class="text-xl font-semibold text-gray-700 mb-4 pb-2 border-b divide-gray-100">Application Fees</h3>
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Application</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sale Price</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-100">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$application->name}}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$application->price}}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$application->sale_price}}</td>
                </tr>

            </tbody>
        </table>
    </div>
    @endif

    <!-- Form Submission -->
    <div class="flex justify-end">
        <x-button type="submit" class="primary" label="Send" icon='' name='button' />
    </div>
</form>
@else
<div class="max-w-4xl mx-auto">{{'You don\'t have access!'}}</div>
@endif