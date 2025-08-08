@extends('admin::layouts.app')

@section('title', isset($lead) ? 'Edit Lead' : 'Create Lead')

@section('styles')
@endsection
@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.leads.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>&nbsp;&nbsp;&nbsp;
        <h1 class="text-2xl font-bold text-gray-800">{{ isset($lead) ? 'Edit Lead' : 'Create New Lead' }}</h1>
        
    </div>

    <form class="form-ajax grid grid-cols-1 gap-6"method="POST" action="{{ isset($lead) ? route('admin.leads.update', $lead->id) : route('admin.leads.store') }}">
        @csrf
        @if(isset($lead))
            @method('PUT')
        @endif

        <!-- Personal Information Section -->
        @include('leads::leads.components.form.personal')

        <!-- Company Information Section -->
        @include('leads::leads.components.form.company')

        <!-- Contact Information Section -->
        @include('leads::leads.components.form.contact')

        <!-- Lead Details Section -->
        @include('leads::leads.components.form.lead')       

        <!-- Address Information Section -->
        @include('leads::leads.components.form.address')

        <!-- Additional Information Section -->
        @include('leads::leads.components.form.additional_info')

        <!-- Form Actions -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-2">

                 <div class="mt-8 flex justify-start space-x-3">
                    <button type="submit" name="button"
                            class="btn btn-primary px-4 py-2">
                        {{ isset($lead) ? 'Update Lead' : 'Create Lead' }}
                    </button>
                </div>
            
        </div>
    </form>
</div>
@endsection
@section('scripts')

@endsection