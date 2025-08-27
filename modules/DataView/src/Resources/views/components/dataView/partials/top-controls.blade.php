@php
$pagination = request('pagination', []);
$currentPage = $pagination['page'] ?? $data['meta']['current_page'];
$perPage = $pagination['per_page'] ?? $data['meta']['per_page'];
@endphp

<div class="flex-1 flex flex-col sm:flex-row justify-end gap-4">
    <!-- Mass Action Button Group (hidden by default) -->
    <div class="flex items-center space-x-2">
        @foreach($data['mass_actions'] as $action)

            @if(!empty($action['options']))
            {{-- Dropdown button --}}
            <div @if($action['method']==='POST' ) id="mass-action-buttons" class="relative text-left hidden" @else class="relative inline-block text-left" @endif>
                <div class="relative">
                    <button type="button" 
                            onclick="toggleDropdown({{ $loop->index }})"
                            class="inline-flex justify-center w-full rounded-md border border-primary-100 shadow-sm px-4 py-2 bg-primary-100 text-sm font-medium text-amber-100 hover:text-amber-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            id="menu-button-{{ $loop->index }}" 
                            aria-expanded="false" 
                            aria-haspopup="true"
                            aria-controls="dropdown-menu-{{ $loop->index }}">
                        @if(!empty($action['icon']))
                        <span class="material-icons-outlined mr-2">{{ $action['icon'] }}</span>
                        @endif
                        {{ $action['title'] }}
                        <svg class="-mr-1 ml-2 h-5 w-5 transition-transform duration-200 transform" 
                            id="dropdown-arrow-{{ $loop->index }}"
                            xmlns="http://www.w3.org/2000/svg" 
                            viewBox="0 0 20 20"
                            fill="currentColor" 
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div id="dropdown-menu-{{ $loop->index }}"
                        class="hidden origin-top-right absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10 transition-all duration-200 ease-out"
                        role="menu" 
                        aria-orientation="vertical" 
                        aria-labelledby="menu-button-{{ $loop->index }}">
                        <div class="py-1" role="none">
                            @foreach($action['options'] as $option)
                            @if($action['method'] === 'POST')
                                <a href="javascript:;"
                                onclick="handleMassAction('{{ route($action['url']) }}', '{{ $action['method'] }}', '{{ $option['value'] }}')"
                                class="block px-4 py-2 text-sm bg-primary-100 text-amber-100 hover:text-amber-200 border border-primary-100"
                                role="menuitem">{{ $option['label'] }}</a>
                            @else
                                @if(!empty($action['is_popup'])) 
                                    @php
                                        $title = isset($action['icon']) ? "<span class='material-icons-outlined'>".$action['icon']."</span> ". $action['title'] : $action['title'] ;
                                    @endphp
                                    <x-modal 
                                        buttonText="{!! $title !!}"
                                        modalTitle="{{ $action['title'] }}"
                                        id="massaction_{{rand(100, 2000)}}"
                                        ajaxUrl="{{ route($action['url']) }}"
                                        color="primary"
                                        modalSize="2xl"
                                    />
                                @else
                                    <a href="{{ route($option['value']) }}"
                                    class="block px-4 py-2 text-sm bg-primary-100 text-amber-100 hover:text-amber-200 border border-primary-100"
                                    role="menuitem">{{ $option['label'] }}</a>
                                @endif
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @else
                @if($action['method'] === 'POST')
                {{-- Regular button --}}
                    @php
                        $buttonClass = 'inline-flex items-center px-4 py-2 border rounded-md text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 ';
                        $buttonClass .= $action['action'];
                    @endphp

                    <button id="mass-action-buttons" type="button" onclick="handleMassAction('{{ route($action['url']) }}', '{{ $action['method'] }}')"
                        class="{{ $buttonClass }} hidden">
                        @if(!empty($action['icon']))
                        <span class="material-icons-outlined mr-2">{{ $action['icon'] }}</span>
                        @endif
                        {{ $action['title'] }}
                    </button>
                @else
                    @php
                    $buttonClass = 'inline-flex items-center px-4 py-2 border rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 bg-primary-100 text-amber-100 hover:text-amber-200 border border-primary-100  ';
                    $buttonClass .= $action['action'];
                    @endphp

                    @if(!empty($action['is_popup'])) 
                        @php
                            $title = isset($action['icon']) ? "<span class='material-icons-outlined'>".$action['icon']."</span> ". $action['title'] : $action['title'] ;
                        @endphp
                        <x-modal 
                            buttonText="{!! $title !!}"
                            modalTitle="{{ $action['title'] }}"
                            id="massaction_{{rand(100, 2000)}}"
                            ajaxUrl="{{ route($action['url']) }}"
                            color="primary"
                            modalSize="3xl"
                        />
                    @else

                        <a href="{{ route($action['url']) }}" class="{{ $buttonClass }}">
                            @if(!empty($action['icon']))
                            <span class="material-icons-outlined mr-2">{{ $action['icon'] }}</span>
                            @endif
                            {{ $action['title'] }}
                        </a>
                    @endif
                @endif
            @endif
        @endforeach

        @if(!empty($is_export) && $is_export == 'true')
        <x-modal 
            buttonText="<span class='material-icons-outlined mr-1'>file_upload</span>Export"
            modalTitle="Export"
            id="export_data_view"
            ajaxUrl="{{route('dataview.export')}}"
            color="primary"
            modalSize="sm"
        />
        @endif
    </div>

    <button id="filterToggle"
        class="flex items-center text-sm font-medium bg-primary-100 text-amber-100 hover:text-amber-200 border border-primary-100 px-2 py-1 rounded-md">
        <span class="material-icons-outlined mr-1">filter_alt</span>
        Filters
    </button>
