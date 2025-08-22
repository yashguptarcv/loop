<div class="bg-white rounded-lg shadow p-6 space-y-4">
    <div class="flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-900">Coupons</h3>
        <button type="button" id="add-coupon-btn" class="text-sm bg-blue-100 text-blue-600 px-3 py-2 rounded-md hover:bg-blue-200">
            Add Coupon
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usage Limit</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Min Order</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody id="coupons-container" class="bg-white divide-y divide-gray-200">
                <!-- Coupon template (hidden by default) -->
                <tr id="coupons-template" class="hidden">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="text" name="coupons[0][code]" class="input-field" placeholder="e.g., SUMMER20" required>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="number" name="coupons[0][usage_limit]" class="input-field" placeholder="Unlimited if empty">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="number" step="0.01" name="coupons[0][min_order_amount]" class="input-field" placeholder="No minimum">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <select name="coupons[0][is_active]" class="input-field">
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <button type="button" class="text-red-600 hover:text-red-800 remove-coupon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </td>
                </tr>

                <!-- Existing coupons (for edit mode) -->
                @if(isset($discount) && $discount->coupons->count())
                @foreach($discount->coupons as $index => $coupon)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="hidden" name="coupons[{{ $index }}][id]" value="{{ $coupon->id }}">
                        <input type="text" name="coupons[{{ $index }}][code]" value="{{ $coupon->code }}" class="input-field" placeholder="e.g., SUMMER20" required>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="number" name="coupons[{{ $index }}][usage_limit]" value="{{ $coupon->usage_limit }}" class="input-field" placeholder="Unlimited if empty">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="number" step="0.01" name="coupons[{{ $index }}][min_order_amount]" value="{{ $coupon->min_order_amount }}" class="input-field" placeholder="No minimum">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <select name="coupons[{{ $index }}][is_active]" class="input-field">
                            <option value="1" @selected($coupon->is_active)>Active</option>
                            <option value="0" @selected(!$coupon->is_active)>Inactive</option>
                        </select>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <button type="button" class="text-red-600 hover:text-red-800 remove-coupon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>