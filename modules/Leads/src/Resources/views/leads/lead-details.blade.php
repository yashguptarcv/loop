@extends('admin::layouts.app')

@section('title', 'Lead Detail')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header with back button -->
   @include('admin::components.common.back-button', ['route' => route('admin.leads.index'), 'name' => 'Lead Detail / '.$lead->name.' / '.$lead->created_at ])

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