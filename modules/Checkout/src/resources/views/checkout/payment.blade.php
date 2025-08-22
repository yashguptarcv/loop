@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Payment Method</h1>
        
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
            
            <div class="divide-y divide-gray-200">
                @foreach($checkoutData['items'] as $item)
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
        
        <form action="{{ route('checkout.complete') }}" method="POST">
            @csrf
            
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Select Payment Method</h2>
                
                <div class="space-y-4">
                    <div class="flex items-center">
                        <input id="credit-card" name="payment_method" type="radio" value="credit_card" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" checked>
                        <label for="credit-card" class="ml-3 block text-sm font-medium text-gray-700">Credit Card</label>
                    </div>
                    
                    <div class="flex items-center">
                        <input id="paypal" name="payment_method" type="radio" value="paypal" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                        <label for="paypal" class="ml-3 block text-sm font-medium text-gray-700">PayPal</label>
                    </div>
                    
                    <div class="flex items-center">
                        <input id="bank-transfer" name="payment_method" type="radio" value="bank_transfer" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                        <label for="bank-transfer" class="ml-3 block text-sm font-medium text-gray-700">Bank Transfer</label>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-between">
                <a href="{{ route('checkout.index') }}" class="bg-gray-200 text-gray-800 px-6 py-3 rounded-md font-medium hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Back
                </a>
                <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-md font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Complete Order
                </button>
            </div>
        </form>
    </div>
</div>
@endsection