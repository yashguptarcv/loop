<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
    <h2 class="text-xl font-semibold text-gray-900 dark:text-white-200 mb-6 pb-2 border-b border-blue-200 dark:border-blue-700">
        Additional Information
    </h2>

    <div class="mb-6">
        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            Description
        </label>

        <textarea editor="true" id="message-editor" name="description" rows="8" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 @error('description') border-red-500 dark:border-red-400 @enderror" rows="7">{{ old('description', $lead->description ?? '') }}</textarea>

        @error('description')
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- Image Upload Section -->
    <div class="mb-6">
        <label for="images" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            Upload Images
        </label>
        <input type="file" id="images" name="images[]" multiple
            class="block w-full text-sm text-gray-500 dark:text-gray-400
                      file:mr-4 file:py-2 file:px-4
                      file:rounded-md file:border-0
                      file:text-sm file:font-semibold
                      file:bg-blue-50 dark:file:bg-gray-700 file:text-blue-700 dark:file:text-blue-300
                      hover:file:bg-blue-100 dark:hover:file:bg-gray-600
                      focus:outline-none focus:ring-2 focus:ring-blue-500"
            accept="image/*">
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Upload multiple images (JPEG, PNG, etc.)</p>
        @error('images')
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror

        <!-- Display existing images if editing -->
        @if(isset($lead) && $lead->attachments->count() > 0)
        <div class="mt-4 grid grid-cols-3 gap-2">
            @foreach($lead->attachments as $attachment)
            @php
            $filepath = Storage::disk(fn_get_setting('general.image_driver'))->url('uploads/' . strtolower('leads/'). $lead->id . '/'. $attachment->filename);
            @endphp

            <div class="border divide-gray-100 rounded-md p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-gray-100 rounded-md p-3">
                        @if(str_starts_with($attachment->mime_type, 'image/'))
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        @endif
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">{{ $attachment->original_filename }}</p>
                        <p class="text-sm text-gray-500">
                            {{ fn_format_bytes($attachment->size) }} •
                            Uploaded {{ $attachment->created_at->format('M d, Y') }}
                        </p>
                    </div>
                    <div class="ml-auto flex space-x-2">
                        @if(bouncer()->hasPermission('admin.leads.attachments.download'))

                        <x-button as="a" type="button" class="primary" label="" icon="<span class='material-icons-outlined mr-1'>file_download</span>" name='button' />
                        @endif
                        @if(bouncer()->hasPermission('admin.leads.attachments.destroy'))

                         <a onclick="openDeleteModal('{{route('admin.leads.attachments.destroy', [$lead->id, $attachment->id])}}')"
                            class="inline-flex items-center px-4 py-2 border rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 hover:text-red-300 text-red-600 bg-red-100">                            
                            <span class="material-icons-outlined">delete</span>
                        </a>

                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <!--  -->
    <div class="mb-6">
        <label for="tags" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            Tags
        </label>

        <div class="relative">
            <div id="tag-container" class="flex flex-wrap items-center gap-2 p-2 border rounded-md min-h-[42px] 
            border-gray-300 dark:border-gray-600 dark:bg-gray-700 bg-white
            @error('tags') border-red-500 dark:border-red-400 @enderror">
                <!-- Existing tags will appear here -->
                <input type="text" id="tags-input"
                    class="flex-1 min-w-[100px] px-2 py-1 bg-transparent border-0 focus:outline-none focus:ring-0
                    dark:text-gray-200 placeholder-gray-400 dark:placeholder-gray-500"
                    placeholder="Type to search tags or add new ones"
                    list="tagList" />
            </div>

            <input type="hidden" id="tags" name="tags"
                value="{{ old('tags', isset($lead) ? implode(',', $lead->tags->pluck('name')->toArray()) : '') }}" />
        </div>

        <datalist id="tagList">
            @foreach(\Modules\Leads\Models\TagsModel::all() as $tag)
            <option value="{{ $tag->name }}"></option>
            @endforeach
        </datalist>

        @error('tags')
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle attachment deletion
        document.querySelectorAll('.delete-attachment').forEach(button => {
            button.addEventListener('click', function() {
                if (confirm('Are you sure you want to delete this attachment?')) {
                    fetch(`/attachments/${this.dataset.id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.closest('.relative').remove();
                            }
                        });
                }
            });
        });
    });
</script>
@endpush