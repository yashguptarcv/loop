<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6 pb-2 border-b border-gray-200 dark:border-gray-700">
                Company Information
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="company" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Company
                    </label>
                    <input type="text" id="company" name="company" 
                           value="{{ old('company', $lead->company ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 @error('company') border-red-500 dark:border-red-400 @enderror">
                    @error('company')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="job_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Job Title
                    </label>
                    <input type="text" id="job_title" name="job_title" 
                           value="{{ old('job_title', $lead->job_title ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 @error('job_title') border-red-500 dark:border-red-400 @enderror">
                    @error('job_title')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>