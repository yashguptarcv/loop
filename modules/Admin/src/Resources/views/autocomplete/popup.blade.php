<!-- Search + Close -->
<div class="p-4">
    <!-- Data Table -->
    <div class="overflow-x-auto rounded-lg shadow-sm border border-gray-200">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    @foreach($listAttributes as $attr)
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer select-none group"
                        onclick="setSort('{{ $attr }}')" id="sort-{{ $attr }}">
                        <div class="flex items-center">
                            <span>{{ ucfirst($attr) }}</span>
                            <span class="ml-1 text-gray-400 group-hover:text-gray-600" id="sort-icon-{{ $attr }}">↕</span>
                        </div>
                    </th>
                    @endforeach
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody id="popup-tbody" class="bg-white divide-y divide-gray-200">
                @foreach($items as $item)
                <tr class="hover:bg-gray-50 transition-colors">
                    @foreach($listAttributes as $attr)
                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">
                        {{ $item->$attr }}
                    </td>
                    @endforeach
                    <td class="px-4 py-4 whitespace-nowrap text-sm">
                        <div class="flex gap-2">
                            @foreach($actions as $action)
                            <button
                                onclick="triggerPopupAction('{{ $action['callback'] }}', @json($item))"
                                class="px-3 py-1 
                                               {{ $action['type'] === 'primary' ? 'bg-blue-500 text-white hover:bg-blue-600' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}
                                               rounded-lg text-xs transition-colors shadow-sm">
                                {{ $action['label'] }}
                            </button>
                            @endforeach
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4" id="popup-pagination">
        {{ $items->links() }}
    </div>
</div>

<script>
    let popupSortField = null;
    let popupSortDirection = 'asc';
    let popupSearchQuery = '';
    let popupPage = 1;

    // 🔹 Sorting
    function setSort(field) {
        if (popupSortField === field) {
            popupSortDirection = popupSortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            popupSortField = field;
            popupSortDirection = 'asc';
        }
        reloadPopupTable();
    }

    // 🔹 Searching
    function doSearch(query) {
        popupSearchQuery = query;
        popupPage = 1; // reset to first page when searching
        reloadPopupTable();
    }

    // 🔹 Pagination
    function goToPage(page) {
        popupPage = page;
        reloadPopupTable();
    }

    // 🔹 Core reload function
    function reloadPopupTable() {
        ceAjax('get', '/admin/autocomplete/list?table={{$table}}&list_attributes={{$listAttributes}}', {
            loader: true,
            data: {
                tab: 'items',
                sort: popupSortField,
                direction: popupSortDirection,
                search: popupSearchQuery,
                page: popupPage
            },
            result_ids: 'popup-tbody',
            caching: false,
            callback: function(data) {
                // Update sort icons UI
                document.querySelectorAll('[id^="sort-icon-"]').forEach(el => {
                    el.textContent = '↕';
                });
                if (popupSortField) {
                    const icon = document.getElementById('sort-icon-' + popupSortField);
                    if (icon) icon.textContent = popupSortDirection === 'asc' ? '↑' : '↓';
                }
            },
            errorCallback: function(xhr) {
                showToast('Unable to load table', 'error', 'Error');
            }
        });
    }

    // 🔹 Hook search box
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('popup-search');
        if (searchInput) {
            searchInput.addEventListener('keyup', (e) => {
                doSearch(e.target.value);
            });
        }
    });
</script>