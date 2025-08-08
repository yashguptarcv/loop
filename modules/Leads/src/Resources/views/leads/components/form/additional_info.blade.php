<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6 pb-2 border-b border-gray-200 dark:border-gray-700">
        Additional Information
    </h2>
    
    <div class="mb-6">
        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            Description
        </label>
        <textarea id="description" name="description" rows="4"
            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 @error('description') border-red-500 dark:border-red-400 @enderror">{{ old('description', $lead->description ?? '') }}</textarea>
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
                    <div class="relative group">
                        <img src="{{ Storage::url($attachment->path) }}" 
                             alt="Lead attachment" 
                             class="rounded-md h-24 w-full object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ Storage::url($attachment->path) }}" target="_blank" 
                               class="text-white mr-2 hover:text-blue-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <button type="button" 
                                    class="text-white hover:text-red-300 delete-attachment"
                                    data-id="{{ $attachment->id }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="mb-6">
        <label for="tags" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            Tags
        </label>
        <input type="text" id="tags" name="tags" 
            value="{{ old('tags', isset($lead) ? implode(',', $lead->tags->pluck('name')->toArray()) : '' )}}"
            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 @error('tags') border-red-500 dark:border-red-400 @enderror"
            placeholder="Type to search tags or add new ones">
            <datalist id="tagList">
                @foreach(\Modules\Leads\Models\TagsModel::all() as $tag)
                    <option value="{{ $tag->name }}"></option>
                @endforeach
            </datalist>        
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