<div class="bg-[var(--color-white)] shadow overflow-hidden sm:rounded-lg">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-[var(--color-border)]">
            <thead class="bg-[var(--color-gray-50)]">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-[var(--color-text-secondary)] uppercase tracking-wider">
                        <input type="checkbox" id="select-all" onclick="toggleSelectAll(this)">
                    </th>
                    @foreach($data['columns'] as $column)
                        @if($column['visibility'])
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-[var(--color-text-secondary)] uppercase tracking-wider">
                                @if($column['sortable'])
                                    <div class="flex items-center">
                                        @php
                                            $currentSort = request('sort', []);
                                            $isSortedColumn = isset($currentSort['column']) && $currentSort['column'] === $column['index'];
                                            $nextOrder = $isSortedColumn && ($currentSort['order'] ?? 'asc') === 'asc' ? 'desc' : 'asc';
                                        @endphp
                                        <a href="{{ request()->fullUrlWithQuery(['sort[column]' => $column['index'], 'sort[order]' => $nextOrder]) }}"
                                            class="hover:text-[var(--color-text-primary)] flex items-center">
                                            {{ $column['label'] }}

                                            @if($isSortedColumn)
                                                <span class="ml-1">
                                                    @if(($currentSort['order'] ?? 'asc') === 'asc')
                                                        <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M10 6l-4 4h8l-4-4z" />
                                                        </svg>
                                                    @else
                                                        <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M10 14l4-4H6l4 4z" />
                                                        </svg>
                                                    @endif
                                                </span>
                                            @endif
                                        </a>
                                    </div>
                                @else
                                    {{ $column['label'] }}
                                @endif
                            </th>
                        @endif
                    @endforeach
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-[var(--color-text-secondary)] uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-[var(--color-white)] divide-y divide-[var(--color-border)]">
                @foreach($data['records'] as $record)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" class="row-checkbox" value="{{ $record->id }}"
                                onclick="updateMassActionsVisibility()">
                        </td>

                        @foreach($data['columns'] as $column)
                            @if($column['visibility'])
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--color-text-primary)]">
                                    {!! $record->{$column['index']} !!}
                                </td>
                            @endif
                        @endforeach
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--color-text-primary)]">
                            @foreach($record->actions as $action)
                                @if(strtolower($action['title']) === 'edit')
                                    <a href="{{ $action['url'] }}" class="text-[var(--color-primary)] hover:text-[var(--color-primary-dark)] mr-3"
                                        title="{{ $action['title'] }}">
                                        <span class="material-icons-outlined">edit</span>
                                    </a>
                                @elseif(strtolower($action['title']) === 'delete')
                                    <button onclick="openDeleteModal('{{ $action['url'] }}')"
                                        class="text-[var(--color-danger)] hover:text-[var(--color-danger-dark)] mr-3"
                                        title="{{ $action['title'] }}">
                                        <span class="material-icons-outlined">delete</span>
                                    </button>
                                @else
                                    @if($action['method'] === 'DELETE')
                                        <button onclick="openDeleteModal('{{ $action['url'] }}')"
                                            class="btn btn-sm cursor-pointer btn-danger">
                                            {{$action['title']}}
                                        </button>
                                    @else
                                        <a href="{{ $action['url'] }}" class="text-[var(--color-primary)] hover:text-[var(--color-primary-dark)] mr-3"
                                            title="{{ $action['title'] }}">
                                            <i class="{{ $action['icon'] }}"></i>
                                        </a>
                                    @endif
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>