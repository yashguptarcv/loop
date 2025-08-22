@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto text-center">
        <div class="bg-white rounded-lg shadow-md p-8">
            <div class="mb-6">
                <svg class="mx-auto h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            
            <h1 class="text-3xl font-bold mb-4">Order Confirmed!</h1>
            <p class="text-lg mb-6">Thank you for your order. Your order number is <span class="font-semibold">{{ $order->order_number }}</span>.</p>
            
            <div class="bg-gray-50 rounded-lg p-6 mb-6 text-left">
                <h2 class="text-xl font-semibold mb-4">Order Details</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h3 class="font-medium text-gray-900">Order Number</h3>
                        <p>{{ $order->order_number }}</p>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900">Date</h3>
                        <p>{{ $order->created_at->format('F j, Y') }}</p>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900">Total</h3>
                        <p>${{ number_format($order->total, 2) }}</p>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900">Payment Method</h3>
                        <p>{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</p>
                    </div>
                </div>
                
                <div class="mt-6">
                    <h3 class="font-medium text-gray-900">Items</h3>
                    <ul class="divide-y divide-gray-200">
                        @foreach($order->items as $item)
                        <li class="py-4 flex justify-between">
                            <div class="flex items-center">
                                <div class="ml-4">
                                    <h4 class="text-sm font-medium text-gray-900">{{ $item->product_name }}</h4>
                                    <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                                </div>
                            </div>
                            <div class="text-sm font-medium">${{ number_format($item->price * $item->quantity, 2) }}</div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            
            <div class="flex justify-center">
                <a href="{{ route('home') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-md font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection