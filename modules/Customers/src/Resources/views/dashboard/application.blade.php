@extends('customers::dashboard.layouts.app')

@section('title', 'My Applications')
@section('content')

<div>
    <div class="md:flex md:items-center md:justify-between mb-6">
        @include('customers::dashboard.common.info', ['title' => 'My Applications', 'text' => 'View and manage all your award applications.'])

        <div class="mt-4 flex md:mt-0 md:ml-4">
            <div class="relative rounded-md shadow-sm">
                <input type="text" name="search" id="search" class="py-2 px-4 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm  dark:border-gray-600 dark:text-white" placeholder="Search applications">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- Filters -->
    <div class="bg-white shadow-sm rounded-lg p-4 mb-6">
        <form method="GET" action="{{ route('customer.applications') }}" class="flex flex-col md:flex-row md:items-center justify-between gap-4">

            <div class="flex flex-wrap items-center gap-2">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Filter by:</span>
                <a href="{{ route('customer.applications') }}" class="px-3 py-1.5 rounded-full text-xs font-medium {{ !request('status') ? 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/20 dark:text-indigo-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400' }}">All</a>
                <a href="{{ route('customer.applications', ['status' => 'pending']) }}" class="px-3 py-1.5 rounded-full text-xs font-medium {{ request('status') == 'pending' ? 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400' }}">Pending</a>
                <a href="{{ route('customer.applications', ['status' => 'in_review']) }}" class="px-3 py-1.5 rounded-full text-xs font-medium {{ request('status') == 'in_review' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400' }}">In Review</a>
                <a href="{{ route('customer.applications', ['status' => 'approved']) }}" class="px-3 py-1.5 rounded-full text-xs font-medium {{ request('status') == 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400' }}">Approved</a>
                <a href="{{ route('customer.applications', ['status' => 'rejected']) }}" class="px-3 py-1.5 rounded-full text-xs font-medium {{ request('status') == 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400' }}">Rejected</a>
            </div>
        </form>
    </div>

    <!-- Applications List -->
    <div class="grid grid-cols-1 gap-5">
        @if(isset($applications) && $applications->count() > 0)
        @foreach($applications as $application)

        @php 
            $status = [];
        @endphp
        @if($application->order?->status)
            @php
                $status = fn_get_order_status($application->order?->status);
            @endphp
        @endif
        <!-- Application Card 1 -->
        <div class="bg-white application-card rounded-lg shadow card-hover p-6 cursor-pointer ">
            <div class="flex items-start justify-between">
                <div>
                    <div class="flex gap-4">
                        @if(!empty($application->product_names))
                            <p class=" font-medium text-gray-900">
                                {{ $application->product_names }}
                            </p>
                        @endif
                    </div>
                    <p class="text-sm text-gray-500 mt-1 dark:text-gray-400">
                        {{ $application->created_at->format('M d, Y') }}
                    </p>
                </div>
                <div class="flex">
                    <div class="flex-item">
                        <a href="{{ route('customer.application.detail', $application->id) }}" class="text-sm text-gray-600 mt-1">
                            Nomination ID #{{ $application->id }}
                        </a>
                    </div>&nbsp; / &nbsp; 
                    <p class="text-gray-700">{!! $application->full_name !!}</p>
                    @if(!empty($status))
                    &nbsp;/&nbsp;
                    <div class="">                        
                        <span class="bg-{{$status->color}}-100 text-{{$status->color}}-500 rounded-lg px-1 py-1">
                            {{ $status->name }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>
            <div class="mt-4">
                <div class="flex justify-between text-sm text-gray-500 mb-1 dark:text-gray-400">
                    <span>Progress</span>
                    <span>{{ round($application->progress) }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                    <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $application->progress }}%"></div>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-gray-500 dark:text-gray-400">
                @if(!empty($status) && ($status->status != fn_get_setting('general.order.complete')))
                    <a href="{{ route('checkout.nomination', ['application_id' => $application->id, 'order_id' => $application->order->id]) }}" class="text-sm text-gray-600 mt-1">
                        Proceed to checkout
                    </a>
                @else                
                    <i class="fas {{ $application->progress >= 100 ? 'fa-check-circle text-green-500' : 'fa-clock' }} mr-2"></i>
                    <span>Application Completed</span>
                @endif
            </div>
        </div>
        @endforeach
        @else
        asdas
        <div class="bg-white application-card rounded-lg shadow card-hover p-6 cursor-pointer ">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">No Applications available.</h3>
                </div>
                <span class="status-badge bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400"></span>
            </div>

        </div>
        @endif

    </div>
</div>

@endsection