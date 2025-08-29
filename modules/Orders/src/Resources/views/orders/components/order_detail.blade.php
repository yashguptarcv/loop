    <!-- Order Items Section -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Order Items Card -->
        <div class="bg-white rounded-xl p-6">
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
    <div class="lg:col-span-1 space-y-6">
        <!-- Customer Details Card -->
        <div class="bg-white p-6 rounded-xl sticky top-6">
            <div class="relative">
                <!-- Customer Details -->
               @include('orders::orders.components.customer.customer')
               @include('orders::orders.components.customer.billing_address')

                <!-- Billing Address -->
               

                <!-- Payment Details -->
                <div class="mb-6 group border-t border-gray-100 pt-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2 flex items-center justify-between">
                            <span>PAYMENT DETAILS</span>
                            @if($mode === 'create' || $mode === 'edit')
                            <x-modal
                                buttonText='<i class="fas fa-edit"></i>'
                                type='link'
                                modalTitle="Update Payment"
                                id="add_cart_update_billing_payment"
                                ajaxUrl="{{route('dataview.export')}}"
                                buttonClass="text-primary-100 hover:text-amber-200 text-sm flex items-center gap-1"
                                modalSize="2xl" />
                            @endif
                        </h3>
                        <div id="payment_details">
                            @if(!empty($payment_details))
                            <div class="rounded-xl shadow-sm p-4 flex items-center gap-3 border divide-gray-100 rounded-lg bg-gray-50">
                                <div class="w-10 h-6 bg-gray-100 rounded flex items-center justify-center">
                                    <i class="fab fa-cc-visa text-amber-200"></i>
                                </div>
                                <div class="flex-grow">
                                    <p class="text-sm">Payment Method: {{ $payment_method ?? 'Not specified' }}</p>
                                    <p class="text-xs text-gray-500">Status:
                                        <span class="{{ $payment_status == 'paid' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ ucfirst($payment_status) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            @else
                            <div class="rounded-xl shadow-sm p-4 border divide-gray-100 rounded-lg bg-gray-50">
                                <p class="text-sm text-gray-600">No payment details available</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>