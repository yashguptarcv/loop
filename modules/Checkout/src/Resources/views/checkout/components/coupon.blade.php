<div class="mt-6 bg-blue-50 p-4 rounded-lg border border-blue-100">
    @if(!empty($order['order_summary']) && $order['order_summary']['discount'] > 0)

        <div class="rounded-lg flex justify-between items-center">
            <div>
                <p class="text-sm font-medium text-dark">DISCOUNT</p>
                <p class="text-xs text-dark">Applied Coupon Code: ({{$order['coupon_code']}})</p>
            </div>
            <a href="javascript:;" id="remove-coupon-btn" class="text-dark hover:text-dark">
                <i class="fas fa-times"></i>
            </a>
        </div>
    @else

    <div class="flex items-start">
        <i class="fas fa-tag text-primary mt-1 mr-3"></i>
        <div>
            <h4 class="text-sm font-medium text-gray-800">Promo Code</h4>
            <p class="text-xs text-gray-500">Apply your promo code for discounts</p>
            <div class="flex mt-2">
                <input type="text" id="coupon-code" class="flex-1 px-3 py-2 border border-gray-200 rounded-l-lg focus:outline-none focus:ring-1 focus:ring-primary text-sm" placeholder="Enter code">
                <button id="apply-coupon-btn" type="button" class="bg-black text-white px-4 py-2 rounded-r-lg text-sm hover:bg-secondary transition duration-200">Apply</button>
            </div>
            <div id="coupon-error"></div>
        </div>
    </div>
    @endif
</div>