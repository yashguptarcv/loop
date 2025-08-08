@php
    $pagination = request('pagination', []);
    $currentPage = $pagination['page'] ?? $data['meta']['current_page'];
    $perPage = $pagination['per_page'] ?? $data['meta']['per_page'];
@endphp

<div class="flex-1 flex flex-col sm:flex-row justify-end gap-4">
    <!-- New Button Group -->
    <div class="flex items-center space-x-2">
        @foreach($data['mass_actions'] as $action)
            @if($action['url'] || $action['options'])
                @if(!empty($action['options']))
                    {{-- This is a dropdown button --}}
                    <div class="relative inline-block text-left">
                        <div>
                            <button type="button" onclick="toggleDropdown({{ $loop->index }})"
                                class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                id="menu-button" aria-expanded="false" aria-haspopup="true">
                                @if(str_contains($action['icon'], 'icon-'))
                                    <span class="{{ $action['icon'] }} mr-2"></span>
                                @endif
                                {{ $action['title'] }}
                                @if(!empty($action['options']))
                                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </button>
                        </div>

                        @if(!empty($action['options']))
                            <div id="dropdown-menu-{{ $loop->index }}"
                                class="hidden origin-top-right absolute left-0 mt-2 w-30 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10"
                                role="menu" aria-orientation="vertical" aria-labelledby="menu-button">
                                <div class="py-1" role="none">
                                    @foreach($action['options'] as $option)
                                        <a href="#" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100"
                                            role="menuitem">{{ $option['label'] }}</a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    {{-- Regular button --}}
                    @php
                        $buttonClass = 'inline-flex items-center px-4 py-2 border rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 ';

                        // Determine button style based on action type
                        if (str_contains($action['icon'], 'icon-delete') || str_contains($action['title'], 'Delete')) {
                            $buttonClass .= 'border-transparent text-white bg-red-600 hover:bg-red-700 focus:ring-red-500';
                        } elseif (str_contains($action['icon'], 'icon-add') || str_contains($action['title'], 'Create')) {
                            $buttonClass .= 'border-gray-300 text-white bg-blue-600 hover:bg-blue-700 focus:ring-blue-500';
                        } else {
                            $buttonClass .= 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50 focus:ring-blue-500';
                        }
                    @endphp

                    <button type="button" onclick="handleAction('{{ $action['url'] }}', '{{ $action['method'] }}')"
                        class="{{ $buttonClass }}">
                        @if(str_contains($action['icon'], 'icon-'))
                            <span class="{{ $action['icon'] }} mr-2"></span>
                        @elseif($action['icon'])
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                        @endif
                        {{ $action['title'] }}
                    </button>
                @endif
            @endif
        @endforeach
    </div>

</div>




<hr class="mb-4 border-t border-gray-200" />

<script>
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


    function handleAction(url, method) {
        if (!url) return;

        if (method === 'GET') {
            window.location.href = url;
        } else if (method === 'POST') {
            // For POST requests, you'd typically use a form submission
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = url;
            document.body.appendChild(form);
            form.submit();
        }
    }

    function toggleDropdown(index) {
        const menu = document.getElementById(`dropdown-menu-${index}`);
        console.log(menu, index);

        menu.classList.toggle('hidden');
    }
</script>