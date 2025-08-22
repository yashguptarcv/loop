@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Checkout</h1>
        
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
            
            <div class="divide-y divide-gray-200">
                @foreach($items as $item)
                <div class="py-4 flex justify-between">
                    <div class="flex items-center">
                        <div class="ml-4">
                            <h3 class="text-lg font-medium">{{ $item['name'] }}</h3>
                            <p class="text-gray-600">Qty: {{ $item['quantity'] }}</p>
                        </div>
                    </div>
                    <div class="text-lg font-medium">${{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                </div>
                @endforeach
            </div>
            
            <div class="border-t border-gray-200 mt-4 pt-4">
                <div class="flex justify-between text-lg font-semibold">
                    <span>Total</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
            </div>
        </div>
        
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Billing Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" id="first_name" name="billing_address[first_name]" 
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" id="last_name" name="billing_address[last_name]" 
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                </div>
                
                <div class="mt-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="billing_address[email]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                
                <div class="mt-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="tel" id="phone" name="billing_address[phone]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                
                <div class="mt-4">
                    <label for="address1" class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" id="address1" name="billing_address[address1]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                
                <div class="mt-4">
                    <label for="address2" class="block text-sm font-medium text-gray-700">Address 2 (Optional)</label>
                    <input type="text" id="address2" name="billing_address[address2]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                        <input type="text" id="city" name="billing_address[city]" 
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div>
                        <label for="state" class="block text-sm font-medium text-gray-700">State/Province</label>
                        <input type="text" id="state" name="billing_address[state]" 
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div>
                        <label for="zip" class="block text-sm font-medium text-gray-700">ZIP/Postal Code</label>
                        <input type="text" id="zip" name="billing_address[zip]" 
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                </div>
                
                <div class="mt-4">
                    <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                    <select id="country" name="billing_address[country]" 
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="US">United States</option>
                        <option value="CA">Canada</option>
                        <!-- Add more countries as needed -->
                    </select>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Order Notes</h2>
                <textarea name="notes" rows="4" class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Any special instructions or notes about your order..."></textarea>
            </div>
            
            <!-- Hidden items data -->
            @foreach($items as $index => $item)
                <input type="hidden" name="items[{{ $index }}][product_id]" value="{{ $item['product_id'] }}">
                <input type="hidden" name="items[{{ $index }}][quantity]" value="{{ $item['quantity'] }}">
                <input type="hidden" name="items[{{ $index }}][price]" value="{{ $item['price'] }}">
                <input type="hidden" name="items[{{ $index }}][name]" value="{{ $item['name'] }}">
            @endforeach
            
            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-md font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Continue to Payment
                </button>
            </div>
        </form>
    </div>
</div>
@endsection