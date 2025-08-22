@extends('admin::layouts.app')

@section('title', 'Settings')

@section('content')
@include('admin::components.common.back-button', ['route' => route('admin.settings.index'), 'name' => 'Settings'])

<!-- Right side - Activity tabs -->
<div class="border-b border-gray-200">
    <nav class="flex -mb-px space-x-8">
        <a href="javascript:;" onclick="switchTab('general')" data-tab="general"
            class="tab-button whitespace-nowrap py-4 px-2 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
            General
        </a>
        <a href="javascript:;" onclick="switchTab('company')" data-tab="company"
            class="tab-button whitespace-nowrap py-4 px-2 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
            Company Information
        </a>
        <a href="javascript:;" onclick="switchTab('checkout')" data-tab="checkout"
            class="tab-button whitespace-nowrap py-4 px-2 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
            Checkout / Order Configuration
        </a>
        <a href="javascript:;" onclick="switchTab('email')" data-tab="email"
            class="tab-button whitespace-nowrap py-4 px-2 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
            Email Configuration
        </a>
        <a href="javascript:;" onclick="switchTab('channel')" data-tab="channel"
            class="tab-button whitespace-nowrap py-4 px-2 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
            Channels
        </a>
        <a href="javascript:;" onclick="switchTab('lead')" data-tab="lead"
            class="tab-button whitespace-nowrap py-4 px-2 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
            Lead Configuration
        </a>

        <a href="javascript:;" onclick="switchTab('editortab')" data-tab="editortab"
            class="tab-button whitespace-nowrap py-4 px-2 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
            Text Editor
        </a>
    </nav>

</div>
<form id="leadForm" class="form-ajax" method="POST"
    action="{{ route('admin.settings.general.store') }}">
    @csrf
    <!-- Content area with left padding to avoid overlap -->
    <div id="tab-content" class="tab-content lead-details active space-y-4">

        @include('admin::settings.general.general')

    </div>
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">

        <x-button type="submit"
            class="blue"
            label="Save"
            icon=''
            name="button" />
    </div>
</form>

@endsection

@section('scripts')
<script>
    // Tab switching functionality
    function switchTab(tabName) {
        loadTabs(tabName);
    }

    function loadTabs(tabName) {
        ceAjax('get', '{{ route("admin.settings.general.create") }}', {
            loader: true,
            data: {
                tab: tabName
            },
            result_ids: 'tab-content',
            caching: false,
            callback: function(data) {
                // Remove active styles from all tabs
                document.querySelectorAll('.tab-button').forEach(btn => {
                    btn.classList.remove('border-indigo-500', 'text-indigo-600');
                    btn.classList.add('border-transparent', 'text-gray-500');
                });

                // Add active styles to the selected tab
                const activeBtn = document.querySelector(`.tab-button[data-tab="${tabName}"]`);
                if (activeBtn) {
                    activeBtn.classList.remove('border-transparent', 'text-gray-500');
                    activeBtn.classList.add('border-indigo-500', 'text-indigo-600');
                }

                // Replace tab content
                document.getElementById('tab-content').innerHTML = data;
            },
            errorCallback: function(xhr) {
                showToast('Unable to load ' + tabName + ' tab', 'error', 'Error');
            }
        });
    }
</script>

@endsection