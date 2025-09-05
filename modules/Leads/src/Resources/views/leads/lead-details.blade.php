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
            loader: true,
            data: {
                tab: tabName
            },
            result_ids: 'leads_tab',
            caching: false,
            callback: function(data) {
                const tabContent = document.getElementById(`${tabName}-tab`);
                if (tabContent) {
                    tabContent.classList.add('active');
                }

                // Store current tab
                const leadsTab = document.getElementById('leads_tab');
                leadsTab.dataset.tab = tabName;

                // Update tab button styles
                const allTabButtons = document.querySelectorAll('.tab-button');
                allTabButtons.forEach(button => {
                    button.classList.remove('border-primary-100', 'text-primary-100');
                    button.classList.add('border-transparent', 'text-gray-500');

                    if (button.dataset.tab === tabName) {
                        button.classList.add('border-primary-100', 'text-primary-100');
                        button.classList.remove('border-transparent', 'text-gray-500');
                    }
                });
            },
            errorCallback: function(xhr) {
                showToast('Unable to load ' + tabName + ' tab', 'error', 'Error');
            }
        });
    }
    

    document.addEventListener('DOMContentLoaded', function() {
        const leadsTab = document.getElementById('leads_tab');

        // Update or replace Load More button with backend-rendered HTML
        function updateButton(newWrapperHtml) {
            const oldBtnWrapper = document.getElementById('load-more-wrapper');
            if (oldBtnWrapper) oldBtnWrapper.remove();

            if (newWrapperHtml) {

                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = newWrapperHtml.trim();
                const newWrapper = tempDiv.firstElementChild;
                if (newWrapper) leadsTab.appendChild(newWrapper);
            }
        }

        // Click handler for Load More
        document.addEventListener('click', function(e) {

            if (e.target && e.target.id === 'load-more-btn') {
                // Always get the latest render_url_lead element
                const render_url_lead = document.getElementById('render_url_lead');

                const nextPage = render_url_lead.dataset.nextPage;
                const currentTab = leadsTab.dataset.tab || 'activity'; // fallback
                

                console.log(nextPage);
                if (!nextPage) return;

                // Show loading state on the button temporarily
                e.target.disabled = true;
                e.target.textContent = 'Loading...';

                ceAjax('get', nextPage, {
                    loader: false,
                    data: {
                        tab: currentTab
                    }, // ensure backend knows active tab
                    callback: function(response) {
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = response.html;

                        // Insert new activities above the button
                        const newActivities = tempDiv.querySelectorAll('.flex.items-start');
                        const loadMoreWrapper = document.getElementById('load-more-wrapper');
                        newActivities.forEach(item => {
                            if (loadMoreWrapper) loadMoreWrapper.insertAdjacentElement('beforebegin', item);
                            else leadsTab.appendChild(item);
                        });

                        // Replace button HTML
                        const newBtnWrapper = tempDiv.querySelector('#load-more-wrapper');
                        updateButton(newBtnWrapper ? newBtnWrapper.outerHTML : null);

                        // Update dataset values
                        if (response.next_page) render_url_lead.dataset.nextPage = response.next_page;
                        else render_url_lead.dataset.nextPage = ""; // No more pages

                        if (response.current) render_url_lead.dataset.current = response.current;
                        if (response.totalPages) render_url_lead.dataset.total = response.totalPages;

                        // Ensure new button is enabled (if exists)
                        const newBtn = document.getElementById('load-more-btn');
                        if (newBtn) {
                            newBtn.disabled = false;
                            newBtn.textContent = `(${render_url_lead.dataset.current} / ${render_url_lead.dataset.total})`;
                        }
                    },
                    errorCallback: function() {
                        // Only restore old button if request fails
                        e.target.disabled = false;
                        e.target.textContent = 'Load More';
                    }
                });
            }
        });


    });

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