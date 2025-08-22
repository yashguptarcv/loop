<form class="form-ajax" action="{{route('admin.settings.statuses.tags.store')}}" method="POST">
    @csrf

    <div class="overflow-x-auto">
        <table class="min-w-full border rounded-lg overflow-hidden shadow-sm">
            <tbody class="bg-white text-sm">
                <!-- Input Row -->
                @foreach($tags as $index => $tag)
                <tr class="bg-gray-50 mb-3" id="tag-{{$tag->id}}">

                    <td class="px-3">
                        <input
                            type="text"
                            name="tags[{{$tag->id}}][name]"
                            value="{{$tag->name}}"
                            placeholder="Enter name"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md" />
                    </td>
                    <td class="px-3">
                        <input
                            type="text"
                            name="tags[{{$tag->id}}][color]"
                            value="{{$tag->color}}"
                            placeholder="Enter color"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md" />
                    </td>
                    

                    <td class="px-3 text-center space-x-2">
                        <button type="button" class="tag-remove red px-3 py-1 bg-red-100 text-red-600 border border-red-300 rounded-md hover:border-red-300 hover:text-red-300" data-tag-id="{{$tag->id}}">
                            <span class="material-icons-outlined mr-1 text-xs">delete</span>
                        </button>
                    </td>
                    <input type="hidden" name="tags[{{$tag->id}}][id]" value="{{$tag->id}}">
                </tr>
                @endforeach
                <tr class="bg-gray-50" id="new-tags-container">
                    <!-- New tags will be added here -->
                </tr>
                <tr class="bg-gray-50">
                    <td class="px-3">
                        <input
                            type="text"
                            id="new-tag-name"
                            name="tags[new][0][name]"
                            placeholder="Enter name"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md" />
                    </td>
                    <td class="px-3">
                        <input
                            type="text"
                            id="new-tag-color"
                            name="tags[new][0][color]"
                            placeholder="Enter color"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md" />
                    </td>
                    

                    <td class="px-3 text-center space-x-2">
                        <button type="button" id="tag-add" class="blue px-3 py-1 bg-blue-100 text-blue-600 border border-blue-300 rounded-md hover:border-blue-300 hover:text-blue-300">
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
            icon=''
            name="button" />
    </div>
</form>