<!-- Customer Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <!-- Total Orders -->
    <div class="bg-white rounded-lg border divide-gray-100 p-4">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Orders</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">14</p>
            </div>
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-shopping-bag"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm text-green-600">
            <i class="fas fa-arrow-up mr-1"></i>
            <span>12% from last month</span>
        </div>
    </div>

    <!-- Total Spending -->
    <div class="bg-white rounded-lg border divide-gray-100 p-4">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Spending</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">$5,428.75</p>
            </div>
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm text-green-600">
            <i class="fas fa-arrow-up mr-1"></i>
            <span>8% from last month</span>
        </div>
    </div>

    <!-- Average Order Value -->
    <div class="bg-white rounded-lg border divide-gray-100 p-4">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-gray-500">Avg. Order Value</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">$387.77</p>
            </div>
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm text-red-600">
            <i class="fas fa-arrow-down mr-1"></i>
            <span>3% from last month</span>
        </div>
    </div>

    <!-- Customer Since -->
    <div class="bg-white rounded-lg border divide-gray-100 p-4">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-gray-500">Customer Since</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">Jan 2022</p>
            </div>
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                <i class="fas fa-calendar-alt"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm text-gray-500">
            <span>1 year, 8 months</span>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Profit/Loss Analysis -->
        <div class="bg-white rounded-lg border divide-gray-100 p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Profit Analysis</h2>
                <select class="text-sm border border-gray-300 rounded-md px-3 py-1 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option>Last 12 Months</option>
                    <option>Last 6 Months</option>
                    <option>Last 3 Months</option>
                    <option>This Year</option>
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-sm font-medium text-blue-800">Total Revenue</p>
                    <p class="text-2xl font-bold text-blue-600 mt-1">$5,428.75</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <p class="text-sm font-medium text-green-800">Total Profit</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">$1,628.63</p>
                    <p class="text-xs text-green-600 mt-1">30% margin</p>
                </div>
                <div class="bg-red-50 p-4 rounded-lg">
                    <p class="text-sm font-medium text-red-800">Total Loss</p>
                    <p class="text-2xl font-bold text-red-600 mt-1">$243.50</p>
                    <p class="text-xs text-red-600 mt-1">From 2 returns</p>
                </div>
            </div>

            <!-- Chart Placeholder -->
            <div class="bg-gray-100 rounded-lg h-64 flex items-center justify-center text-gray-400">
                <i class="fas fa-chart-bar text-4xl"></i>
                <span class="ml-2">Profit/Loss Chart</span>
            </div>
        </div>

       
    </div>

    <!-- Right Column -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Customer Details -->
        <div class="bg-white rounded-lg border divide-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">Customer Details</h2>

            <div class="space-y-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">CONTACT INFORMATION</h3>
                    <div class="mt-2 space-y-1">
                        <p class="text-gray-900"><i class="fas fa-envelope text-gray-400 mr-2"></i>{{ $customer->email }}</p>                        
                        <p class="text-gray-900">
                            <i class="fas fa-phone text-gray-400 mr-2"></i>{{ $customer->phone ?? '' }}
                        </p>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">PRIMARY ADDRESS</h3>
                    @if(!empty($customer->defaultBillingAddress) && !empty($customer->defaultBillingAddress->toArray()))
                        {!! \Modules\Customers\Helper\AddressHelper::format($customer->defaultBillingAddress->toArray(), 'html') !!}
                    @else
                    <div class="rounded-xl shadow-sm p-4 border divide-gray-100 rounded-lg bg-gray-50">
                        <p class="text-sm text-gray-600">No Billing Address</p>
                    </div>
                    @endif
                    </div>
                </div>

               
            </div>
        </div>

    </div>
</div>