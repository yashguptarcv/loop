<form id="order_idForm" class="form-ajax grid grid-cols-1 lg:grid-cols-5 gap-2" method="POST"
    action="@if(!empty($order_id) && $mode != 'create') {{ route('admin.orders.update', $order_id) }} @else {{ route('admin.orders.store') }} @endisset"
    enctype="multipart/form-data">
    @csrf
    @if(!empty($order_id) && $mode != 'create') @method('PUT') @endif

<!-- Order Items Section -->
    <div class="lg:col-span-3 space-y-2">
        <!-- Order Items Card -->
        <div class="bg-white rounded-xl p-2">
            <div class="flex justify-between items-start mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Order Items ({{ count($order_items??[]) }})</h2>
                @if($mode === 'create' || $mode === 'edit')
                <x-modal
                    buttonText='<i class="fas fa-plus"></i> Add Item'
                    type='link'
                    modalTitle="Add To Cart"
                    id="add_to_cart"
                    ajaxUrl="{{route('api.cart.item.view', $order_id ?? 0)}}"
                    buttonClass="px-3 py-1 bg-primary-100 text-amber-100 rounded-lg text-sm hover:text-amber-200 flex items-center gap-2"
                    modalSize="3xl" />
                @endif
            </div>

            <!-- Order Items Table -->
            @include('orders::orders.components.order_summary.order_items')

            @include('orders::orders.components.order_summary.discount')

            @include('orders::orders.components.order_summary.order_summary')

            @include('orders::orders.components.order_summary.order_notes')
        </div>
    </div>

    <!-- Right Sidebar -->
    <div class="lg:col-span-1 space-y-2">
        <!-- Customer Details Card -->
        <div class="bg-white p-2 rounded-xl">
            <div class="relative">
                <!-- Payment Details -->
                <div class="mb-6 group">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2 flex items-center justify-between">
                            &nbsp;
                        </h3>
                        <div id="payment_details">
                            <div class="rounded-xl shadow-sm p-4  divide-gray-100 rounded-lg bg-gray-50">
                                <div class="mb-4">
                                    <h3 class="text-md font-medium text-black-100 mb-2 flex items-center justify-between">
                                        Status
                                    </h3>
                                    
                                    <select name="order_status" id="order_status" class="w-full px-3 py-2 border border-gray-300 rounded-md">                                        
                                        @foreach(fn_get_order_statuses() as $statuses)
                                            
                                            <option value="{{$statuses->status_code}}" @if(!empty($status) && $status == $statuses->status_code) selected @endif>{{$statuses->name}}</option>
                                            
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <h3 class="text-md font-medium text-black-100 mb-2 flex items-center justify-between">
                                        Payment Information
                                    </h3>
                                    @if($mode === 'create' || $mode === 'edit')
                                    <select name="payment_method" id="payment_method" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                        <option value="">Select Payment</option>
                                        @foreach(fn_get_payments() as $payment)
                                            @if((!empty($total) && $total) >= $payment->amount)
                                                <option value="{{$payment->id}}" data-payment-code="{{$payment->payment_method_id}}">{{$payment->merchant_name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @endif
                                    <div id="payment-detail-action">
                                        @if(!empty($payment_details))
                                            @include('payments::orders.components.payments.detail')
                                        @endif
                                    </div>
                                </div>
                            </div>   
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Sidebar -->
    <div class="lg:col-span-1 space-y-2">
        <!-- Customer Details Card -->
        <div class="bg-white p-2 rounded-xl">
            <div class="relative">
                <!-- Customer Details -->
               @include('orders::orders.components.customer.customer')
               @include('orders::orders.components.customer.billing_address')
            </div>
        </div>
    </div>
</form>