    <!-- Order Items Section -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Order Items Card -->
        <div class="bg-white rounded-xl p-6">
            <div class="flex justify-between items-start mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Order Items ({{ count($order_items??[]) }})</h2>
                <x-modal
                    buttonText='<i class="fas fa-plus"></i> Add Item'
                    type='link'
                    modalTitle="Add To Cart"
                    id="add_to_cart"
                    ajaxUrl="{{route('api.cart.item.view', $order->id ?? 0)}}"
                    buttonClass="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-sm hover:bg-blue-100 flex items-center gap-2"
                    modalSize="3xl" />
            </div>

            <!-- Order Items Table -->
            @include('orders::orders.components.order_summary.order_items')

            @include('orders::orders.components.order_summary.discount')

            @include('orders::orders.components.order_summary.order_summary')
            
        </div>
    </div>

    <!-- Right Sidebar -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Customer Details Card -->
        <div class="bg-white p-6 rounded-xl sticky top-6">
            <div class="relative">
                <!-- Customer Details -->
                <div class="mb-6 group">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2 flex items-center justify-between">
                            <span>CUSTOMER DETAILS</span>
                            <x-modal
                                buttonText='<i class="fas fa-edit"></i> Update Customer'
                                type='link'
                                modalTitle="Update Customer"
                                id="add_cart_update_customer"
                                ajaxUrl="{{route('dataview.export')}}"
                                buttonClass="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1"
                                modalSize="2xl" />
                        </h3>
                        <div id="customer_details" class="rounded-xl p-4 pl-2 space-y-1 bg-gray-50">
                            @if(!empty($customer_details))
                            <p class="text-gray-800">
                                <span class="font-medium">{{ $customer_details['name'] }}</span>
                                (Customer ID: #{{ $customer_details['id'] }})
                            </p>
                            <p class="text-gray-800">{{ $customer_details['email'] }}</p>
                            <p class="text-gray-800">{{ $customer_details['phone'] }}</p>
                            @else
                               <div class="rounded-xl shadow-sm p-4 border divide-gray-100 rounded-lg bg-gray-50">
                                    <p class="text-sm text-gray-600">No Customer Added</p>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

                <!-- Billing Address -->
                <div class="mb-6 group border-t border-gray-100 pt-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2 flex items-center justify-between">
                            <span>BILLING ADDRESS</span>

                            <x-modal
                                buttonText='<i class="fas fa-edit"></i> Update Customer'
                                type='link'
                                modalTitle="Update Billing Address"
                                id="add_cart_update_billing"
                                ajaxUrl="{{route('dataview.export')}}"
                                buttonClass="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1"
                                modalSize="2xl" />
                        </h3>
                        <div id="billing_address" class="rounded-xl p-4 pl-2 space-y-1 bg-gray-50">
                            @if(!empty($billing_address))
                                @if(!empty($billing_address['name']))
                                <p class="text-gray-800 font-medium">{{ $billing_address['name'] }}</p>
                                @endif
                                @if(!empty($billing_address['address_1']))
                                <p class="text-gray-800">{{ $billing_address['address_1'] }}</p>
                                @endif
                                @if(!empty($billing_address['city']) || !empty($billing_address['state']) || !empty($billing_address['postcode']))
                                <p class="text-gray-800">
                                    {{ $billing_address['city'] ?? '' }}
                                    {{ !empty($billing_address['city']) && !empty($billing_address['state']) ? ', ' : '' }}
                                    {{ $billing_address['state'] ?? '' }}
                                    {{ $billing_address['postcode'] ?? '' }}
                                </p>
                                @endif
                                @if(!empty($billing_address['country']))
                                <p class="text-gray-800">{{ $billing_address['country'] }}</p>
                                @endif
                                @if(!empty($billing_address['email']))
                                <p class="text-gray-800">{{ $billing_address['email'] }}</p>
                                @endif
                                @if(!empty($billing_address['phone']))
                                <p class="text-gray-800">{{ $billing_address['phone'] }}</p>
                                @endif
                            @else
                                <div class="rounded-xl shadow-sm p-4 border divide-gray-100 rounded-lg bg-gray-50">
                                    <p class="text-sm text-gray-600">No Billing Address</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Payment Details -->
                <div class="mb-6 group border-t border-gray-100 pt-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2 flex items-center justify-between">
                            <span>PAYMENT DETAILS</span>

                            <x-modal
                                buttonText='<i class="fas fa-edit"></i> Update Payment'
                                type='link'
                                modalTitle="Update Payment"
                                id="add_cart_update_billing_payment"
                                ajaxUrl="{{route('dataview.export')}}"
                                buttonClass="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1"
                                modalSize="2xl" />
                        </h3>
                        <div id="payment_details">
                            @if(!empty($payment_details))
                            <div class="rounded-xl shadow-sm p-4 flex items-center gap-3 border divide-gray-100 rounded-lg bg-gray-50">
                                <div class="w-10 h-6 bg-gray-100 rounded flex items-center justify-center">
                                    <i class="fab fa-cc-visa text-blue-800"></i>
                                </div>
                                <div class="flex-grow">
                                    <p class="text-sm">Payment Method: {{ $order->payment_method ?? 'Not specified' }}</p>
                                    <p class="text-xs text-gray-500">Status:
                                        <span class="{{ $order->payment_status == 'paid' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ ucfirst($order->payment_status) }}
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

                <!-- Order Notes -->
                <div class="mb-6 group border-t border-gray-100 pt-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2 flex items-center justify-between">
                            <span>ORDER NOTES</span>

                            <x-modal
                                buttonText='<i class="fas fa-edit"></i> Note'
                                type='link'
                                modalTitle="Order Note"
                                id="add_cart_update_order_note"
                                ajaxUrl="{{route('dataview.export')}}"
                                buttonClass="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1"
                                modalSize="2xl" />
                        </h3>
                        <div id="order_notes" class="rounded-xl shadow-sm p-4 bg-gray-50">
                            {{ $order_note ?? 'No notes available' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>