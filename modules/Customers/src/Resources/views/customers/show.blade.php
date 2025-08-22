@extends('admin::layouts.app')

@section('title', 'Customers')

@section('content')

@include('admin::components.common.back-button', ['route' => route('admin.customers.index'), 'name' => isset($customer) ? 'Customer ID #'.$customer->id : 'New Customer'])

@include('customers::customers.components.info_bar')

<!-- Tab Navigation -->
<div class="border-b border-gray-200 mb-6">
    <nav class="-mb-px flex space-x-8">
        <a href="#" class="border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            Overview
        </a>

        <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            Orders
        </a>

        <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            Transactions
        </a>

        <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            Lead Details
        </a>

        <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            Activity
        </a>
    </nav>
</div>


<div id="customer_tab" class="tab-content customer-details active space-y-4">
@include('customers::customers.components.overview')
</div>



@endsection