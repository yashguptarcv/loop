<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    @foreach($data['columns'] as $column)
                        @if($column['visibility'])
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                @if($column['sortable'])
                                    <div class="flex items-center">
                                        @php
                                            $currentSort = request('sort', []);
                                            $isSortedColumn = isset($currentSort['column']) && $currentSort['column'] === $column['index'];
                                            $nextOrder = $isSortedColumn && ($currentSort['order'] ?? 'asc') === 'asc' ? 'desc' : 'asc';
                                        @endphp
                                        <a href="{{ request()->fullUrlWithQuery(['sort[column]' => $column['index'], 'sort[order]' => $nextOrder]) }}"
                                            class="hover:text-gray-700 flex items-center">
                                            {{ $column['label'] }}

                                            @if($isSortedColumn)
                                                <span class="ml-1">
                                                    @if(($currentSort['order'] ?? 'asc') === 'asc')
                                                        {{-- Up Arrow --}}
                                                        <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M10 6l-4 4h8l-4-4z" />
                                                        </svg>
                                                    @else
                                                        {{-- Down Arrow --}}
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
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($data['records'] as $record)
                    <tr>
                        @foreach($data['columns'] as $column)
                            @if($column['visibility'])
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {!! $record->{$column['index']} !!}
                                </td>
                            @endif
                        @endforeach
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @foreach($record->actions as $action)

                                @if($action['method'] === 'DELETE')
                                    <button onclick="openDeleteModal('{{ $action['url'] }}')"
                                        class="btn btn-sm cursor-pointer btn-danger">
                                        Delete
                                    </button>
                                @else
                                    <a href="{{ $action['url'] }}" class="text-indigo-600 hover:text-indigo-900 mr-3"
                                        title="{{ $action['title'] }}">
                                        <i class="{{ $action['icon'] }}"></i>&nbsp;{{$action['title'] }}
                                    </a>
                                @endif

                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>