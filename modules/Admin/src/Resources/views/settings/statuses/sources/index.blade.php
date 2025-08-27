<form class="form-ajax" action="{{ route('admin.settings.statuses.source.store') }}" method="POST">
    @csrf

    <div class="overflow-x-auto">
        <table class="min-w-full border rounded-lg overflow-hidden shadow-sm">
            <tbody class="bg-white text-sm">
                <!-- Existing Sources -->
                @foreach($sources as $index => $source)
                    <tr class="bg-gray-50 mb-3" id="source-{{$source->id}}">
                        <td class="px-3">
                            <input
                                type="text"
                                name="sources[{{$source->id}}][name]"
                                value="{{$source->name}}"
                                placeholder="Enter name"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md" />
                            <input type="hidden" name="sources[{{$source->id}}][id]" value="{{$source->id}}">
                        </td>
                        <td class="px-3">
                            <select
                                name="sources[{{$source->id}}][is_active]"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                <option value="1" {{ old('sources.' . $source->id . '.is_active', $source->is_active) == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('sources.' . $source->id . '.is_active', $source->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </td>
                        <td class="px-3 text-center space-x-2">
                            <button type="button" class="source-remove red px-3 py-1 bg-red-100 text-red-600 border border-red-300 rounded-md hover:border-red-300 hover:text-red-300" data-source-id="{{$source->id}}">
                                <span class="material-icons-outlined mr-1 text-xs">delete</span>
                            </button>
                        </td>
                    </tr>
                @endforeach

                <!-- New Sources (dynamic) -->
                <tr class="bg-gray-50" id="new-sources-container">
                    <!-- New sources will be added here -->
                </tr>
                
                <!-- Add New Source Row -->
                <tr class="bg-gray-50">
                    <td class="px-3">
                        <input
                            type="text"
                            id="new-source-name"
                            name="sources[new][0][name]"
                            placeholder="Enter name"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md" />
                    </td>
                    <td class="px-3">
                        <select
                            id="new-source-status"
                            name="sources[new][0][is_active]"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            <option value="">-- Status --</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </td>

                    <td class="px-3 text-center space-x-2">
                        <button type="button" id="source-add" class="blue px-3 py-1 bg-blue-100 text-blue-600 border border-blue-300 rounded-md hover:border-blue-300 hover:text-blue-300">
                            <span class="material-icons-outlined mr-1 text-xs">add</span>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="flex justify-end gap-3 pt-4">
        <x-button type="submit"
                  class="blue"
                  label="Save Changes"
                  icon=""
                  name="button" />
    </div
