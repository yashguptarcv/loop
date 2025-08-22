<div class="bg-white rounded-lg shadow p-6 space-y-4">
    <div class="flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-900">Discount Rules</h3>
        <button type="button" id="add-rule-btn" class="text-sm bg-blue-100 text-blue-600 px-3 py-2 rounded-md hover:bg-blue-200">
            Add Rule
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rule Type</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Target</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Condition</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody id="rules-container" class="bg-white divide-y divide-gray-200">
                <!-- Rule template (hidden by default) -->
                <tr id="rules-template" class="hidden">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <select name="rules[0][rule_type]" class="input-field rule-type-select">
                            <option value="product">Product</option>
                            <option value="category">Category</option>
                            <option value="subtotal">Cart Subtotal</option>
                            <option value="quantity">Cart Quantity</option>
                        </select>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <select name="rules[0][rule_id]" class="input-field rule-target-select w-full" style="width: 100%">
                            <option value="">Select Target...</option>
                        </select>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <select name="rules[0][condition_type]" class="input-field condition-type-select">
                            <option value="greater_than">Greater Than</option>
                            <option value="less_than">Less Than</option>
                            <option value="equals">Equals</option>
                            <option value="not_equals">Not Equals</option>
                        </select>
                        <input type="text" name="rules[0][rule_value]" class="input-field mt-2" placeholder="Value (e.g., 100)">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <button type="button" class="text-red-600 hover:text-red-800 remove-rule">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </td>
                </tr>

                <!-- Existing rules (for edit mode) -->
                @if(isset($discount) && $discount->rules->count())
                @foreach($discount->rules as $index => $rule)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <select name="rules[{{ $index }}][rule_type]" class="input-field rule-type-select">
                            <option value="product" @selected($rule->rule_type == 'product')>Product</option>
                        </select>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <select name="rules[{{ $index }}][rule_id]" class="input-field rule-target-select">
                            <option value="{{ $rule->rule_id }}" selected> {{ fn_target_name($rule) }}</option>
                        </select>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <select name="rules[{{ $index }}][condition_type]" class="input-field condition-type-select">
                            <option value="greater_than" @selected(str_contains($rule->rule_value, 'greater_than'))>Greater Than</option>
                            <option value="less_than" @selected(str_contains($rule->rule_value, 'less_than'))>Less Than</option>
                            <option value="equals" @selected(str_contains($rule->rule_value, 'equals'))>Equals</option>
                            <option value="not_equals" @selected(str_contains($rule->rule_value, 'not_equals'))>Not Equals</option>
                        </select>
                        @php
                        $value = '';
                        if (str_contains($rule->rule_value, ':')) {
                        $value = explode(':', $rule->rule_value)[1];
                        }
                        @endphp
                        <input type="text" name="rules[{{ $index }}][rule_value]" value="{{ $value }}" class="input-field mt-2" placeholder="Value (e.g., 100)">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <button type="button" class="text-red-600 hover:text-red-800 remove-rule">
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