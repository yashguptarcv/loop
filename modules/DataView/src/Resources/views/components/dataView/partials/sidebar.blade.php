<!-- Filter Sidebar (positioned outside main flow) -->
<div id="filterSidebar"
    class="fixed inset-y-0 right-0 w-88 bg-[var(--color-white)] shadow-lg transform translate-x-full z-50 transition-transform duration-300 ease-in-out border-l border-[var(--color-border)]">
    <form method="GET" action="{{ url()->current() }}" class="h-full p-4 overflow-y-auto" id="filterForm">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-[var(--color-text-primary)]">Filters</h3>
            <button type="button" id="closeFilter"
                class="text-[var(--color-text-secondary)] hover:text-[var(--color-text-primary)] focus:outline-none">
                <span class="material-icons-outlined">close</span>
            </button>
        </div>


        <div class="space-y-6">
            @foreach($data['columns'] as $column)
                @if($column['filterable'])
                    <div>
                        <label
                            class="custom-label">{{ $column['label'] }}</label>

                        @if($column['filterable_type'] === 'dropdown' && !empty($column['filterable_options']))
                            @if($column['allow_multiple_values'])
                                @php
                                    $selectedValues = request()->input('filters.' . $column['index'], []);
                                @endphp
                                <div class="space-y-2 mt-2 max-h-60 overflow-y-auto">
                                    @foreach($column['filterable_options'] as $option)
                                        <div class="flex items-center">
                                            <input id="filter-{{ $column['index'] }}-{{ $option['value'] }}"
                                                name="filters[{{ $column['index'] }}][]" type="checkbox" value="{{ $option['value'] }}"
                                                @if(in_array($option['value'], $selectedValues)) checked @endif
                                                class="h-4 w-4 text-[var(--color-primary)] focus:ring-[var(--color-primary)] border-[var(--color-border)] rounded">
                                            <label for="filter-{{ $column['index'] }}-{{ $option['value'] }}"
                                                class="ml-3 text-sm text-[var(--color-text-secondary)]">
                                                {{ $option['label'] }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <select name="filters[{{ $column['index'] }}]" class="input-field">
                                    <option value="">Select {{ $column['label'] }}</option>
                                    @foreach($column['filterable_options'] as $option)
                                        <option value="{{ $option['value'] }}" @if(request()->has('filters.' . $column['index']) && request()->input('filters.' . $column['index']) == (int) $option['value']) selected @endif>
                                            {{ $option['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif

                        @elseif($column['filterable_type'] === 'date_range')
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs text-[var(--color-text-secondary)] mb-1">From</label>
                                    <input type="date" name="filters[{{ $column['index'] }}][0][0]"
                                        value="{{ request()->input('filters.' . $column['index'] . '.0.0') }}" class="input-field">
                                </div>
                                <div>
                                    <label class="block text-xs text-[var(--color-text-secondary)] mb-1">To</label>
                                    <input type="date" name="filters[{{ $column['index'] }}][0][1]"
                                        value="{{ request()->input('filters.' . $column['index'] . '.0.1') }}" class="input-field">
                                </div>
                            </div>

                        @elseif($column['type'] === 'boolean')
                            <div class="flex items-center">
                                <input type="checkbox" name="filters[{{ $column['index'] }}]" value="1"
                                    @if(request()->input('filters.' . $column['index']) == 1) checked @endif
                                    class="h-4 w-4 text-[var(--color-primary)] focus:ring-[var(--color-primary)] border-[var(--color-border)] rounded">
                                <label class="ml-3 text-sm text-[var(--color-text-secondary)]">{{ $column['label'] }}</label>
                            </div>

                        @else
                            <input type="{{ $column['type'] === 'integer' ? 'number' : 'text' }}"
                                name="filters[{{ $column['index'] }}]" value="{{ request()->input('filters.' . $column['index']) }}"
                                class="input-field">
                        @endif
                    </div>
                @endif
            @endforeach
        </div>

        <div class="mt-6 flex space-x-3">
            <a href="{{ url()->current() }}"
                class="flex-1 inline-flex justify-center py-2 px-4 border border-[var(--color-border)] shadow-sm text-sm font-medium rounded-md text-[var(--color-text-primary)] bg-[var(--color-white)] hover:bg-[var(--color-gray-50)]">
                Reset
            </a>
            <button type="submit"
                class="flex-1 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-[var(--color-white)] bg-[var(--color-primary)] hover:bg-[var(--color-primary-dark)]">
                Apply
            </button>
        </div>
    </form>
</div>