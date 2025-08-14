@extends('admin::layouts.app')

@section('title',  isset($lead) ? 'Edit Lead Status' : 'Create Lead Status')

@section('content')
    

        @include('admin::components.common.back-button', ['route' => route('admin.settings.statuses.leads.index'), 'name' =>  isset($lead) ? 'Edit lead status' : 'Create lead status'])

        <form id="lead-form" method="POST"
            action="{{ isset($lead) ? route('admin.settings.statuses.leads.update', $lead->id) : route('admin.settings.statuses.leads.store') }}"
            class="form-ajax grid grid-cols-1 lg:grid-cols-3 gap-6">
            @csrf
            @if(isset($lead))
                @method('PUT')
            @endif

            <input type="hidden" name="id" id="lead_id" value="{{ $lead->id ?? '' }}">

            
        </form>
    
@endsection

@section('scripts')
    
@endsection