</div>


<div class="flex flex-col md:flex-row md:items-center mt-6 md:justify-between mb-6 gap-4">
    <div class="relative max-w-md">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-[var(--color-text-secondary)]" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                    clip-rule="evenodd"></path>
            </svg>
        </div>
        <input type="text" name="all" id="all" value="{{ request('filters')['all'][0] ?? '' }}"
            class="block w-full pl-10 pr-3 py-2 border border-blue-100 rounded-md leading-5 bg-[var(--color-white)] 
               placeholder-[var(--color-text-secondary)] text-[var(--color-text-primary)] sm:text-sm 
               focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all duration-200" placeholder="Search..."
            onkeypress="handleKeySearch(event)">
    </div>

    
</div>



<hr class="mb-4 border-t divide-gray-100" />

<script>
    updateMassActionsVisibility();

    // Toggle all checkboxes
    function toggleSelectAll(checkbox) {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(cb => cb.checked = checkbox.checked);
        updateMassActionsVisibility();
    }

    // Show/hide mass action buttons based on selection
    function updateMassActionsVisibility() {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        const checkedCount = document.querySelectorAll('.row-checkbox:checked').length;
        
        // Select all mass action containers
        const massActionContainers = document.querySelectorAll('#mass-action-buttons');
        
        massActionContainers.forEach(container => {
            container.style.display = checkedCount > 0 ? 'inline-flex' : 'none';
        });
    }

    // Handle mass actions with confirmation
    function handleMassAction(url, method, optionValue = null) {
        const selectedIds = Array.from(document.querySelectorAll('.row-checkbox:checked'))
            .map(checkbox => checkbox.value);

        if (selectedIds.length === 0) {
            alert('Please select at least one item');
            return;
        }

        // Create confirmation modal
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black/50 bg-opacity-50 flex items-center justify-center z-50';
        modal.innerHTML = `
            <div class="bg-primary-100 p-8 rounded-2xl shadow-[0_4px_20px_var(--color-shadow)] w-full max-w-md transform transition-all duration-300 ease-out scale-95 hover:scale-100">
                <div class="flex items-center gap-3 mb-4">
                    <svg class="w-6 h-6 text-amber-100" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h2 class="text-2xl font-semibold text-amber-100">Need Confirmation</h2>
                </div>
                <p class="mb-6 text-amber-100 text-base leading-relaxed">Are you sure you want to made this changes?</p>
                <div class="flex justify-end space-x-3">
                    <button id="cancelAction" class="inline-flex items-center px-4 py-2 rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 hover:text-amber-200 text-amber-100 bg-primary-100">
                        Cancel
                    </button>
                    <button id="confirmAction" class="inline-flex items-center px-4 py-2 rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 hover:text-primary-200 text-primary-100 bg-amber-100">
                        Confirm
                    </button>
                </div>
            </div>`;

        // Add modal to body
        document.body.appendChild(modal);
        document.body.style.overflow = 'hidden';

        // Handle cancel button
        document.getElementById('cancelAction').addEventListener('click', () => {
            document.body.removeChild(modal);
            document.body.style.overflow = '';
        });

        // Handle confirm button
        document.getElementById('confirmAction').addEventListener('click', () => {
            document.body.removeChild(modal);
            document.body.style.overflow = '';
            
                // For POST/PUT/DELETE, use a form submission
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;

                // Add CSRF token if using Laravel
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                if (csrfToken) {
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;
                    form.appendChild(csrfInput);
                }

                // Add method spoofing for PUT/DELETE
                if (method !== 'POST') {
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = method;
                    form.appendChild(methodInput);
                }

                // Add selected IDs
                selectedIds.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = id;
                    form.appendChild(input);
                });

                // Add option value if provided
                if (optionValue) {
                    const actionInput = document.createElement('input');
                    actionInput.type = 'hidden';
                    actionInput.name = 'action';
                    actionInput.value = optionValue;
                    form.appendChild(actionInput);
                }

                document.body.appendChild(form);
                form.submit();
            
        });
    }

    // Toggle dropdown function
    function toggleDropdown(index) {
        const dropdown = document.getElementById(`dropdown-menu-${index}`);
        const button = document.getElementById(`menu-button-${index}`);
        const arrow = document.getElementById(`dropdown-arrow-${index}`);
        
        // Toggle visibility
        dropdown.classList.toggle('hidden');
        
        // Update aria-expanded
        const isExpanded = button.getAttribute('aria-expanded') === 'true';
        button.setAttribute('aria-expanded', !isExpanded);
        
        // Rotate arrow
        arrow.classList.toggle('rotate-180');
        
        // Close other dropdowns if needed
        document.querySelectorAll('[id^="dropdown-menu-"]').forEach((menu) => {
            if (menu.id !== `dropdown-menu-${index}`) {
                menu.classList.add('hidden');
                const otherButton = document.getElementById(menu.getAttribute('aria-labelledby'));
                if (otherButton) {
                    otherButton.setAttribute('aria-expanded', 'false');
                    const otherArrow = document.getElementById(`dropdown-arrow-${menu.id.split('-').pop()}`);
                    if (otherArrow) otherArrow.classList.remove('rotate-180');
                }
            }
        });
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('[id^="menu-button-"]') && !event.target.closest('[id^="dropdown-menu-"]')) {
            document.querySelectorAll('[id^="dropdown-menu-"]').forEach((menu) => {
                menu.classList.add('hidden');
                const button = document.getElementById(menu.getAttribute('aria-labelledby'));
                if (button) button.setAttribute('aria-expanded', 'false');
                const arrow = document.getElementById(`dropdown-arrow-${menu.id.split('-').pop()}`);
                if (arrow) arrow.classList.remove('rotate-180');
            });
        }
    });

    function handleKeySearch(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const value = e.target.value;
            const params = new URLSearchParams(window.location.search);
            params.set('filters[all][]', value);
            params.set('pagination[page]', 1);
            window.location.href = window.location.pathname + '?' + params.toString();
        }
    }
</script>