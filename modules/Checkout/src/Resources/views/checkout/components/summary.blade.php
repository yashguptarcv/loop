<div class="border-t border-gray-200 pt-4 space-y-3">
    <div class="flex justify-between py-2">
        <span class="text-gray-600">Subtotal</span>
        <span class="text-gray-800 font-medium">{{ !empty($order['order_summary']['subtotal']) ? fn_convert_currency($order['order_summary']['subtotal'] ?? 0, $order['currency']) : 0 }}</span>
    </div>
    @if(!empty($order['order_summary']) && $order['order_summary']['discount'] > 0)
    <div class="flex justify-between py-2">
        <span class="text-gray-600">Discount</span>
        <span class="text-red-600 font-medium">-{{ fn_convert_currency($order['order_summary']['discount'] ?? 0, $order['currency']) }}</span>
    </div>
    @endif
    <div class="flex justify-between py-2 hidden">
        <span class="text-gray-600">Shipping</span>
        <div class="flex items-center gap-2">
            <input type="text" value="{{ !empty($order['order_summary']['shipping']) ? fn_convert_currency($order['order_summary']['shipping'] ?? 0, $order['currency']) : 0 }}" class="w-20 p-1 border border-gray-300 rounded-md text-sm text-right">
        </div>
    </div>
    @if(!empty($order['order_summary']['tax']))
    <div class="flex justify-between items-start py-2">
        <span class="text-gray-600">Tax</span>

        <div class="flex flex-col items-end">
            @if(!empty($order['order_summary']['taxes']))
            <div class="mb-2 space-y-1 text-right">
                @foreach($order['order_summary']['taxes'] as $tax)
                <div class="text-sm text-gray-500 flex justify-between w-full">
                    <span class="mr-3">{{ $tax['name'] }} ({{ number_format($tax['rate'],2) }}%)</span>
                    <span>{{ fn_convert_currency($tax['amount'], $order['currency']) }}</span>
                </div>
                @endforeach
            </div>
            @endif

            <div class="flex items-center gap-2">
                <span class="w-20 p-1 rounded-md text-sm text-right">{{ !empty($order['order_summary']['tax']) ? fn_convert_currency($order['order_summary']['tax'] ?? 0, $order['currency']) : 0 }}</span>
            </div>
        </div>
    </div>
    @endif
    <div class="flex justify-between py-3 mt-2 border-t border-gray-100">
        <span class="text-gray-800 font-semibold">Total</span>
        <span class="text-gray-800 font-bold text-lg">{{ !empty($order['order_summary']['total']) ? fn_convert_currency($order['order_summary']['total'] ?? 0, $order['currency']) : 0 }}</span>
    </div>

</div>