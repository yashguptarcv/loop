<!-- Order Numbering Section -->
<div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-800">
            Order Numbering
        </h2>
        <p class="mt-1 text-sm text-gray-500">Customize how order numbers are generated</p>
    </div>
    <div class="px-6 py-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700">Order Number Format</label>
                <p class="mt-1 text-sm text-gray-500">Define prefix, suffix, and length for order numbers</p>
            </div>
            <div class="md:col-span-2 space-y-4">
                <div>
                    <label for="order_number_prefix" class="block text-sm font-medium text-gray-700 mb-1">Prefix</label>
                    <input name="settings[general.order.prefix]" value="{{ old('general.order.prefix', fn_get_setting('general.order.prefix')) }}" type="text" id="order_number_prefix" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <p class="mt-1 text-xs text-gray-500">Text that appears at the beginning of order numbers</p>
                </div>
                <div>
                    <label for="order_number_suffix" class="block text-sm font-medium text-gray-700 mb-1">Suffix</label>
                    <input name="settings[general.order.suffix]" value="{{ old('general.order.suffix', fn_get_setting('general.order.suffix')) }}" type="text" id="order_number_suffix" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <p class="mt-1 text-xs text-gray-500">Text that appears at the end of order numbers</p>
                </div>
                <div>
                    <label for="order_number_length" class="block text-sm font-medium text-gray-700 mb-1">Number Length</label>
                    <input name="settings[general.order.length]" value="{{ old('general.order.length', fn_get_setting('general.order.length')) }}" type="number" id="order_number_length" min="4" max="12" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <p class="mt-1 text-xs text-gray-500">Length of the numeric part (e.g., 8 creates ORD00012345)</p>
                </div>
                <div class="flex items-center">
                    <input type="hidden" value="N" name="settings[general.order.auto_generate]">
                    <input name="settings[general.order.auto_generate]" value="Y" id="auto_generate" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" @if(old('general.order.auto_generate', fn_get_setting('general.order.auto_generate'))=='Y' ) checked @endif>
                    <label for="auto_generate" class="ml-2 block text-sm text-gray-700">Auto-generate order numbers</label>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Status Section -->
<div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-800">
            Order Status Settings
        </h2>
        <p class="mt-1 text-sm text-gray-500">Define statuses for different order stages</p>
    </div>
    <div class="px-6 py-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700">Status Configuration</label>
                <p class="mt-1 text-sm text-gray-500">Set status names for different order events</p>
            </div>
            <div class="md:col-span-2 space-y-4">
                <div>
                    <label for="order_created_status" class="block text-sm font-medium text-gray-700 mb-1">Order Created Status</label>

                    <select name="settings[general.order.create]" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        @foreach (fn_get_order_status() as $order)
                        <option value="{{ $order->name }}"
                            {{ old('general.order.create', fn_get_setting('general.order.create')) == $order->name ? 'selected' : '' }}>
                            {{ $order->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="order_processing_status" class="block text-sm font-medium text-gray-700 mb-1">Order Processing Status</label>
                    <select name="settings[general.order.processing]" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        @foreach (fn_get_order_status() as $order)
                        <option value="{{ $order->name }}"
                            {{ old('general.order.processing', fn_get_setting('general.order.processing')) == $order->name ? 'selected' : '' }}>
                            {{ $order->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="order_complete_status" class="block text-sm font-medium text-gray-700 mb-1">Order Complete Status</label>
                    <select name="settings[general.order.complete]" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        @foreach (fn_get_order_status() as $order)
                        <option value="{{ $order->name }}"
                            {{ old('general.order.complete', fn_get_setting('general.order.complete')) == $order->name ? 'selected' : '' }}>
                            {{ $order->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="order_cancelled_status" class="block text-sm font-medium text-gray-700 mb-1">Order Cancelled Status</label>
                    <select name="settings[general.order.cancelled]" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        @foreach (fn_get_order_status() as $order)
                        <option value="{{ $order->name }}"
                            {{ old('general.order.cancelled', fn_get_setting('general.order.cancelled')) == $order->name ? 'selected' : '' }}>
                            {{ $order->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="order_failed_status" class="block text-sm font-medium text-gray-700 mb-1">Order Failed Status</label>
                    <select name="settings[general.order.failed]" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        @foreach (fn_get_order_status() as $order)
                        <option value="{{ $order->name }}"
                            {{ old('general.order.failed', fn_get_setting('general.order.failed')) == $order->name ? 'selected' : '' }}>
                            {{ $order->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="order_refunded_status" class="block text-sm font-medium text-gray-700 mb-1">Order Refunded Status</label>
                    <select name="settings[general.order.refunded]" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        @foreach (fn_get_order_status() as $order)
                        <option value="{{ $order->name }}"
                            {{ old('general.order.refunded', fn_get_setting('general.order.refunded')) == $order->name ? 'selected' : '' }}>
                            {{ $order->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Checkout Settings Section -->
<div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-800">
            Checkout Settings
        </h2>
        <p class="mt-1 text-sm text-gray-500">Configure checkout behavior and preferences</p>
    </div>
    <div class="px-6 py-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700">Checkout Configuration</label>
                <p class="mt-1 text-sm text-gray-500">Set preferences for the checkout process</p>
            </div>
            <div class="md:col-span-2 space-y-4">
                <div>
                    <label for="order_expiry_days" class="block text-sm font-medium text-gray-700 mb-1">Application Order Expiry (Days)</label>
                    <input type="number" name="settings[general.checkout.order_expire]" value="{{ old('general.checkout.order_expire', fn_get_setting('general.checkout.order_expire')) }}" id="order_expiry_days" min="1" max="365" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <p class="mt-1 text-xs text-gray-500">Orders will be automatically cancelled after this period if not completed</p>
                </div>

                <div>
                    <label for="orders_per_page" class="block text-sm font-medium text-gray-700 mb-1">Orders Per Page</label>
                    <input type="number" name="settings[general.checkout.per_page]" value="{{ old('general.checkout.per_page', fn_get_setting('general.checkout.per_page')) }}" id="orders_per_page" min="5" max="100" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" value="20">
                </div>

                <div class="flex items-center">
                    <input type="hidden" name="settings[general.checkout.included]" value="N">
                    <input id="show_tax" name="settings[general.checkout.included]" value="Y" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                        @if(old('general.checkout.included', fn_get_setting('general.checkout.included'))=='Y' ) checked @endif>
                    <label for="show_tax" class="ml-2 block text-sm text-gray-700">Included Tax</label>
                </div>
                <div class="flex items-center">
                    <input type="hidden" name="settings[general.checkout.show_sku]" value="N">
                    <input id="show_sku" name="settings[general.checkout.show_sku]" value="Y" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                        @if(old('general.checkout.show_sku', fn_get_setting('general.checkout.show_sku'))=='Y' ) checked @endif>
                    <label for="show_sku" class="ml-2 block text-sm text-gray-700">Show product SKU in order details</label>
                </div>
            </div>
        </div>
    </div>
</div>