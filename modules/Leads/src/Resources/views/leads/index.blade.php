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
        display: flex;
        flex-direction: column;
    }

    .leads {
        display: flex;
        overflow-x: auto;
        gap: 16px;
        padding-bottom: 16px;
    }

    .lead-list {
        flex: 1;
        overflow-y: auto;
    }

    .leads-wrapper {
        position: relative;
    }

    .scroll-btn.left {
        left: 5px;
    }

    .scroll-btn.right {
        right: 5px;
    }
</style>
@endsection

@section('content')
<div class="flex justify-between items-center mb-8">
    @include('admin::components.common.back-button', ['route' => '', 'name' => 'Lead Management'])

    <div class="flex space-x-4">
        <!-- Search Box -->
        <input type="text" id="lead-search" placeholder="Search leads..."
            class="pl-6 pr-4 py-2 border rounded-lg border-primary-100 text-primary-100 focus:ring-primary-100 focus:border-primary-100">
        <!-- Date Sort Dropdown -->
        <select id="filter-assigned-to" class="border rounded-lg px-4 py-2 border-primary-100 text-primary-100 focus:ring-blue-500 focus:border-primary-100" name="assigned_to">
            <option value="">All</option>
            @foreach (fn_get_usergroups() as $role)
            <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
        </select>

        <select id="filter-source" class="border rounded-lg px-4 py-2 border-primary-100 text-primary-100 focus:ring-blue-500 focus:border-primary-100" name="source">
            <option value="">All</option>
            @foreach (fn_get_lead_sources() as $source)
            <option value="{{ $source->id }}">{{ $source->name }}</option>
            @endforeach
        </select>
        <select id="sort-date" class="border rounded-lg px-4 py-2 border-primary-100 text-primary-100 focus:ring-blue-500 focus:border-primary-100">
            <option value="desc">Newest First</option>
            <option value="asc">Oldest First</option>
        </select>

        @if(bouncer()->hasPermission('admin.leads.create'))
        <a href="{{route('admin.leads.create')}}" class="inline-flex items-center px-4 py-2 border rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 hover:text-amber-200 text-amber-100 bg-primary-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Add Lead
        </a>
        @endif
    </div>
</div>

<div class="leads-wrapper relative">
    <div class="leads" id="leads">
        @foreach($lead_statuses as $status)
        <div class="bg-white rounded-lg shadow p-4 status-column" id="status-{{ $status->id }}-column">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-700">{{ $status->name }}</h2>
                <span class="bg-{{ $status->color }}-100 text-{{ $status->color }}-800 text-xs font-medium px-2.5 py-0.5 rounded-full status-count">
                    {{ $leads->where('status_id', $status->id)->count() }}
                </span>
            </div>
            <div id="status-{{ $status->id }}-leads"
                class="lead-list space-y-3"
                data-status-id="{{ $status->id }}"
                data-next-page="{{ $leads->nextPageUrl() }}">
                @include('leads::leads.components.leads_list', ['leads' => $leads->where('status_id', $status->id)])
            </div>
        </div>
        @endforeach
    </div>

    <!-- Scroll Buttons -->
    <button id="scroll-left"
        class="absolute w-8 h-8 top-1/2 -translate-y-1/2 left-1 z-50 bg-primary-100 text-amber-100 rounded-full p-1 hover:text-amber-200 focus:outline-none shadow-lg">
        <span class="material-icons-outlined ml-0.5 mt-0.5 text-sm font-bold">arrow_back_ios</span>
    </button>
    <button id="scroll-right"
        class="absolute w-8 h-8 top-1/2 -translate-y-1/2 right-1 z-50 bg-primary-100 text-amber-100 rounded-full p-1 hover:text-amber-200 focus:outline-none shadow-lg">
        <span class="material-icons-outlined ml-0.5 mt-0.5 text-sm font-bold">arrow_forward_ios</span>

    </button>
</div>



@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        let currentParams = {
            search: '',
            sort_date: 'desc'
        };

        function initSortables() {
            document.querySelectorAll('.lead-list').forEach(el => {
                if (!el.sortableInstance) {
                    el.sortableInstance = new Sortable(el, {
                        group: 'leads',
                        animation: 150,
                        ghostClass: 'bg-gray-100',
                        onEnd: evt => {
                            let newStatus = evt.to.dataset.statusId;
                            updateLeadStatus(evt.item.dataset.leadId, newStatus);
                        }
                    });
                }
            });
        }
        initSortables();

        document.querySelectorAll('.lead-list').forEach(list => {
            list.addEventListener('scroll', function() {
                if (this.scrollTop + this.clientHeight >= this.scrollHeight - 80) {
                    loadMoreLeads(this);
                }
            });
        });

        function loadMoreLeads(container) {
            if (container.dataset.loading) return;

            let nextPage = container.dataset.nextPage;
            let statusId = container.dataset.statusId;

            if (!nextPage) return;

            let url = new URL(nextPage, window.location.origin);
            url.searchParams.set('status_id', statusId);

            ceAjax('GET', url.toString(), {
                loader: true,
                beforeSend: () => container.dataset.loading = '1',
                callback: data => {
                    if (data.html) {
                        container.insertAdjacentHTML('beforeend', data.html);
                        container.dataset.nextPage = data.next_page || '';
                        updateCounts();
                        initSortables();
                    }
                },
                complete: () => delete container.dataset.loading
            });
        }

        document.getElementById('lead-search').addEventListener('input', debounce(function() {
            currentParams.search = this.value;
            resetAndFetchLeads();
        }, 400));

        document.getElementById('sort-date').addEventListener('change', function() {
            currentParams.sort_date = this.value;
            resetAndFetchLeads();
        });

        document.getElementById('filter-assigned-to').addEventListener('change', function() {
            currentParams.assigned_to = this.value;
            resetAndFetchLeads();
        });

        document.getElementById('filter-source').addEventListener('change', function() {
            currentParams.source = this.value;
            resetAndFetchLeads();
        });

        function resetAndFetchLeads() {
            document.querySelectorAll('.lead-list').forEach(container => {
                container.innerHTML = '';

                // Build query params
                let params = new URLSearchParams(currentParams);
                params.set('status', container.dataset.statusId);

                // Reset to page 1
                container.dataset.nextPage = "{{ route('admin.leads.index') }}" + "?" + params.toString();

                loadMoreLeads(container);
            });
        }

        function updateCounts() {
            document.querySelectorAll('.status-column').forEach(col => {
                let statusId = col.id.replace('status-', '').replace('-column', '');
                let count = document.querySelectorAll(`#status-${statusId}-leads .lead-card`).length;
                col.querySelector('.status-count').textContent = count;
            });
        }


        function updateLeadStatus(leadId, newStatusId) {
            ceAjax('POST', '{{ route("admin.leads.update-status") }}', {
                data: {
                    lead_id: leadId,
                    status_id: newStatusId
                },
                callback: data => {
                    if (data.success) {
                        showToast("Lead status updated", "success");
                        updateCounts();
                    }
                },
                errorCallback: () => showToast("Error updating lead status", "error")
            });
        }

        // Debounce helper
        function debounce(fn, delay) {
            let timer;
            return function(...args) {
                clearTimeout(timer);
                timer = setTimeout(() => fn.apply(this, args), delay);
            };
        }

        const scrollLeftBtn = document.getElementById('scroll-left');
        const scrollRightBtn = document.getElementById('scroll-right');

        const scrollStep = 300; // px per click

        scrollLeftBtn.addEventListener('click', () => {
            leads.scrollBy({
                left: -scrollStep,
                behavior: 'smooth'
            });
        });

        scrollRightBtn.addEventListener('click', () => {
            leads.scrollBy({
                left: scrollStep,
                behavior: 'smooth'
            });
        });

        // Optionally hide/show buttons if scroll reaches ends
        function updateScrollButtons() {
            scrollLeftBtn.style.display = leads.scrollLeft <= 0 ? 'none' : 'block';
            scrollRightBtn.style.display = leads.scrollLeft + leads.clientWidth >= leads.scrollWidth ? 'none' : 'block';
        }

        leads.addEventListener('scroll', updateScrollButtons);
        updateScrollButtons();
    });
</script>
@endsection