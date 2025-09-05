@extends('customers::dashboard.layouts.app')

@section('title', 'Application Details')
@section('content')

<div>
    <div class="mb-6">
        <a href="{{ route('customer.applications') }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Applications
        </a>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                        @if($application->order && $application->order->items->isNotEmpty())
                        {{ $application->order->items->first()->product_name }}
                        @else
                        Application Details
                        @endif
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">Application ID: {{ $application->id }}</p>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                    {{ ucfirst($status) }}
                </span>
            </div>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <div class="flex justify-between">
                <div class="w-1/2">
                    <!-- Application information -->
                    <div class="lg:col-span-2">
                        <h4 class="text-md font-medium text-gray-900 mb-4 dark:text-white">Application Information</h4>
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Application ID</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $application->id }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Submitted on</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $application->created_at->format('F j, Y') }}</dd>
                            </div>
                            @if($application->order && $application->order->items->isNotEmpty())
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Award Package</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $application->order->items->first()->product_name }}
                                </dd>
                            </div>
                            @endif
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Payment Status</dt>
                                <dd class="mt-1 text-sm">
                                    @if($paymentStatus === 'paid')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">Paid</span>
                                    @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400">Pending</span>
                                    @endif
                                </dd>
                            </div>
                            @if($application->organization)
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Organization</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $application->organization }}</dd>
                            </div>
                            @endif
                            @if($application->designation)
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Designation</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $application->designation }}</dd>
                            </div>
                            @endif
                            
                        </dl>

                    </div>

                    <!-- Application invoice document  -->
                    <div class="mt-28">
                        <h4 class="text-md font-medium text-gray-900 mb-4 dark:text-white">Submitted Documents</h4>
                        <ul class="border border-gray-200 rounded-md divide-y divide-gray-200 dark:border-gray-700 dark:divide-gray-700">
                            <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                <div class="w-0 flex-1 flex items-center">
                                    <i class="fas fa-file-pdf text-red-500 flex-shrink-0 mr-2"></i>
                                    <span class="ml-2 flex-1 w-0 truncate dark:text-white">project_proposal.pdf</span>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">Download</a>
                                </div>
                            </li>
                            <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                <div class="w-0 flex-1 flex items-center">
                                    <i class="fas fa-file-word text-blue-500 flex-shrink-0 mr-2"></i>
                                    <span class="ml-2 flex-1 w-0 truncate dark:text-white">supporting_docs.docx</span>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">Download</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Application timeline  -->
                <div class="w-1/2 ml-32">
                    <h4 class="text-md font-medium text-gray-900 mb-4 dark:text-white">Application Timeline</h4>
                    <div class="">
                        @foreach($timeline as $index => $item)
                        <div class="relative pl-8 pb-8 {{ !$loop->last ? 'border-l-2 border-gray-200 dark:border-gray-700' : '' }}">
                            <!-- Timeline dot -->
                            <div class="absolute w-4 h-4 rounded-full -left-2 top-1 border-2 border-white dark:border-gray-800
                                @if(isset($item['completed']) && $item['completed']) 
                                    bg-green-500
                                @elseif(isset($item['current']) && $item['current'])
                                    bg-indigo-500
                                @else
                                    bg-gray-300 dark:bg-gray-600
                                @endif">
                            </div>
                            
                            <!-- Timeline content -->
                            <div class="ml-2">
                                <h5 class="text-sm font-medium 
                                    @if(isset($item['current']) && $item['current'])
                                        text-indigo-600 dark:text-indigo-400
                                    @elseif(isset($item['completed']) && $item['completed'])
                                        text-green-600 dark:text-green-400
                                    @else
                                        text-gray-500 dark:text-gray-400
                                    @endif">
                                    {{ $item['title'] }}
                                </h5>
                                <p class="text-xs mt-1">{{ $item['date'] }}</p>
                                @if(isset($item['description']))
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $item['description'] }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-8">
                        <h4 class="text-md font-medium text-gray-900 mb-4 dark:text-white">Need Help?</h4>
                        <div class="bg-gray-50 rounded-lg p-4 dark:bg-slate-700">
                            <p class="text-sm text-gray-500 dark:text-gray-300">If you have any questions about your application, contact our support team.</p>
                            <button class="mt-3 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none dark:bg-slate-600 dark:text-white dark:border-gray-600 dark:hover:bg-slate-500">
                                <i class="fas fa-envelope mr-2 text-gray-400"></i>
                                Contact Support
                            </button>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

@endsection