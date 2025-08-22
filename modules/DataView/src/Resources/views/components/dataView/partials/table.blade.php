<div class="bg-[var(--color-white)] shadow overflow-hidden sm:rounded-lg">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-green-100">
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
            <tbody class="bg-white-600 divide-y divide-green-100">
                @foreach($data['records'] as $record)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if(!empty($record->{$data['meta']['primary_column']}))
                            <input type="checkbox" class="row-checkbox" value="{{ $record->{$data['meta']['primary_column']} }}"
                                onclick="updateMassActionsVisibility()">
                            @endif
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
                            
                                @if($action['method'] === 'DELETE')
                                    <button onclick="openDeleteModal('{{ $action['url'] }}')"
                                        class="text-red-600 hover:text-red-300 mr-3 cursor-pointer">
                                        
                                        <span class="material-icons-outlined">{{$action['icon']}}</span>
                                    </button>
                                @else
                                    @if(!empty($action['is_popup'])) 
                                        @php
                                            $title = isset($action['icon']) ? "<span class='material-icons-outlined'>".$action['icon']."</span>" : $action['title'] ;
                                        @endphp
                                        <x-modal 
                                            buttonText="{!! $title !!}"
                                            modalTitle="{{ $action['title'] }}"
                                            id="{{$action['index']}}"
                                            ajaxUrl="{{ $action['url'] }}"
                                            color="blue"
                                            modalSize="3xl"
                                        />
                                    @else
                                        <a href="{{ $action['url'] }}" class="text-blue-600 hover:text-blue-300 mr-3"
                                            title="{{ $action['title'] }}">
                                            @if($action['icon'])
                                                <span class="material-icons-outlined">{{ $action['icon'] }}</span>
                                            @else
                                                {{ $action['title'] }}
                                            @endif
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