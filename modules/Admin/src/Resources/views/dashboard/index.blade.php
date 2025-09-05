@extends('admin::layouts.app')

@section('page_title') Dashboard @endsection
@section('content')

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Dashboard Overview</h1>
            <p class="text-gray-600">Welcome back, Admin! Here's what's happening with your business today.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <div class="relative">
                <select class="block appearance-none bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-lg leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option>Last 7 days</option>
                    <option>Last 30 days</option>
                    <option>This Month</option>
                    <option>Last Month</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {!! event(new \Modules\Widgets\Events\RenderWidgets(auth('admin')->user()))[0] ?? '' !!}
    </div>
@endsection

@section('scripts')
<script>
    // You would typically initialize charts here with a library like Chart.js
    // For example:
    // const revenueChart = new Chart(document.getElementById('revenue-chart'), { ... });
    
    document.addEventListener('DOMContentLoaded', function() {
        // Dashboard scripts would go here
        console.log('Dashboard loaded');
    });
</script>
@endsection