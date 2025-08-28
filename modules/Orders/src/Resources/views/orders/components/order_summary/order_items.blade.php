<div class="bg-white rounded-lg border divide-gray-100 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-100">
        @include('orders::orders.components.order_summary.table.head')
        <tbody id="order_items" class="bg-white divide-y divide-gray-100">
            @if(!empty($order_items))
            @foreach($order_items ?? [] as $item)
            <tr class="hover:bg-gray-50 group">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-16 w-16 bg-gray-200 rounded-md flex items-center justify-center">
                            <i class="fas fa-box text-gray-400"></i>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-blue-600">
                                <a href="{{ route('admin.catalog.products.edit', $item['product_id']) }}">{{ $item['product_name'] }}</a>
                            </div>
                            <div class="text-sm text-gray-500">Product ID: #{{ $item['product_id'] }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $item['sku'] ?? 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="relative w-24">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <span class="text-gray-500 text-sm">$</span>
                        </div>
                        <input type="text" value="{{ number_format($item['price'], 2) }}" class="block w-full pl-7 pr-2 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ fn_convert_currency($item['tax'], $order['currency']) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <button class="p-1 text-gray-500 hover:text-gray-700 quantity-decrease"
                            data-item-id="{{ $item['id'] }}">
                            <i class="fas fa-minus-circle"></i>
                        </button>
                        <input type="text"
                            value="{{ $item['quantity'] }}"
                            class="w-12 mx-2 text-center border border-gray-300 rounded-md py-1 text-sm quantity-input"
                            data-item-id="{{ $item['id'] }}"
                            data-price="{{ $item['price'] }}"
                            data-original-quantity="{{ $item['quantity'] }}">
                        <button class="p-1 text-gray-500 hover:text-gray-700 quantity-increase"
                            data-item-id="{{ $item['id'] }}">
                            <i class="fas fa-plus-circle"></i>
                        </button>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 line-total">
                    {{ fn_convert_currency($item['line_total'], $order['currency']) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex justify-end space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <a href="javascript:;" class="text-gray-600 hover:text-red-600 remove-item"
                            data-item-id="{{ $item['id'] }}" data-product-id="{{ $item['product_id'] }}">
                            <i class="fas fa-times-circle"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
            @else
                <tr>
                    <td colspan="7">
                          <div class="text-sm text-gray-500 text-center p-6">No Items</div>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>