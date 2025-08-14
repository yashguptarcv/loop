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
                            class="inline-flex justify-center w-full rounded-md border border-blue-300 shadow-sm px-4 py-2 bg-blue-100 text-sm font-medium text-blue-600 hover:bg-blue-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
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
                            class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100"
                            role="menuitem">{{ $option['label'] }}</a>
                            @else
                            <a href="{{ route($option['value']) }}"
                            class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100"
                            role="menuitem">{{ $option['label'] }}</a>
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
                    $buttonClass = 'inline-flex items-center px-4 py-2 border rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 hover:text-blue-300 ';
                    $buttonClass .= $action['action'];
                    @endphp

                    <a href="{{ route($action['url']) }}" class="{{ $buttonClass }}">
                        @if(!empty($action['icon']))
                        <span class="material-icons-outlined mr-2">{{ $action['icon'] }}</span>
                        @endif
                        {{ $action['title'] }}
                    </a>
                @endif
            @endif
        @endforeach
        @if(!empty($is_export) && $is_export == 'true')
        <x-modal 
            buttonText="<span class='material-icons-outlined mr-1'>file_upload</span>Export"
            modalTitle="Export"
            id="export_data_view"
            ajaxUrl="{{route('dataview.export')}}"
            color="blue"
            modalSize="sm"
        />
        @endif
    </div>

    <button id="filterToggle"
        class="flex items-center text-sm font-medium bg-blue-100 text-blue-600 hover:text-300 border border-blue-600 hover:text-blue-300 px-2 py-1 rounded-md">
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

    <div class="flex items-center space-x-2">
        <nav class="flex items-center space-x-2">
            <!-- First page (<<) -->
            <a href="{{ request()->fullUrlWithQuery(['pagination[page]' => 1]) }}"
                class="p-2 rounded-md border border-gray-200 bg-white text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition-colors duration-150 {{ $currentPage == 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                aria-label="First page">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M15.707 15.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 010 1.414zm-6 0a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 011.414 1.414L5.414 10l4.293 4.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
            </a>

            <!-- Previous page (<) -->
            <a href="{{ request()->fullUrlWithQuery(['pagination[page]' => max(1, $currentPage - 1)]) }}"
                class="p-2 rounded-md border border-gray-200 bg-white text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition-colors duration-150 {{ $currentPage == 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                aria-label="Previous page">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                        clip-rule="evenodd" />
                </svg>
            </a>

            <!-- Per page dropdown -->
            <div class="relative">
                <select onchange="window.location.href = this.value"
                    class="appearance-none pl-3 pr-8 py-2 border border-gray-200 rounded-md bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm shadow-sm">
                    @foreach($data['meta']['per_page_options'] as $option)
                    <option
                        value="{{ request()->fullUrlWithQuery(['pagination[per_page]' => $option, 'pagination[page]' => 1]) }}"
                        {{ $perPage == $option ? 'selected' : '' }}>
                        {{ $option }}
                    </option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>

            <!-- Next page (>) -->
            <a href="{{ request()->fullUrlWithQuery(['pagination[page]' => min($data['meta']['last_page'], $currentPage + 1)]) }}"
                class="p-2 rounded-md border border-gray-200 bg-white text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition-colors duration-150 {{ $currentPage == $data['meta']['last_page'] ? 'opacity-50 cursor-not-allowed' : '' }}"
                aria-label="Next page">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd" />
                </svg>
            </a>

            <!-- Last page (>>) -->
            <a href="{{ request()->fullUrlWithQuery(['pagination[page]' => $data['meta']['last_page']]) }}"
                class="p-2 rounded-md border border-gray-200 bg-white text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition-colors duration-150 {{ $currentPage == $data['meta']['last_page'] ? 'opacity-50 cursor-not-allowed' : '' }}"
                aria-label="Last page">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10.293 15.707a1 1 0 010-1.414L14.586 10l-4.293-4.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z"
                        clip-rule="evenodd" />
                    <path fill-rule="evenodd"
                        d="M4.293 15.707a1 1 0 010-1.414L8.586 10 4.293 5.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z"
                        clip-rule="evenodd" />
                </svg>
            </a>
        </nav>
    </div>
</div>



<hr class="mb-4 border-t border-gray-200" />

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
            <div class="bg-blue-100 p-8 rounded-2xl shadow-[0_4px_20px_var(--color-shadow)] w-full max-w-md transform transition-all duration-300 ease-out scale-95 hover:scale-100">
                <div class="flex items-center gap-3 mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h2 class="text-2xl font-semibold text-blue-600">Need Confirmation</h2>
                </div>
                <p class="mb-6 text-black-600 text-base leading-relaxed">Are you sure you want to made this changes?</p>
                <div class="flex justify-end space-x-3">
                    <button id="cancelAction" class="inline-flex items-center px-4 py-2 border rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 hover:text-blue-300 text-blue-600 bg-blue-100">
                        Cancel
                    </button>
                    <button id="confirmAction" class="inline-flex items-center px-4 py-2 border rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 hover:text-red-300 text-red-600 bg-red-100">
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