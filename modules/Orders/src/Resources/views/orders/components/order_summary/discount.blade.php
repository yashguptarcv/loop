@if(!empty($order))
<!-- Add Discount Section -->
<div class="mt-6 pt-4 border-t border-gray-100">
    <div class="flex justify-between items-center mb-2">
        <h3 class="text-sm font-medium text-gray-700">DISCOUNTS</h3>

        <x-modal
            buttonText='<i class="fas fa-plus"></i> Add Discount'
            type='link'
            modalTitle="Add Discount"
            id="add_cart_discount"
            ajaxUrl="{{route('api.cart.discount.view', $order->id)}}"
            buttonClass="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1"
            modalSize="2xl" />
    </div>
    <div id="discount">
        @if(!empty($order_summary) && $order_summary['discount'] > 0)
        <div class="bg-blue-50 p-3 mb-2 rounded-lg flex justify-between items-center">
            <div>
                <p class="text-sm font-medium text-blue-800">DISCOUNT</p>
                <p class="text-xs text-blue-600">Applied Coupon Code: ({{$order->coupon_code}})</p>
            </div>
            <a href="javascript:;" id="remove_discount" class="text-red-400 hover:text-red-600">
                <i class="fas fa-times"></i>
            </a>
        </div>
        @endif
    </div>
</div>
@endif