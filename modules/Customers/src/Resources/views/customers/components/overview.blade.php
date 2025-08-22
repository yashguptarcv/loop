<!-- Customer Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <!-- Total Orders -->
    <div class="bg-white rounded-lg border border-gray-200 p-4">
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
    <div class="bg-white rounded-lg border border-gray-200 p-4">
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
    <div class="bg-white rounded-lg border border-gray-200 p-4">
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
    <div class="bg-white rounded-lg border border-gray-200 p-4">
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
                <div class="bg-white rounded-lg border border-gray-200 p-6">
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

                <!-- Recent Orders -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-semibold text-gray-900">Recent Orders</h2>
                        <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            View All Orders
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">
                                        <a href="#" class="hover:underline">#ORD-2023-01542</a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Oct 15, 2023</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 rounded-full bg-green-100 text-green-800 text-xs font-medium">
                                            Completed
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">3</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">$420.35</td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">
                                        <a href="#" class="hover:underline">#ORD-2023-01428</a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Sep 28, 2023</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 rounded-full bg-green-100 text-green-800 text-xs font-medium">
                                            Completed
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">5</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">$587.90</td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">
                                        <a href="#" class="hover:underline">#ORD-2023-01315</a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Sep 15, 2023</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 rounded-full bg-red-100 text-red-800 text-xs font-medium">
                                            Returned
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">-$129.99</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Customer Details -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6">Customer Details</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">CONTACT INFORMATION</h3>
                            <div class="mt-2 space-y-1">
                                <p class="text-gray-900"><i class="fas fa-envelope text-gray-400 mr-2"></i> johndoe@example.com</p>
                                <p class="text-gray-900"><i class="fas fa-phone text-gray-400 mr-2"></i> +1 (555) 123-4567</p>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">PRIMARY ADDRESS</h3>
                            <div class="mt-2">
                                <p class="text-gray-900">123 Main Street</p>
                                <p class="text-gray-900">Apt 4B</p>
                                <p class="text-gray-900">New York, NY 10001</p>
                                <p class="text-gray-900">United States</p>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">CUSTOMER METADATA</h3>
                            <div class="mt-2 grid grid-cols-2 gap-2">
                                <div>
                                    <p class="text-xs text-gray-500">Customer Tier</p>
                                    <p class="text-sm font-medium text-gray-900">Gold</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Loyalty Points</p>
                                    <p class="text-sm font-medium text-gray-900">1,245</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Last Purchase</p>
                                    <p class="text-sm font-medium text-gray-900">15 days ago</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Avg. Order Freq.</p>
                                    <p class="text-sm font-medium text-gray-900">23 days</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Lifetime Value -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6">Customer Value</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between items-center">
                                <h3 class="text-sm font-medium text-gray-500">LIFETIME VALUE</h3>
                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">Projected</span>
                            </div>
                            <p class="text-2xl font-bold text-gray-900 mt-1">$8,245.00</p>
                        </div>
                        
                        <div class="pt-4 border-t border-gray-200">
                            <h3 class="text-sm font-medium text-gray-500 mb-2">PROFIT MARGIN</h3>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-green-600 h-2.5 rounded-full" style="width: 30%"></div>
                            </div>
                            <div class="flex justify-between text-xs text-gray-500 mt-1">
                                <span>Industry Avg: 25%</span>
                                <span>Your Avg: 30%</span>
                            </div>
                        </div>
                        
                        <div class="pt-4 border-t border-gray-200">
                            <h3 class="text-sm font-medium text-gray-500 mb-2">PURCHASE CATEGORIES</h3>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-medium text-gray-700">Electronics</span>
                                    <span class="text-xs text-gray-500">42%</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-medium text-gray-700">Home Goods</span>
                                    <span class="text-xs text-gray-500">28%</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-medium text-gray-700">Accessories</span>
                                    <span class="text-xs text-gray-500">18%</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-medium text-gray-700">Other</span>
                                    <span class="text-xs text-gray-500">12%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>