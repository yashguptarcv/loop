<form id="userForm" class="form-ajax" method="POST" action="{{route('api.cart.discount.add', $order['order_id'])}}">
    @csrf

    @if(isset($order))
        @method('PUT')
    @endif
    <input type="hidden" name="order_id" value="{{$order['order_id']}}">
    <div id="auto-complete">        
        <input
            type="text"
            autocomplete="dropdown"
            multiselect=true
            name="coupon_name"
            value="{{$order['coupon_code'] ?? ''}}"
            placeholder="Search Coupon Code"
            id="input-coupon_code"
            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            data-table="coupons"
            data-select_columns="code as id, code as name"
            data-search_column="code"
            data-target="coupon_code"
            data-original-value="" />
        <input
            type="hidden"
            name="coupon_code"
            id="coupon_code"
            value="{{$order['coupon_code'] ?? ''}}"
            class="mt-1"    
            data-original-value="" />
    </div>
    <div class="mt-6">
        <x-button type="submit"                     
            class="primary" 
            label="Apply Coupon" 
            icon=''
            name="button" 
        />
    </div>
</form>