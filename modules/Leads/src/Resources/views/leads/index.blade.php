
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
    .leads {
        display: flex;
        overflow-x: auto;
        gap: 16px;
        padding-bottom: 16px;
    }
</style>
@endsection

@section('content')
    <div class="flex justify-between items-center mb-8">    
        @include('admin::components.common.back-button', ['route' => '', 'name' => 'Lead Management'])
        
        <div class="flex space-x-4">
            <!-- Search Box -->            
            <input type="text" id="lead-search" placeholder="Search leads..." 
                    class="pl-6 pr-4 py-2 border rounded-lg border-blue-600 text-blue-600 focus:ring-blue-500 focus:border-blue-500">
            <!-- Date Sort Dropdown -->
            <select id="sort-date" class="border rounded-lg px-4 py-2 border-blue-600 text-blue-600 focus:ring-blue-500 focus:border-blue-500">
                <option value="desc">Newest First</option>
                <option value="asc">Oldest First</option>
            </select>
            
            @if(bouncer()->hasPermission('admin.leads.create'))
            <a href="{{route('admin.leads.create')}}" class="inline-flex items-center px-4 py-2 border rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 hover:text-blue-300 text-blue-600 bg-blue-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Add Lead
            </a>
            @endif
        </div>
    </div>

    <div class="leads" id="leads">
        @foreach($lead_statuses as $status)
        <div class="bg-white rounded-lg shadow p-4 status-column" id="status-{{ $status->id }}-column">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-700">{{ $status->name }}</h2>
                <span class="bg-{{ $status->color }}-100 text-{{ $status->color }}-800 text-xs font-medium px-2.5 py-0.5 rounded-full status-count">
                    {{ $leads->where('status_id', $status->id)->count() }}
                </span>
            </div>
            <div id="status-{{ $status->id }}-leads" class="space-y-3 overflow-y-auto h-[calc(100%-40px)]">
                @include('leads::leads.components.leads_list', ['leads' => $leads->where('status_id', $status->id)])
            </div>
        </div>
        @endforeach
    </div>
    
    <div id="loading-spinner" class="hidden text-center py-4">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-blue-500 border-t-transparent"></div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize variables
    let isLoading = false;
    let nextPageUrl = '{{ $leads->nextPageUrl() }}';
    let currentParams = {
        search: '',
        sort_date: 'desc'
    };
    
    // Initialize SortableJS for each status column
    function initializeSortables() {
        @foreach($lead_statuses as $status)
        var sortableEl = document.getElementById('status-{{ $status->id }}-leads');
        if (sortableEl && !sortableEl.sortableInstance) {
            sortableEl.sortableInstance = new Sortable(sortableEl, {
                group: 'leads',
                animation: 150,
                ghostClass: 'bg-{{ $status->color }}-50',
                onEnd: function(evt) {
                    updateLeadStatus(evt.item.dataset.leadId, evt.to.id.replace('status-', '').replace('-leads', ''));
                }
            });
        }
        @endforeach
    }
    initializeSortables();
    
    // Infinite scroll implementation
    function setupInfiniteScroll() {
        const scrollableColumns = document.querySelectorAll('.status-column > div:last-child');
        
        scrollableColumns.forEach(column => {
            column.addEventListener('scroll', function() {
                if (isLoading || !nextPageUrl) return;
                
                // Check if scrolled to bottom (with 100px threshold)
                if (this.scrollTop + this.clientHeight >= this.scrollHeight - 100) {
                    // loadMoreLeads();
                }
            });
        });
    }
    setupInfiniteScroll();
    
    // Search functionality with debounce
    const searchInput = document.getElementById('lead-search');
    let searchTimer;
    
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function() {
            currentParams.search = searchInput.value;
            resetAndFetchLeads();
        });
    });
    
    // Date sorting
    document.getElementById('sort-date').addEventListener('change', function() {
        currentParams.sort_date = this.value;
        resetAndFetchLeads();
    });
    
    // Reset pagination and fetch fresh results
    function resetAndFetchLeads() {
        nextPageUrl = '{{ route("admin.leads.index") }}?' + new URLSearchParams(currentParams).toString();
        // fetchLeads(true);
    }
    
    // Function to update lead status
    function updateLeadStatus(leadId, newStatusId) {
        ceAjax('POST', '{{ route("admin.leads.update-status") }}', {
            loader: true,
            data: {
                lead_id: leadId,
                status_id: newStatusId
            },
            result_ids: Array.from(document.querySelectorAll('[id^="status-"]')).map(el => el.id).join(','),
            callback: function(data) {
                if (data.success) {
                    showToast("Lead status changed", 'success', 'Success');
                    updateStatusCounts();
                }
            },
            errorCallback: function(xhr) {
                showToast('Error updating lead status', 'error', 'Error');
            }
        });
    }
    
    // Function to update all status counts
    function updateStatusCounts() {
        document.querySelectorAll('.status-count').forEach(el => {
            const statusId = el.closest('[id^="status-"]').id.replace('status-', '').replace('-column', '');
            const count = document.getElementById(`status-${statusId}-leads`).children.length;
            el.textContent = count;
        });
    }
    
    // Function to load more leads
    function loadMoreLeads() {
        if (!nextPageUrl) return;
        
        ceAjax('GET', nextPageUrl, {
            loader: true,
            result_ids: Array.from(document.querySelectorAll('[id^="status-"]')).map(el => el.id).join(','),
            beforeSend: function() {
                isLoading = true;
            },
            callback: function(data) {
                if (data.success) {
                    nextPageUrl = data.next_page;
                    initializeSortables();
                    updateStatusCounts();
                }
            },
            errorCallback: function(xhr) {
                showToast('Error loading more leads', 'error', 'Error');
            },
            complete: function() {
                isLoading = false;
            }
        });
    }
    
    // Function to fetch leads with search and sort
    function fetchLeads(resetPagination = false) {
        const url = resetPagination ? 
            '{{ route('admin.leads.index') }}?' + new URLSearchParams(currentParams).toString() : 
            nextPageUrl;
        
        ceAjax('GET', url, {
            loader: true,
            result_ids: Array.from(document.querySelectorAll('[id^="status-"]')).map(el => el.id).join(','),
            beforeSend: function() {
                isLoading = true;
            },
            callback: function(data) {
                if (data.success) {
                    nextPageUrl = data.next_page;
                    initializeSortables();
                    updateStatusCounts();
                    
                    // Reset scroll position if it's a new search/sort
                    if (resetPagination) {
                        document.querySelectorAll('.status-column > div:last-child').forEach(el => {
                            el.scrollTop = 0;
                        });
                    }
                }
            },
            errorCallback: function(xhr) {
                showToast('Error loading leads', 'error', 'Error');
            },
            complete: function() {
                isLoading = false;
            }
        });
    }
});
</script>
@endsection