<form id="userForm" class="form-ajax" method="POST" action="{{route('api.cart.customer.add', $order['order_id'] ?? 0)}}">
    @csrf

    <input type="hidden" name="order_id" value="{{$order['order_id'] ?? 0}}">
    <div id="auto-complete">        
        <input
            type="text"
            autocomplete="dropdown"
            multiselect=true
            name="customer_id"
            value="{{$order['customer_details']['name'] ?? ''}}"
            placeholder="Search Customer"
            id="input-customer_id"
            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            data-table="users"
            data-select_columns="id, name"
            data-search_column="name, email"
            data-target="customer_id"
            data-original-value="" />
        <input
            type="hidden"
            name="customer_id"
            id="customer_id"
            value="{{$order['customer_details']['id'] ?? 0}}"
            class="mt-1"    
            data-original-value="" />
    </div>
    <div class="mt-6">
        <x-button type="submit"                     
            class="primary" 
            label="Save" 
            icon=''
            name="button" 
        />
    </div>
</form>