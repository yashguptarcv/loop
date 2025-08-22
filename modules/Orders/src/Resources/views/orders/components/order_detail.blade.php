    <!-- Order Items Section -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Order Items Card -->
        <div class="bg-white rounded-xl p-6">
            <div class="flex justify-between items-start mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Order Items ({{ count($order_items) }})</h2>                
                <x-modal 
                    buttonText='<i class="fas fa-plus"></i> Add Item'
                    type='link'
                    modalTitle="Add To Cart"
                    id="add_to_cart"
                    ajaxUrl="{{route('dataview.export')}}"
                    buttonClass="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-sm hover:bg-blue-100 flex items-center gap-2"
                    modalSize="2xl"
                />
            </div>

            <!-- Order Items Table -->
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>                            
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">&nbsp;</th>                            
                        </tr>
                    </thead>
                    <tbody id="order_items" class="bg-white divide-y divide-gray-200">
                        @foreach($order_items as $item)
                        <tr class="hover:bg-gray-50 group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-16 w-16 bg-gray-200 rounded-md flex items-center justify-center">
                                        <i class="fas fa-box text-gray-400"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-blue-600">
                                            <a href="{{route('admin.catalog.products.edit', $item->product_id)}}">{{ $item->product_name }}</a>
                                        </div>
                                        <div class="text-sm text-gray-500">Product ID: #{{ $item->product_id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $item->sku ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="relative w-24">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <span class="text-gray-500 text-sm">$</span>
                                    </div>
                                    <input type="text" value="{{ number_format($item->price, 2) }}" class="block w-full pl-7 pr-2 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <button class="p-1 text-gray-500 hover:text-gray-700">
                                        <i class="fas fa-minus-circle"></i>
                                    </button>
                                    <input type="text" value="{{ $item->quantity }}" class="w-12 mx-2 text-center border border-gray-300 rounded-md py-1 text-sm">
                                    <button class="p-1 text-gray-500 hover:text-gray-700">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                ${{ number_format($item->price * $item->quantity, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">                                    
                                    <a href="#" class="text-gray-600 hover:text-gray-900">
                                        <i class="fas fa-times-circle"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Add Discount Section -->
            <div class="mt-6 pt-4 border-t border-gray-100">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-sm font-medium text-gray-700">DISCOUNTS</h3>
                    
                    <x-modal 
                        buttonText='<i class="fas fa-plus"></i> Add Discount'
                        type='link'
                        modalTitle="Add Discount"
                        id="add_cart_discount"
                        ajaxUrl="{{route('dataview.export')}}"
                        buttonClass="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1"
                        modalSize="2xl"
                    />
                </div>
                <div id="discount">
                    @if($order_summary['discount'] > 0)
                    <div class="bg-blue-50 p-3 mb-2 rounded-lg flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-blue-800">DISCOUNT</p>
                            <p class="text-xs text-blue-600">-${{ number_format($order_summary['discount'], 2) }}</p>
                        </div>
                        <button class="text-red-400 hover:text-red-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Order Summary -->
            <div id="order_summary" class="mt-6 pt-4 border-t border-gray-100">
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="text-gray-800 font-medium">${{ number_format($order_summary['subtotal'], 2) }}</span>
                </div>
                @if($order_summary['discount'] > 0)
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Discount</span>
                    <span class="text-red-600 font-medium">-${{ number_format($order_summary['discount'], 2) }}</span>
                </div>
                @endif
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Shipping</span>
                    <div class="flex items-center gap-2">
                        <input type="text" value="${{ number_format($order_summary['shipping'], 2) }}" class="w-20 p-1 border border-gray-300 rounded-md text-sm text-right">
                        <button class="text-gray-400 hover:text-blue-600">
                            <i class="fas fa-check text-xs"></i>
                        </button>
                    </div>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Tax</span>
                    <div class="flex items-center gap-2">
                        <input type="text" value="${{ number_format($order_summary['tax'], 2) }}" class="w-20 p-1 border border-gray-300 rounded-md text-sm text-right">
                        <button class="text-gray-400 hover:text-blue-600">
                            <i class="fas fa-check text-xs"></i>
                        </button>
                    </div>
                </div>
                <div class="flex justify-between py-3 mt-2 border-t border-gray-100">
                    <span class="text-gray-800 font-semibold">Total</span>
                    <span class="text-gray-800 font-bold text-lg">${{ number_format($order_summary['total'], 2) }}</span>
                </div>
            </div>
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
                                modalSize="2xl"
                            />
                        </h3>
                        <div id="customer_details" class="rounded-xl p-4 pl-2 space-y-1 bg-gray-50">
                            <p class="text-gray-800">
                                <span class="font-medium">{{ $customer_details['name'] }}</span>
                                (Customer ID: #{{ $customer_details['id'] }})
                            </p>
                            <p class="text-gray-800">{{ $customer_details['email'] }}</p>
                            <p class="text-gray-800">{{ $customer_details['phone'] }}</p>

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
                                modalSize="2xl"
                            />
                        </h3>
                        <div id="billing_address" class="rounded-xl p-4 pl-2 space-y-1 bg-gray-50">
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
                                modalSize="2xl"
                            />
                        </h3>
                        <div id="payment_details">
                            @if($payment_details)
                            <div class="rounded-xl shadow-sm p-4 flex items-center gap-3 border border-gray-200 rounded-lg bg-gray-50">
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
                            <div class="rounded-xl shadow-sm p-4 border border-gray-200 rounded-lg bg-gray-50">
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
                                modalSize="2xl"
                            />
                        </h3>
                        <div id="order_notes" class="rounded-xl shadow-sm p-4 bg-gray-50">
                            {{ $order_note ?? 'No notes available' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>