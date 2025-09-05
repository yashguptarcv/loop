@extends('admin::layouts.app')

@section('title', 'Invoices')

@section('styles')

@endsection
@section('content')
       
@include('admin::components.common.back-button', ['route' => route('admin.transactions.index'), 'name' => 'Invoice'])
        <!-- Invoice Header -->
        <div class="bg-primary-100  text-amber-100 p-6 rounded-t-lg flex flex-col md:flex-row justify-between items-start md:items-center">
            <div class="mb-4 md:mb-0">
                <h1 class="text-2xl font-bold">Invoice</h1>
                <p class="text-indigo-100 mt-1">Order #56757</p>
            </div>
            <div class="bg-white/10 p-3 rounded-lg">
                <span class="status-badge bg-green-100 text-green-800">Paid</span>
                <p class="text-white text-sm mt-1">Issued: June 19, 2023</p>
            </div>
        </div>

        <!-- Invoice Body -->
          <div class="bg-white p-6 rounded-b-lg shadow-md">
            <!-- Company and Client Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">From:</h2>
                    <p class="font-semibold">AwardsHub Inc.</p>
                    <p class="text-gray-600">123 Innovation Way</p>
                    <p class="text-gray-600">San Francisco, CA 94103</p>
                    <p class="text-gray-600">contact@awardshub.com</p>
                    <p class="text-gray-600">+1 (555) 123-4567</p>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">To:</h2>
                    <p class="font-semibold">Sarah Johnson</p>
                    <p class="text-gray-600">TechInnovate Inc.</p>
                    <p class="text-gray-600">456 Business Ave</p>
                    <p class="text-gray-600">San Francisco, CA 94105</p>
                    <p class="text-gray-600">sarah@techinnovate.com</p>
                </div>
            </div>

            <!-- Invoice Details -->
            <div class="border border-gray-200 rounded-lg overflow-hidden mb-8">
                <table class="">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Category</th>
                            <th class="text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <p class="font-medium">Innovation Excellence Award Application Fee</p>
                                <p class="text-sm text-gray-500">Application ID: APP-2023-0621</p>
                            </td>
                            <td class="text-gray-600">Technology & Innovation</td>
                            <td class="text-right font-medium">$249.00</td>
                        </tr>
                        <tr>
                            <td>
                                <p class="font-medium">Processing Fee</p>
                                <p class="text-sm text-gray-500">Transaction processing</p>
                            </td>
                            <td class="text-gray-600">Fees</td>
                            <td class="text-right font-medium">$5.95</td>
                        </tr>
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="2" class="text-right font-medium text-gray-700 pr-4">Subtotal:</td>
                            <td class="text-right font-medium">$254.95</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-right font-medium text-gray-700 pr-4">Tax (8.5%):</td>
                            <td class="text-right font-medium">$21.67</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-right font-semibold text-gray-900 text-lg pr-4">Total:</td>
                            <td class="text-right font-semibold text-lg">$276.62</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Payment Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Payment Information</h2>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-gray-600">Payment Method:</span>
                            <span class="font-medium">Credit Card</span>
                        </div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-gray-600">Card Number:</span>
                            <span class="font-medium">**** **** **** 1234</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Transaction ID:</span>
                            <span class="font-medium">TXN-789456123</span>
                        </div>
                    </div>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Important Dates</h2>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-gray-600">Invoice Date:</span>
                            <span class="font-medium">June 19, 2023</span>
                        </div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-gray-600">Due Date:</span>
                            <span class="font-medium">June 26, 2023</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Payment Date:</span>
                            <span class="font-medium">June 19, 2023</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Notes</h2>
                <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-100">
                    <p class="text-gray-700">Thank you for your business. Payment is due within 7 days of invoice date. Please include the invoice number in your payment reference.</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-wrap gap-3 justify-end pt-6 border-t border-gray-200 no-print">
                <button class="p-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200">
                    <i class="fas fa-download mr-2"></i>
                    Download PDF
                </button>
                <button class="p-2 rounded-lg bg-indigo-100 text-indigo-700 hover:bg-indigo-200">
                    <i class="fas fa-envelope mr-2"></i>
                    Send Email
                </button>
                <button onclick="window.print()" class="p-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                    <i class="fas fa-print mr-2"></i>
                    Print Invoice
                </button>
            </div>
        </div>
@endsection