
@extends('checkout::components.layout')

@section('page_title') Dashboard @endsection
@section('content')
    <div class="max-w-5xl w-full checkout-card rounded-2xl overflow-hidden">
        <!-- Header with progress -->
        <div class="gradient-bg text-white p-6">
            <h1 class="text-2xl font-bold mb-2">Complete Your Purchase</h1>
            <p class="text-blue-100">Secure checkout with encrypted payment processing</p>
            
            <div class="mt-8 flex items-center justify-between relative">
                <div class="absolute h-1 bg-white bg-opacity-30 top-4 left-0 right-0 rounded-full"></div>
                <div class="absolute h-1 bg-white w-2/3 top-4 left-0 rounded-full"></div>
                
                <div class="step flex flex-col items-center z-10 step-active">
                    <div class="w-10 h-10 rounded-full bg-white text-primary flex items-center justify-center mb-2 shadow-lg">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <span class="text-sm font-medium">Cart</span>
                </div>
                
                <div class="step flex flex-col items-center z-10 step-active">
                    <div class="w-10 h-10 rounded-full bg-white text-primary flex items-center justify-center mb-2 shadow-lg">
                        <i class="fas fa-user"></i>
                    </div>
                    <span class="text-sm font-medium">Details</span>
                </div>
                
                <div class="step flex flex-col items-center z-10">
                    <div class="w-10 h-10 rounded-full bg-white bg-opacity-20 text-white flex items-center justify-center mb-2">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <span class="text-sm font-medium">Payment</span>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="p-6 md:p-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Left Column - Form -->
            <div>
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-user-circle text-primary mr-2"></i> Contact Information
                </h2>
                
                <form class="space-y-6">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center" for="email">
                            <i class="fas fa-envelope text-gray-400 mr-2 text-xs"></i> Email address
                        </label>
                        <div class="relative">
                            <input type="email" id="email" class="w-full px-4 py-3 pl-10 border border-gray-200 rounded-lg input-focus focus:ring-2 focus:ring-primary focus:border-transparent transition duration-200" placeholder="your@email.com">
                            <i class="fas fa-envelope absolute left-3 top-3.5 text-gray-400"></i>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="first-name">First Name</label>
                            <input type="text" id="first-name" class="w-full px-4 py-3 border border-gray-200 rounded-lg input-focus focus:ring-2 focus:ring-primary focus:border-transparent transition duration-200" placeholder="John">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="last-name">Last Name</label>
                            <input type="text" id="last-name" class="w-full px-4 py-3 border border-gray-200 rounded-lg input-focus focus:ring-2 focus:ring-primary focus:border-transparent transition duration-200" placeholder="Doe">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center" for="address">
                            <i class="fas fa-home text-gray-400 mr-2 text-xs"></i> Shipping Address
                        </label>
                        <input type="text" id="address" class="w-full px-4 py-3 border border-gray-200 rounded-lg input-focus focus:ring-2 focus:ring-primary focus:border-transparent transition duration-200" placeholder="123 Main St">
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="city">City</label>
                            <input type="text" id="city" class="w-full px-4 py-3 border border-gray-200 rounded-lg input-focus focus:ring-2 focus:ring-primary focus:border-transparent transition duration-200" placeholder="New York">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="zip">ZIP Code</label>
                            <input type="text" id="zip" class="w-full px-4 py-3 border border-gray-200 rounded-lg input-focus focus:ring-2 focus:ring-primary focus:border-transparent transition duration-200" placeholder="10001">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="country">Country</label>
                        <div class="relative">
                            <select id="country" class="w-full px-4 py-3 border border-gray-200 rounded-lg input-focus focus:ring-2 focus:ring-primary focus:border-transparent appearance-none transition duration-200">
                                <option>United States</option>
                                <option>Canada</option>
                                <option>United Kingdom</option>
                                <option>Australia</option>
                                <option>Germany</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center" for="phone">
                            <i class="fas fa-phone text-gray-400 mr-2 text-xs"></i> Phone Number (optional)
                        </label>
                        <input type="tel" id="phone" class="w-full px-4 py-3 border border-gray-200 rounded-lg input-focus focus:ring-2 focus:ring-primary focus:border-transparent transition duration-200" placeholder="+1 (555) 000-0000">
                    </div>
                </form>
            </div>
            
            <!-- Right Column - Order Summary -->
            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-receipt text-primary mr-2"></i> Order Summary
                </h2>
                
                <div class="space-y-4 mb-6">
                    <div class="flex justify-between items-center bg-white p-4 rounded-xl product-shadow">
                        <div class="flex items-center">
                            <div class="h-20 w-20 bg-gradient-to-br from-blue-100 to-purple-100 rounded-lg overflow-hidden flex items-center justify-center">
                                <i class="fas fa-headphones text-2xl text-primary"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-800">Wireless Headphones</h4>
                                <p class="text-xs text-gray-500">Noise Cancelling • Black</p>
                                <div class="flex items-center mt-1">
                                    <div class="flex text-yellow-400">
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star-half-alt text-xs"></i>
                                    </div>
                                    <span class="text-xs text-gray-500 ml-1">(4.5)</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-sm font-medium text-gray-800 block">$129.99</span>
                            <div class="flex items-center justify-end mt-2">
                                <button class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-minus-circle"></i>
                                </button>
                                <span class="mx-2 text-gray-700">1</span>
                                <button class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-plus-circle"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center bg-white p-4 rounded-xl product-shadow">
                        <div class="flex items-center">
                            <div class="h-20 w-20 bg-gradient-to-br from-pink-100 to-red-100 rounded-lg overflow-hidden flex items-center justify-center">
                                <i class="fas fa-mobile-alt text-2xl text-accent"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-800">Phone Case</h4>
                                <p class="text-xs text-gray-500">Protective • Blue</p>
                                <div class="flex items-center mt-1">
                                    <div class="flex text-yellow-400">
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="far fa-star text-xs"></i>
                                    </div>
                                    <span class="text-xs text-gray-500 ml-1">(4.0)</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-sm font-medium text-gray-800 block">$24.99</span>
                            <div class="flex items-center justify-end mt-2">
                                <button class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-minus-circle"></i>
                                </button>
                                <span class="mx-2 text-gray-700">1</span>
                                <button class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-plus-circle"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 pt-4 space-y-3">
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Subtotal</span>
                        <span>$154.98</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Shipping</span>
                        <span>$5.99</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Estimated Tax</span>
                        <span>$12.40</span>
                    </div>
                    <div class="flex justify-between text-base font-medium text-gray-800 pt-2">
                        <span>Total</span>
                        <span class="text-lg font-bold">$173.37</span>
                    </div>
                </div>
                
                <div class="mt-6 bg-blue-50 p-4 rounded-lg border border-blue-100">
                    <div class="flex items-start">
                        <i class="fas fa-tag text-primary mt-1 mr-3"></i>
                        <div>
                            <h4 class="text-sm font-medium text-gray-800">Promo Code</h4>
                            <p class="text-xs text-gray-500">Apply your promo code for discounts</p>
                            <div class="flex mt-2">
                                <input type="text" class="flex-1 px-3 py-2 border border-gray-200 rounded-l-lg focus:outline-none focus:ring-1 focus:ring-primary text-sm" placeholder="Enter code">
                                <button class="bg-primary text-white px-4 py-2 rounded-r-lg text-sm hover:bg-secondary transition duration-200">Apply</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Navigation -->
        <div class="px-6 py-5 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center">
            <a href="#" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition duration-200 flex items-center mb-3 sm:mb-0">
                <i class="fas fa-arrow-left mr-2"></i>Return to cart
            </a>
            <div class="flex items-center text-sm text-gray-500 mr-4">
                <i class="fas fa-lock text-primary mr-1"></i> Secure payment encryption
            </div>
            <a href="#" class="px-5 py-2.5 text-sm font-medium text-white gradient-bg rounded-lg hover:opacity-90 transition duration-200 flex items-center shadow-md hover:shadow-lg">
                Continue to shipping<i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
@endsection