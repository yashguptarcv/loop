@extends('admin::layouts.app')

@section('title', 'Customers')

@section('content')

@include('admin::components.common.back-button', ['route' => route('admin.customers.index'), 'name' => isset($customer) ? 'Customer ID #'.$customer->id . ' / '. $customer->name . ' / ' . fn_get_currency($customer->getOrderTotal()) : 'New Customer'])

@include('customers::customers.components.info_bar')

@php
    $activeTab = $activeTab ?? 'overview';
@endphp

<!-- Tab Navigation -->
<div class="border-b divide-gray-100 mb-6">
    <nav class="-mb-px flex space-x-8">
        <a href="{{ route('admin.customers.show', $customer) }}" 
           class="{{ $activeTab === 'overview' ? 'border-primary-100 text-primary-100' : 'border-transparent text-gray-500 hover:text-primary-100 hover:border-primary-100' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            Overview
        </a>

        <a href="{{ route('admin.customers.orders', $customer) }}" 
           class="{{ $activeTab === 'orders' ? 'border-primary-100 text-primary-100' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            Orders
        </a>

        <a href="{{ route('admin.customers.transactions', $customer) }}" 
           class="{{ $activeTab === 'transactions' ? 'border-primary-100 text-primary-100' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-primary-100' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            Transactions
        </a>
        
        <a href="{{ route('admin.customers.application', $customer) }}" 
            class="{{ $activeTab === 'application' ? 'border-primary-100 text-primary-100' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-primary-100' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            Application
        </a>

        <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            Activity
        </a>
    </nav>
</div>

<!-- Tab Content -->
<div id="customer_tab" class="tab-content customer-details active space-y-4">
    @if($activeTab === 'overview')
        @include('customers::customers.components.overview')
    @elseif($activeTab === 'orders')
        @include('customers::customers.components.orders')
    @elseif($activeTab === 'transactions')
        @include('customers::customers.components.transactions')
    @elseif($activeTab === 'lead')
        @include('customers::customers.components.lead-details')
    @elseif($activeTab === 'application')
        @include('customers::customers.components.application')
    @else
        @include('customers::customers.components.overview')
    @endif
</div>

@endsection