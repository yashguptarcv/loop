@extends('admin::layouts.app')

@section('title', 'Leads')

@section('styles')
<style>
    .lead-card {
        transition: all 0.2s ease;
    }
    .lead-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    .status-column {
        min-width: 300px;
        height: calc(100vh - 180px);
    }
    .leads-container {
        display: flex;
        overflow-x: auto;
        gap: 16px;
        padding-bottom: 16px;
    }
    .leads-container::-webkit-scrollbar {
        height: 8px;
    }
    .leads-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    .leads-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 4px;
    }
    .leads-container::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
</style>
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    
    <div class="flex justify-between items-center mb-8">    
        @include('admin::components.common.back-button', ['route' => '', 'name' => 'Lead Managment'])
        
        @if(bouncer()->hasPermission('admin.leads.create'))
        <a href="{{route('admin.leads.create')}}" class="bg-[var(--color-hover)] text-[var(--color-text-inverted)] px-4 py-2 rounded-lg flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Add Lead
        </a>
        @endif
    </div>

    <div class="leads-container">
        @foreach($lead_statuses as $status)
        <div class="bg-white rounded-lg shadow p-4 status-column" id="status-{{ $status->id }}-column">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-700">{{ $status->name }}</h2>
                <span class="bg-{{ $status->color }}-100 text-{{ $status->color }}-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    {{ $leads->where('status_id', $status->id)->count() }}
                </span>
            </div>
            <div id="status-{{ $status->id }}-leads" class="space-y-3 overflow-y-auto h-[calc(100%-40px)]">
                @foreach($leads->where('status_id', $status->id) as $lead)
                <div class="lead-card bg-white border border-gray-200 rounded-lg p-4 cursor-move" 
                     draggable="true" data-lead-id="{{ $lead->id }}">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-medium text-gray-900">
                            @if(bouncer()->hasPermission('admin.leads.details'))    
                                <a href="{{route('admin.leads.details', $lead->id)}}">{{ $lead->name }}</a>
                            @else
                                <a href="#">{{ $lead->name }}</a>
                            @endif
                        </h3>
                        <span class="text-xs text-gray-500">{{ $lead->created_at->diffForHumans() }}</span>
                    </div>
                   <div class="mt-2">
                    
                        <div class="flex flex-wrap gap-1">
                            @foreach($lead->tags as $tag)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                        @if($tag->color) bg-{{ $tag->color }}-100 text-{{ $tag->color }}-800 
                                        dark:bg-{{ $tag->color }}-900 dark:text-{{ $tag->color }}-200
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                                    {{ $tag->name }}                                   
                                </span>
                            @endforeach
                        </div>
                    
                </div>
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-gray-500">
                        <div class="">
                            <span class="mr-2">
                            {{ $lead->createdBy->name ?? 'Unknown' }}
                            </span>
                        </div>
                        <br>
                        
                        @if($lead->email)
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="truncate max-w-[180px]">{{ $lead->email }}</span>
                        </div>
                        @endif
                        
                        @if($lead->phone)
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            {{ $lead->phone }}
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize SortableJS for each status column
    @foreach($lead_statuses as $status)
    new Sortable(document.getElementById('status-{{ $status->id }}-leads'), {
        group: 'leads',
        animation: 150,
        ghostClass: 'bg-{{ $status->color }}-50',
        onEnd: function(evt) {
            updateLeadStatus(evt.item.dataset.leadId, evt.to.id.replace('status-', '').replace('-leads', ''));
        }
    });
    @endforeach

    // Function to update lead status via AJAX
    function updateLeadStatus(leadId, newStatusId) {
        fetch('{{ route("admin.leads.update-status") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                lead_id: leadId,
                status_id: newStatusId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update counts in UI
                @foreach($lead_statuses as $status)
                const {{ Str::camel($status->name) }}Count = document.getElementById('status-{{ $status->id }}-leads').children.length;
                document.querySelector('#status-{{ $status->id }}-column span').textContent = {{ Str::camel($status->name) }}Count;
                @endforeach
            } else {
                console.error('Error updating lead status:', data.message);
                // Optionally revert the UI change
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
});
</script>
@endsection