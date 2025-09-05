<div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
        <i class="fas fa-receipt text-primary mr-2"></i> Order Summary
    </h2>

    <div class="space-y-4 mb-6">
        @foreach($order['order_items'] as $item)
        <div class="flex justify-between items-center bg-white p-4 rounded-xl product-shadow">
            <div class="flex items-center">
                <div class="h-12 w-12 bg-gradient-to-br from-blue-100 to-purple-100 rounded-lg overflow-hidden flex items-center justify-center">
                    <img src="{{fn_get_image('product', $item['product_id'])['url']}}" attr="{{$item['product_name']}}" class="w-10 h-10">
                </div>
                <div class="ml-4">
                    <h4 class="text-sm font-medium text-gray-800">{{$item['product_name']}}</h4>

                    <p class="text-xs text-gray-500">Qty: {{$item['quantity']}} x {{fn_convert_currency($item['price'], $order['currency'])}}</p>
                </div>
            </div>
            <div class="text-right">
                <span class="text-sm font-medium text-gray-800 block">{{fn_convert_currency($item['line_total'], $order['currency'])}}</span>

            </div>
        </div>
        @endforeach

    </div>
    
    @include('checkout::checkout.components.summary')

    @include('checkout::checkout.components.coupon')
    
    @include('checkout::checkout.components.payments')
</div>