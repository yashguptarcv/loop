<div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-primary-100">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500">{{ $widget->title }}</p>
            
            @if($widget->operation === 'profit_loss')
                <p class="text-2xl font-semibold text-gray-800 mt-1 {{ $value >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $value >= 0 ? 'Profit: ' : 'Loss: ' }}{{ fn_get_widget_value($widget->is_currency, $value) }}
                </p>
                <p class="text-xs mt-2 flex items-center {{ $value >= 0 ? 'text-green-500' : 'text-red-500' }}">
                    @if($value >= 0)
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                        </svg>
                        Profit
                    @else
                        <svg class="w-3 h-3 mr-1 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                        </svg>
                        Loss
                    @endif
                </p>
            @elseif($widget->operation === 'month_compare')
                <p class="text-2xl font-semibold text-gray-800 mt-1">
                   {{ fn_get_widget_value($widget->is_currency, $current) }}
                </p>
                <p class="text-xs mt-2 flex items-center {{ $diff >= 0 ? 'text-green-500' : 'text-red-500' }}">
                    @if($diff >= 0)
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                        </svg>
                    @else
                        <svg class="w-3 h-3 mr-1 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                        </svg>
                    @endif
                    {{ abs($percent) }}% from last month
                </p>
                <p class="text-xs text-gray-500 mt-1">Last: {{ fn_get_widget_value($widget->is_currency, $last) }}</p>
            @else
                <p class="text-2xl font-semibold text-gray-800 mt-1">
                    {{ is_numeric($value) ? fn_get_widget_value($widget->is_currency, $value) : $value }}
                </p>
            @endif
        </div>
        <div class="bg-blue-100 p-3 rounded-lg">
            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
    </div>
</div>