@extends('admin::layouts.app')

@section('title')
    @if($mode === 'create')
        Create Order
    @elseif($mode === 'edit')
        Edit Order #{{ $order_number ?? '' }}
    @else
        Order Detail #{{ $order_number ?? '' }}
    @endif
@endsection

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
    @php
        $redirect_route = route('admin.orders.index');
    if($mode === 'create') {
        $redirect_route = route('admin.orders.index');
    } elseif($mode === 'edit') {
        $redirect_route = route('admin.orders.show', $order_id ?? 0);
    }
    @endphp
        @include('admin::components.common.back-button', [
            'route' => $redirect_route,
            'name' => $mode === 'create' ? 'New Order' : 'Order #'. $order_number ?? 0
        ])

    @if($mode !== 'create' && !empty($order))
    <div class="flex items-center">
        <span class="ml-3 text-sm text-gray-500">
            Placed on {{ $created_at->format('M d, Y') }}
        </span>
        <span class="ml-3 text-sm text-gray-500">
            Payment:
            <span class="{{ $payment_status == 'paid' ? 'text-green-600' : 'text-red-600' }}">
                {{ ucfirst($payment_status) }}
            </span>
        </span>
    </div>
    @endif
</div>

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
    <div class="flex items-center gap-2">
        @if($mode === 'create')
        <button type="submit" form="order_form"
            class="px-4 py-2 rounded-lg bg-primary-100 text-amber-100 hover:text-amber-200 transition flex items-center gap-2">
            Save
        </button>
        @elseif($mode === 'edit')
        <button type="submit" form="order_form"
            class="px-4 py-2 rounded-lg bg-primary-100 text-amber-100 hover:text-amber-200 transition flex items-center gap-2">
            Update
        </button>
        @else {{-- view mode --}}
        <a href="{{ route('admin.orders.edit', $order_id) }}"
            class="px-4 py-2 rounded-lg bg-primary-100 text-amber-100 hover:text-amber-200 transition flex items-center gap-2">
            Edit Order
        </a>
        <button class="px-4 py-2 rounded-lg border border-primary-100 bg-white text-primary-100 hover:border-primary-200 transition flex items-center gap-2">
            <i class="fas fa-print"></i> Print
        </button>
        <button class="px-4 py-2 rounded-lg bg-primary-100 text-amber-100 hover:text-amber-200 transition flex items-center gap-2">
            <i class="fas fa-cog"></i> Generate Invoice
        </button>
        @endif
    </div>

    @if($mode !== 'create' && !empty($order))
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
    @if($mode === 'create' || $mode === 'edit')
    document.addEventListener('DOMContentLoaded', function() {

        function getOrderContainer() {
            return document.getElementById('order_datas');
        }

        // ------------------------------
        // Mutations for order operations
        // ------------------------------
        const mutations = {
            updateItemQuantity(itemId, quantity) {
                const input = document.querySelector(`.quantity-input[data-item-id="${itemId}"]`);
                const originalQuantity = input?.getAttribute('data-original-quantity') || 1;

                if (typeof ceAjax !== 'function') return console.error('ceAjax is not defined');

                ceAjax('POST', '{{ route("api.cart.item.quantity") }}', {
                    loader: true,
                    data: {
                        item_id: itemId,
                        quantity,
                        order_id: '{{ $order_id ?? 0 }}'
                    },
                    callback: function(response) {
                        if (response.success) {
                            loadOrder();
                            showToast('Quantity updated successfully', 'success');
                        } else {
                            if (input) input.value = originalQuantity;
                            showToast(response.message || 'Error updating quantity', 'error');
                        }
                    },
                    errorCallback: function() {
                        if (input) input.value = originalQuantity;
                        showToast('Error updating quantity', 'error');
                    }
                });
            },

            removeItem(itemId, productId, productName) {
                if (!confirm(`Are you sure you want to remove "${productName}" from this order?`)) return;

                if (typeof ceAjax !== 'function') return console.error('ceAjax is not defined');

                ceAjax('POST', '{{ route("api.cart.item.remove") }}', {
                    loader: true,
                    data: {
                        item_id: itemId,
                        product_id: productId,
                        order_id: '{{ $order_id ?? 0 }}'
                    },
                    callback: function(response) {
                        if (response.success) {
                            showToast('Item removed successfully', 'success');
                            loadOrder();
                        } else {
                            showToast(response.message || 'Error removing item', 'error');
                        }
                    },
                    errorCallback: function() {
                        showToast('Error removing item', 'error');
                    }
                });
            },

            removeCoupon() {
                if (typeof ceAjax !== 'function') return console.error('ceAjax is not defined');

                ceAjax('PUT', '{{ route("api.cart.discount.remove") }}', {
                    loader: true,
                    data: {
                        order_id: '{{ $order_id ?? 0 }}'
                    },
                    callback: function(response) {
                        if (response.success) {
                            showToast('Coupon removed successfully', 'success');
                            loadOrder();
                        } else {
                            showToast(response.message || 'Error removing coupon', 'error');
                        }
                    },
                    errorCallback: function() {
                        showToast('Error removing coupon', 'error');
                    }
                });
            }
        };

        // ------------------------------
        // Load order
        // ------------------------------
        window.loadOrder = function() {
            const container = getOrderContainer();
            if (!container) return;

            if (typeof ceAjax !== 'function') return console.error('ceAjax is not defined');

            ceAjax('get', '{{ route("admin.orders.$mode", $order_id ?? 0) }}', {
                loader: true,
                data: {
                    tab: true,
                    order_id: '{{ $order_id ?? 0 }}'
                },
                result_ids: 'order_datas',
                caching: false,
                callback: function() {},
                errorCallback: function() {
                    showToast('Unable to load order data', 'error', 'Error');
                }
            });
        }

        // ------------------------------
        // Attach events dynamically
        // ------------------------------
        function attachEvents(container) {
            if (!container) return;

            // Quantity increase/decrease
            container.querySelectorAll('.quantity-increase, .quantity-decrease').forEach(button => {
                if (button.dataset.bound) return;
                button.dataset.bound = true;

                button.addEventListener('click', () => {
                    const itemId = button.dataset.itemId;
                    const input = container.querySelector(`.quantity-input[data-item-id="${itemId}"]`);
                    let currentValue = parseInt(input.value) || 1;

                    if (button.classList.contains('quantity-increase')) currentValue++;
                    if (button.classList.contains('quantity-decrease') && currentValue > 1) currentValue--;

                    input.value = currentValue;
                    mutations.updateItemQuantity(itemId, currentValue);
                });
            });

            // Quantity input
            container.querySelectorAll('.quantity-input').forEach(input => {
                if (input.dataset.bound) return;
                input.dataset.bound = true;

                input.addEventListener('change', () => {
                    let quantity = parseInt(input.value) || 1;
                    if (quantity < 1) quantity = 1;
                    input.value = quantity;
                    mutations.updateItemQuantity(input.dataset.itemId, quantity);
                });

                input.addEventListener('blur', () => {
                    let quantity = parseInt(input.value) || 1;
                    if (quantity < 1) quantity = 1;
                    input.value = quantity;
                    mutations.updateItemQuantity(input.dataset.itemId, quantity);
                });
            });

            // Remove item
            container.querySelectorAll('.remove-item').forEach(button => {
                if (button.dataset.bound) return;
                button.dataset.bound = true;

                button.addEventListener('click', () => {
                    const itemId = button.dataset.itemId;
                    const productId = button.dataset.productId;
                    const productName = button.closest('tr')?.querySelector('.text-blue-600')?.textContent || '';
                    mutations.removeItem(itemId, productId, productName);
                });
            });

            // Remove discount
            container.querySelectorAll('#remove_discount').forEach(button => {
                if (button.dataset.bound) return;
                button.dataset.bound = true;
                button.addEventListener('click', mutations.removeCoupon);
            });
        }

        // ------------------------------
        // MutationObserver to watch DOM changes
        // ------------------------------
        const observer = new MutationObserver(() => {
            const container = getOrderContainer();
            attachEvents(container);
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });

        attachEvents(getOrderContainer());
    });

    @endif
</script>

@endsection