<form id="userForm" class="form-ajax" method="POST" action="{{route('api.cart.item.add', $order_id)}}">
    @csrf

    @if(isset($order))
    @method('PUT')
    @endif
    <input type="hidden" name="order_id" value="{{$order_id}}">
    <x-autocomplete
        label="Search products"
        field="items"
        table="products"
        value-field="id"
        search-fields="name"
        list-attributes="id,name"
        :multiple="true"
        :selected="[]" />
    <div class="mt-6">
        <x-button type="submit"
            class="primary"
            label="Add Items"
            icon=''
            name="button" />
    </div>
</form>