@extends('admin::layouts.app')

@section('title', isset($product) ? 'Edit Order' : 'Create Order')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
    @include('admin::components.common.back-button', ['route' => route('admin.orders.index'), 'name' => isset($order) ? 'Order #'.$order->order_number : 'New order'])

    <div class="flex items-center">
        <span class="px-3 py-1 text-xs font-medium rounded-full 
            {{ $order->status == 'O' ? 'bg-blue-100 text-blue-800' : 
                ($order->status == 'C' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
            {{ $order->status == 'O' ? 'Open' : 
                ($order->status == 'C' ? 'Completed' : $order->status) }}
        </span>
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
</div>

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
    <div class="flex items-center gap-2">
        <button class="px-4 py-2 rounded-lg bg-blue-100 text-blue-600 hover:text-blue-300 transition flex items-center gap-2">
            Save
        </button>
        <button class="px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition flex items-center gap-2">
            <i class="fas fa-print"></i> Print
        </button>

        <button class="px-4 py-2 rounded-lg bg-blue-100 text-blue-600 hover:text-blue-300 transition flex items-center gap-2">
            <i class="fas fa-cog"></i> Generate Invoice
        </button>

    </div>
    <button class="px-4 py-2 rounded-lg bg-red-100 text-red-600 hover:text-red-300 transition flex items-center gap-2">
        <i class="fas fa-trash-alt"></i> Cancel Order
    </button>
</div>

<form id="orderForm" class="form-ajax" method="POST"
    action="@isset($order) {{ route('admin.orders.update', $order->id) }} @else {{ route('admin.orders.store') }} @endisset"
    enctype="multipart/form-data">
    @csrf
    @isset($order) @method('PUT') @endisset
    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" id="order_data">
        @include('orders::orders.components.order_detail')
    </div>
</form>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        // loadOrder();
    });

    function loadOrder() {
        ceAjax('get', '{{ route("admin.orders.show", $order->id) }}', {
            loader: true,
            result_ids: 'order_data', // This will update the calendar container directly
            data: {
                tab: true,
            },
            caching: false,
            callback: function(data) {
                $('#order_data').html('<div class="col-span-7 py-8 text-center">Order Loading...</div>');
            },
            errorCallback: function(xhr) {
                showToast('Unable to load order data', 'error', 'Error');
            }
        });
    }
</script>

@endsection