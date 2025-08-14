@extends('admin::layouts.app')

@section('title', 'Lead Detail')
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
    <div class="flex justify-between items-center mb-8">
        @include('admin::components.common.back-button', ['route' => route('admin.leads.index'), 'name' => 'Lead Detail / '.$lead->name.' / '.$lead->created_at . ' / ' . fn_convert_currency($lead->value ?? 0, 'USD') ])
        <div class="ml-auto flex space-x-3 mb-2">
            @if(bouncer()->hasPermission('admin.leads.edit'))
            <a href="{{ route('admin.leads.edit', $lead) }}" class="text-small px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100">
                Edit
            </a>
            @endif
            @if(bouncer()->hasPermission('admin.application.send_application'))
            <x-modal
                buttonText='Send Application'
                modalTitle="Send Application"
                id='send_application'
                ajaxUrl="{{route('admin.application.send_application', $lead)}}"
                color="purple"
                modalSize="lg" />
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

        @if(bouncer()->hasPermission('admin.leads.activities.store'))
        // Initialize TinyMCE with mentions plugin
        tinymce.init({
            selector: '#message-editor',
            plugins: 'link lists mentions',
            toolbar: 'undo redo | bold italic | bullist numlist | link | mentions',
            menubar: false,
            statusbar: false,
            height: 200,
            source: function(query, success, failure) {
                if (query.term.length < 3) {
                    success([]);
                    return;
                }

                fetch(`/admin/leads/users/search?q=${encodeURIComponent(query.term)}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Mention data received:', data); // Debug log
                        success(data);
                    })
                    .catch(error => {
                        console.error('Mention fetch error:', error); // Debug log
                        failure(error);
                    });
            },
            setup: function(editor) {
                editor.on('change', function() {
                    const content = editor.getContent();
                    document.getElementById('activity-description').value = content;
                });
            }
        });
        @endif
    </script>
    @endsection