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
    @include('leads::leads.components.detail')

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
