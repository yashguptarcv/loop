@extends('admin::layouts.app')

@section('title', isset($product) ? 'Edit Order' : 'Create Order')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
    @include('admin::components.common.back-button', ['route' => route('admin.orders.index'), 'name' => isset($order) ? 'Order #'.$order->order_number : 'New order'])

    @if(!empty($order))
    <div class="flex items-center">
        <span class="ml-3 text-sm text-gray-500">
            Placed on {{ $order->created_at->format('M d, Y') }}
        </span>
        <span class="ml-3 text-sm text-gray-500">
            Payment:
            <span class="{{ $order->payment_status == 'paid' ? 'text-green-600' : 'text-red-600' }}">
                {{ ucfirst($order->payment_status) }}
            </span>
        </span>
    </div>
    @endif
</div>

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
    <div class="flex items-center gap-2">
        <button class="px-4 py-2 rounded-lg bg-primary-100 text-amber-100 hover:text-amber-200 transition flex items-center gap-2">
            Save
        </button>
        @if(!empty($order))
        <button class="px-4 py-2 rounded-lg border border-primary-100 bg-white text-primary-100 hover:border-primary-200 transition flex items-center gap-2">
            <i class="fas fa-print"></i> Print
        </button>

        <button class="px-4 py-2 rounded-lg bg-primary-100 text-amber-100 hover:text-amber-200 transition flex items-center gap-2">
            <i class="fas fa-cog"></i> Generate Invoice
        </button>
        @endif

    </div>
    @if(!empty($order))
    <button class="px-4 py-2 rounded-lg bg-red-100 text-red-600 hover:text-red-300 transition flex items-center gap-2">
        <i class="fas fa-trash-alt"></i> Cancel Order
    </button>
    @endif
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6" id="order_datas">
    @include('orders::orders.components.order_detail')
</div>

@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function loadOrder() {
            ceAjax('get', '{{ route("admin.orders.show", $order->id ?? 0) }}', {
                loader: true,
                data: {
                    tab: true,
                    order_id: '{{$order->id ?? 0}}'
                },
                result_ids: 'order_datas', // This will update the calendar container directly
                caching: false,
                callback: function(data) {},
                errorCallback: function(xhr) {
                    showToast('Unable to load order data', 'error', 'Error');
                }
            });
        }

        // Quantity increase button
        document.querySelectorAll('.quantity-increase').forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-item-id');
                const input = document.querySelector(`.quantity-input[data-item-id="${itemId}"]`);
                const currentValue = parseInt(input.value) || 0;
                input.value = currentValue + 1;
                updateOrderItem(itemId, input.value);
            });
        });

        // Quantity decrease button
        document.querySelectorAll('.quantity-decrease').forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-item-id');
                const input = document.querySelector(`.quantity-input[data-item-id="${itemId}"]`);
                const currentValue = parseInt(input.value) || 0;
                if (currentValue > 1) {
                    input.value = currentValue - 1;
                    updateOrderItem(itemId, input.value);
                }
            });
        });

        // Input field change
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                const itemId = this.getAttribute('data-item-id');
                const quantity = parseInt(this.value) || 1;
                if (quantity < 1) {
                    this.value = 1;
                }
                updateOrderItem(itemId, this.value);
            });

            input.addEventListener('blur', function() {
                const quantity = parseInt(this.value) || 1;
                if (quantity < 1) {
                    this.value = 1;
                    updateOrderItem(this.getAttribute('data-item-id'), 1);
                }
            });
        });

        document.querySelectorAll('#remove_discount').forEach(button => {
            button.addEventListener('click', function() {
                removeCoupon();
            });
        });


        // Remove item functionality
        document.querySelectorAll('.remove-item').forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-item-id');
                const productId = this.getAttribute('data-product-id');
                const productName = this.closest('tr').querySelector('.text-blue-600').textContent;

                // Confirm deletion
                if (confirm(`Are you sure you want to remove "${productName}" from this order?`)) {
                    removeOrderItem(itemId, productId);
                }
            });
        });

        // Remove order item using ceAjax
        function removeOrderItem(itemId, productId) {
            ceAjax('POST', '{{ route("api.cart.item.remove") }}', {
                loader: true,
                data: {
                    item_id: itemId,
                    product_id: productId,
                    order_id: '{{ $order->id ?? 0 }}'
                },
                callback: function(response) {
                    if (response.success) {
                        showToast('Item removed successfully', 'success');
                        window.location = response.redirect_url;
                    } else {
                        showToast(response.message || 'Error removing item', 'error');
                    }
                },
                errorCallback: function(xhr) {
                    showToast('Error removing item', 'error');
                }
            });
        }

        // Update order item using ceAjax
        function updateOrderItem(itemId, quantity) {
            // Store original quantity for potential rollback
            const input = document.querySelector(`.quantity-input[data-item-id="${itemId}"]`);
            const originalQuantity = input.getAttribute('data-original-quantity');

            ceAjax('POST', '{{ route("api.cart.item.quantity") }}', {
                loader: true,
                data: {
                    item_id: itemId,
                    quantity: quantity,
                    order_id: '{{ $order->id ?? 0 }}'
                },
                callback: function(response) {
                    if (response.success) {

                        // loadOrder();
                        location.reload();
                        showToast('Quantity updated successfully', 'success');
                    } else {
                        // Revert to original value on error
                        input.value = originalQuantity;
                    }
                },
                errorCallback: function(xhr) {
                    // Revert to original value on error
                    input.value = originalQuantity;
                    showToast('Error updating quantity', 'error');
                }
            });
        }

        // Update order item using ceAjax
        function removeCoupon() {
            ceAjax('PUT', '{{ route("api.cart.discount.remove") }}', {
                loader: true,
                data: {
                    order_id: '{{ $order->id ?? 0 }}'
                },
                callback: function(response) {
                    if (response.success) {

                        // loadOrder();
                        location.reload();
                        showToast('Coupon removed successfully', 'success');
                    } else {
                        // Revert to original value on error
                        input.value = originalQuantity;
                    }
                },
                errorCallback: function(xhr) {
                    // Revert to original value on error
                    input.value = originalQuantity;
                    showToast('Error updating quantity', 'error');
                }
            });
        }
    });
</script>

@endsection