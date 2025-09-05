<!-- Stripe API Key -->
<div class="mt-3">
    <label class="custom-label" for="stripe_api_key">Stripe API Key</label>
    <input type="text" name="payment_data[stripe_api_key]" id="stripe_api_key"
        value="{{ old('stripe_api_key', $payment_data['stripe_api_key'] ?? '') }}"
        class="input-field">
</div>

<!-- Stripe API Key -->
<div class="mt-3">
    <label class="custom-label" for="stripe_secret_key">Stripe Secret Key</label>
    <input type="text" name="payment_data[stripe_secret_key]" id="stripe_secret_key"
        value="{{ $payment_data['stripe_secret_key'] ?? '' }}"
        class="input-field">
</div>

<div class="mt-3">
    <label for="order_created_status" class="block text-sm font-medium text-gray-700 mb-1">Order complete status</label>

    <select name="payment_data[stripe_order_complete]" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
        @foreach (fn_get_order_statuses() as $order)
        <option value="{{ $order->status_code }}"
            {{ (!empty($payment_data['stripe_order_complete']) && $payment_data['stripe_order_complete'] == $order->status_code) ? 'selected' : '' }}>
            {{ $order->name }}
        </option>
        @endforeach
    </select>
</div>

<div class="mt-3">
    <label for="order_created_status" class="block text-sm font-medium text-gray-700 mb-1">Order failed status</label>

    <select name="payment_data[stripe_order_failed]" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
        @foreach (fn_get_order_statuses() as $order)
        <option value="{{ $order->status_code }}"
            {{ (!empty($payment_data['stripe_order_failed']) && $payment_data['stripe_order_failed'] == $order->status_code) ? 'selected' : '' }}>
            {{ $order->name }}
        </option>
        @endforeach
    </select>
</div>

<div class="mt-3">
    <label for="order_created_status" class="block text-sm font-medium text-gray-700 mb-1">Order cancelled status</label>

    <select name="payment_data[stripe_order_cancelled]" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
        @foreach (fn_get_order_statuses() as $order)
        <option value="{{ $order->status_code }}"
            {{ (!empty($payment_data['stripe_order_cancelled']) && $payment_data['stripe_order_cancelled'] == $order->status_code) ? 'selected' : '' }}>
            {{ $order->name }}
        </option>
        @endforeach
    </select>
</div>

<!-- Stripe Test Mode -->
<div class="mt-3">
    <label class="inline-flex items-center">
        <inp type="hidden" name="payment_data[stripe_test_mode]" value="N">
            <input type="checkbox" name="payment_data[stripe_test_mode]" value="Y"
                {{ (!empty($payment_data['stripe_test_mode']) && $payment_data['stripe_test_mode'] == 'Y') ? 'checked' : '' }}
                class="form-checkbox">
            <span class="ml-2">Mode</span>
    </label>
</div>