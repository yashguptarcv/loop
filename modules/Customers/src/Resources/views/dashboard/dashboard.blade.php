@extends('customers::dashboard.layouts.app')

@section('title','Dashboard')

@section('content')

<!-- Dashboard Page -->
<div id="dashboard-page" class="page active">
    <!-- Header -->

    <!-- info -->
    <div class="md:flex md:items-center md:justify-between mb-6">
        @include('customers::dashboard.common.info', ['title' => 'Dashboard'])
    </div>

    <!-- Stats Section -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <!-- Total Applications -->
        <div class="stat-card overflow-hidden card-hover">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-100 rounded-md p-3 dark:bg-indigo-900/20">
                        <i class="fas fa-file-alt text-indigo-600 text-xl dark:text-indigo-400"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate dark:text-gray-400">Total Applications</dt>
                            <dd>
                                <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $totalApplications }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Approved Orders -->
        <div class="stat-card overflow-hidden card-hover">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 rounded-md p-3 dark:bg-green-900/20">
                        <i class="fas fa-check-circle text-green-600 text-xl dark:text-green-400"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate dark:text-gray-400">Approved</dt>
                            <dd>
                                <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $approvedOrders }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- In Review Applications -->
        <div class="stat-card overflow-hidden card-hover">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3 dark:bg-yellow-900/20">
                        <i class="fas fa-clock text-yellow-600 text-xl dark:text-yellow-400"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate dark:text-gray-400">In Review</dt>
                            <dd>
                                <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $inReviewApplications }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rejected Orders -->
        <div class="stat-card overflow-hidden card-hover">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-red-100 rounded-md p-3 dark:bg-red-900/20">
                        <i class="fas fa-times-circle text-red-600 text-xl dark:text-red-400"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate dark:text-gray-400">Rejected</dt>
                            <dd>
                                <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $rejectedOrders }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Application Progress -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow rounded-lg card-hover ">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Application Progress</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">Your current application status and next steps.</p>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6 dark:border-gray-700">
                    @if($latestApplication)
                    <div class="flex gap-4 mb-1">
                        <h4 class="text-md font-medium text-gray-900 dark:text-white">
                            @if(!empty($latestApplication->product_names))
                            {{ $latestApplication->product_names }}
                            @endif
                        </h4>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                            Application #{{ $latestApplication->id }}
                        </p>
                    </div>
                    <p class="mb-1 text-gray-700">{!! $latestApplication->full_name !!}</p>

                    <div class="mb-2 flex justify-between mt-4">
                        <span class="text-xs font-medium text-gray-600 dark:text-gray-400">Progress</span>
                        <span class="text-xs font-medium text-gray-600 dark:text-gray-400">{{ $progressPercentage }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                        <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $progressPercentage }}%"></div>
                    </div>

                    <div class="mt-6 space-y-4">
                        @foreach($progressSteps as $step)
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-6 w-6 rounded-full {{ $step['completed'] ? 'bg-indigo-600' : 'bg-gray-300 dark:bg-gray-600' }} flex items-center justify-center">
                                @if($step['completed'])
                                <i class="fas fa-{{ $step['icon'] }} text-white text-xs"></i>
                                @else
                                <i class="fas fa-{{ $step['icon'] }} text-{{ $step['completed'] ? 'white' : 'gray-500 dark:text-gray-400' }} text-xs"></i>
                                @endif
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium {{ $step['completed'] ? 'text-gray-900' : 'text-gray-500' }} dark:text-white">
                                    {{ $step['name'] }}
                                </p>
                                <p class="text-xs {{ $step['completed'] ? 'text-indigo-600' : 'text-gray-500' }} dark:text-gray-400">
                                    {{ $step['date'] }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-4">
                        <p class="text-gray-500 dark:text-gray-400">No active applications found.</p>
                        <a href="{{ route('customer.applications') }}" class="mt-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Start New Application
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Applications -->
        <div class="lg:col-span-1">
            <div class="bg-white shadow rounded-lg card-hover ">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Recent Applications</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">Your most recent award applications.</p>
                </div>
                <div class="border-t border-gray-200 dark:border-gray-700">
                    @if($recentApplications->isEmpty())
                    <div class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                        No applications found.
                    </div>
                    @else
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($recentApplications as $application)
                        @php
                        $order = $application->order;
                        $statusClass = 'bg-yellow-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400';
                        $statusText = 'In Review';

                        if ($order) {
                        if (in_array($order->payment_status, ['paid', 'completed'])) {
                        $statusClass = 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400';
                        $statusText = 'Approved';
                        } elseif (in_array($order->status, ['cancelled', 'declined'])) {
                        $statusClass = 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400';
                        $statusText = ucfirst($order->status);
                        }
                        }
                        @endphp
                        <li class="px-4 py-4 sm:px-6 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-150">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="flex flex-col">
                                        <p class="font-medium text-gray-900">
                                            @if($application->order && $application->order->items->isNotEmpty())
                                            @php
                                            $productNames = $application->order->items->pluck('product_name')->filter()->unique()->implode(', ');
                                            @endphp
                                            @if($productNames)
                                            {{ $productNames }}
                                        </p>
                                        @endif
                                        @endif
                                        <p class="text-sm text-gray-500">Application ID #{{ $application->id }}</p>
                                        </p>
                                    </div>
                                    <p class="text-gray-700">{!! $application->full_name !!}</p>
                                </div>

                                <div class="ml-2 flex-shrink-0 flex">
                                    <span class="status-badge {{ $statusClass }} ">
                                        {{ $statusText }}
                                    </span>
                                </div>
                            </div>
                            <div class="mt-2 sm:flex sm:justify-between">
                                <div class="sm:flex">
                                    <p class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-calendar-alt mr-1.5 text-gray-400 text-xs dark:text-gray-500"></i>
                                        Submitted {{ $application->created_at->format('F j, Y') }}
                                    </p>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection