@extends('admin::layouts.app')

@section('title', 'Lead Detail | '. $lead->name)
@section('styles')
<style>
    .tab-content.lead-details.active {
        display: block;
    }

    .tab-content.lead-details {
        display: none;
    }
</style>
@endsection
@section('content')

    <!-- Header with back button -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        @include('admin::components.common.back-button', ['route' => route('admin.leads.index'), 'name' => 'Lead Detail / '.$lead->name.' / '.$lead->created_at . ' / ' . fn_get_currency($lead->value ?? 0) ])
        <div class="ml-auto flex space-x-3 mb-2">
            @if(bouncer()->hasPermission('admin.leads.edit'))
            
            <x-button type="button"    
                as="a"
                href="{{ route('admin.leads.edit', $lead) }}"
                class="blue" 
                label="<span class='material-icons-outlined mr-1'>edit</span>" 
                icon=''
                name="button" 
            />
            @endif
            @if(bouncer()->hasPermission('admin.application.send_application'))
            <x-modal
                buttonText='Send Application'
                modalTitle="Send Application"
                id='send_application'
                ajaxUrl="{{route('admin.application.send_application', $lead)}}"
                color="blue"
                modalSize="3xl" />
            @endif
        </div>
    </div>
    <!-- Main content area -->
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Left side - Lead details (sticky/fixed) -->
        <div class="lg:sticky lg:top-6 lg:h-[calc(100vh-3rem)] lg:overflow-y-auto scroll-smooth">
            @include('leads::leads.components.details-left')
        </div>

        <!-- Right side - Activity tabs (scrollable) -->
        <div class="flex-1">
            @include('leads::leads.components.details-right')
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Tab switching functionality
    function switchTab(tabName) {
        loadTabs(tabName);
    }

    function loadTabs(tabName) {        
        ceAjax('get', '{{ route("admin.leads.show", $lead->id) }}', {
            loader:true,
            data: {
                tab: tabName
            },
            result_ids: 'leads_tab', // This will update the calendar container directly
            caching: false,
            callback: function(data) {
                const tabContent = document.getElementById(`${tabName}-tab`);
                if (tabContent) {
                    tabContent.classList.add('active');
                }
                
                // Update tab button styles
                const allTabButtons = document.querySelectorAll('.tab-button');
                allTabButtons.forEach(button => {
                    
                    button.classList.remove('border-blue-500', 'text-blue-600');
                    button.classList.add('border-transparent', 'text-gray-500');
                    
                    if (button.dataset.tab === tabName) {
                        button.classList.add('border-blue-500', 'text-blue-600');
                        button.classList.remove('border-transparent', 'text-gray-500');
                    }
                });
            },
            errorCallback: function(xhr) {
                showToast('Unable to load '+tabName+' tab', 'error', 'Error');
            }
        });
    }

    @if(bouncer()->hasPermission('admin.leads.update-assignment'))
        const nameInput = document.getElementById('input-assign_id');
        const idInput = document.getElementById('assign_id');
        const updateBtn = document.getElementById('update-assign-btn');
        const leadId = updateBtn.getAttribute('data-lead-id');

        // Check for changes in either the name or ID
        function checkForChanges() {
            const originalName = nameInput.getAttribute('data-original-value');
            const originalId = idInput.getAttribute('data-original-value');
            const currentName = nameInput.value;
            const currentId = idInput.value;

            if (currentName !== originalName || currentId !== originalId) {
                updateBtn.classList.remove('hidden');
            } else {
                updateBtn.classList.add('hidden');
            }
        }

        // Listen for changes on both inputs
        nameInput.addEventListener('input', checkForChanges);
        idInput.addEventListener('change', checkForChanges);


        @endif

   
</script>
@endsection