@extends('admin::layouts.app')

@section('title', 'Lead Detail')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header with back button -->
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.leads.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Lead Details</h1>
        <div class="ml-auto flex space-x-2">
            <a href="{{ route('admin.leads.create', $lead) }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100">
                Edit
            </a>
            <form action="{{ route('admin.leads.index', $lead) }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Convert to Customer
                </button>
            </form>
        </div>
    </div>

    <!-- Main content area -->
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Left side - Lead details -->
        @include('leads::leads.components.details-left')

        <!-- Right side - Activity tabs -->
         @include('leads::leads.components.details-right')
       
    </div>
@endsection

@push('scripts')
<script>
    // Tab switching functionality
    function switchTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.remove('active');
        });
        
        // Show selected tab content
        document.getElementById(`${tabName}-tab`).classList.add('active');
        
        // Update tab button styles
        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('border-blue-500', 'text-blue-600');
            button.classList.add('border-transparent', 'text-gray-500');
        });
        
        // Highlight active tab button
        event.currentTarget.classList.add('border-blue-500', 'text-blue-600');
        event.currentTarget.classList.remove('border-transparent', 'text-gray-500');
    }
</script>
@endpush