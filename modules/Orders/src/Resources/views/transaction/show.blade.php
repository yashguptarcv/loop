@extends('admin::layouts.app')

@section('title', 'Transaction | #'.$transaction->transaction_number)

@section('styles')

@endsection
@section('content')
    @include('admin::components.common.back-button', ['route' => route('admin.transactions.index'), 'name' => 'Transaction #'.$transaction->transaction_number . ' / '. $transaction->status . ' / '. $transaction->created_at->format('F j, Y')])

    <!-- Transaction Header -->
        <div class="bg-primary-100  text-amber-100 p-6 rounded-t-lg flex flex-col md:flex-row justify-between items-start md:items-center">
            <div class="mb-4 md:mb-0">
                <h1 class="text-2xl font-bold">Transaction Details</h1>
                <p class="text-white mt-1">Transaction #TXN-789456123</p>
            </div>
            <div class="bg-white bg-opacity-10 p-3 rounded-lg">
                <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Completed</span>
                <p class="text-white text-sm mt-1">Processed: June 19, 2023</p>
            </div>
        </div>

        <!-- Transaction Body -->
        <div class="bg-white p-6 rounded-b-lg shadow-md">
            <!-- Main Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Left Column - Transaction Details -->
                <div class="lg:col-span-2">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Transaction Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="bg-gray-50 p-4 rounded border-l-4 border-indigo-500">
                            <p class="text-sm text-gray-500">Transaction ID</p>
                            <p class="font-semibold">TXN-789456123</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded border-l-4 border-indigo-500">
                            <p class="text-sm text-gray-500">Reference Number</p>
                            <p class="font-semibold">ORD-56757</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded border-l-4 border-indigo-500">
                            <p class="text-sm text-gray-500">Transaction Date</p>
                            <p class="font-semibold">June 19, 2023, 14:30 EST</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded border-l-4 border-indigo-500">
                            <p class="text-sm text-gray-500">Payment Method</p>
                            <p class="font-semibold">Credit Card (Visa)</p>
                        </div>
                    </div>
                    
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Order Details</h2>
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-semibold">Innovation Excellence Award Application</p>
                                <p class="text-sm text-gray-600">Application ID: APP-2023-0621</p>
                            </div>
                            <p class="font-semibold">$249.00</p>
                        </div>
                        <div class="border-t border-gray-200 my-3"></div>
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm">Processing Fee</p>
                            </div>
                            <p class="text-sm">$5.95</p>
                        </div>
                        <div class="flex justify-between items-start mt-1">
                            <div>
                                <p class="text-sm">Tax</p>
                            </div>
                            <p class="text-sm">$21.67</p>
                        </div>
                        <div class="border-t border-gray-200 my-3"></div>
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-semibold">Total Amount</p>
                            </div>
                            <p class="font-semibold text-lg">$276.62</p>
                        </div>
                    </div>
                    
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Payment Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded border-l-4 border-indigo-500">
                            <p class="text-sm text-gray-500">Card Number</p>
                            <p class="font-semibold">**** **** **** 1234</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded border-l-4 border-indigo-500">
                            <p class="text-sm text-gray-500">Cardholder Name</p>
                            <p class="font-semibold">Sarah Johnson</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded border-l-4 border-indigo-500">
                            <p class="text-sm text-gray-500">Authorization Code</p>
                            <p class="font-semibold">A789B456</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded border-l-4 border-indigo-500">
                            <p class="text-sm text-gray-500">Payment Gateway</p>
                            <p class="font-semibold">Stripe</p>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column - Status & Actions -->
                <div class="lg:col-span-1">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Transaction Status</h2>
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-gray-600">Status:</span>
                            <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Completed</span>
                        </div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-gray-600">Amount:</span>
                            <span class="font-semibold">$276.62</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Currency:</span>
                            <span class="font-semibold">USD</span>
                        </div>
                    </div>
                    
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Timeline</h2>
                    <div class="relative pl-8 border-l-2 border-gray-200 space-y-6">
                        <div class="relative">
                            <div class="absolute -left-9 mt-0.5 w-3 h-3 rounded-full bg-green-500 border-2 border-white ring-2 ring-green-500"></div>
                            <h5 class="text-sm font-medium text-gray-900">Transaction Initiated</h5>
                            <p class="text-xs text-gray-500 mt-1">June 19, 2023, 14:30 EST</p>
                        </div>
                        <div class="relative">
                            <div class="absolute -left-9 mt-0.5 w-3 h-3 rounded-full bg-green-500 border-2 border-white ring-2 ring-green-500"></div>
                            <h5 class="text-sm font-medium text-gray-900">Payment Authorized</h5>
                            <p class="text-xs text-gray-500 mt-1">June 19, 2023, 14:32 EST</p>
                        </div>
                        <div class="relative">
                            <div class="absolute -left-9 mt-0.5 w-3 h-3 rounded-full bg-green-500 border-2 border-white ring-2 ring-green-500"></div>
                            <h5 class="text-sm font-medium text-gray-900">Payment Processed</h5>
                            <p class="text-xs text-gray-500 mt-1">June 19, 2023, 14:35 EST</p>
                        </div>
                        <div class="relative">
                            <div class="absolute -left-9 mt-0.5 w-3 h-3 rounded-full bg-green-500 border-2 border-white ring-2 ring-green-500"></div>
                            <h5 class="text-sm font-medium text-gray-900">Funds Transferred</h5>
                            <p class="text-xs text-gray-500 mt-1">June 20, 2023, 09:15 EST</p>
                        </div>
                    </div>
                    
                    <h2 class="text-lg font-semibold text-gray-800 mt-6 mb-4">Actions</h2>
                    <div class="flex flex-col gap-2">
                        <button class="inline-flex items-center px-3 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50">
                            <i class="fas fa-receipt mr-2"></i>
                            View Invoice
                        </button>
                        <button class="inline-flex items-center px-3 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50">
                            <i class="fas fa-file-download mr-2"></i>
                            Download Receipt
                        </button>
                        <button class="inline-flex items-center px-3 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50">
                            <i class="fas fa-redo mr-2"></i>
                            Refund Transaction
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Customer Information -->
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Customer Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-gray-50 p-4 rounded border-l-4 border-indigo-500">
                    <p class="text-sm text-gray-500">Customer Name</p>
                    <p class="font-semibold">Sarah Johnson</p>
                    <p class="text-sm text-gray-600 mt-1">sarah@techinnovate.com</p>
                </div>
                <div class="bg-gray-50 p-4 rounded border-l-4 border-indigo-500">
                    <p class="text-sm text-gray-500">Billing Address</p>
                    <p class="font-semibold">TechInnovate Inc.</p>
                    <p class="text-sm text-gray-600">456 Business Ave</p>
                    <p class="text-sm text-gray-600">San Francisco, CA 94105</p>
                </div>
            </div>
            
            <!-- Merchant Information -->
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Merchant Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 p-4 rounded border-l-4 border-indigo-500">
                    <p class="text-sm text-gray-500">Merchant Name</p>
                    <p class="font-semibold">AwardsHub Inc.</p>
                    <p class="text-sm text-gray-600 mt-1">contact@awardshub.com</p>
                </div>
                <div class="bg-gray-50 p-4 rounded border-l-4 border-indigo-500">
                    <p class="text-sm text-gray-500">Merchant Address</p>
                    <p class="font-semibold">AwardsHub Inc.</p>
                    <p class="text-sm text-gray-600">123 Innovation Way</p>
                    <p class="text-sm text-gray-600">San Francisco, CA 94103</p>
                </div>
            </div>
        </div>

@endsection