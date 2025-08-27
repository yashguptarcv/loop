<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
<h2 class="text-xl font-semibold text-gray-900 dark:text-white-200 mb-6 pb-2 border-b border-blue-200 dark:border-blue-700">
                Personal Information
            </h2>
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" 
                           value="{{ old('name', $lead->name ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 @error('name') border-red-500 dark:border-red-400 @enderror"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
</div>