 <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6 pb-2 border-b border-gray-200 dark:border-gray-700">
                Lead Details
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="source_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Lead Source
                    </label>
                    <select id="source_id" name="source_id"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 @error('source_id') border-red-500 dark:border-red-400 @enderror">
                        <option value="">Select Source</option>
                        @foreach($leadSources as $source)
                            <option value="{{ $source->id }}" 
                                {{ old('source_id', $lead->source_id ?? '') == $source->id ? 'selected' : '' }}>
                                {{ $source->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('source_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="industry" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Industry
                    </label>
                    <select id="industry" name="industry"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 @error('industry') border-red-500 dark:border-red-400 @enderror">
                        <option value="">Select Industry</option>
                        <option value="technology" {{ old('industry', $lead->industry ?? '') == 'technology' ? 'selected' : '' }}>Technology</option>
                        <option value="finance" {{ old('industry', $lead->industry ?? '') == 'finance' ? 'selected' : '' }}>Finance</option>
                        <option value="healthcare" {{ old('industry', $lead->industry ?? '') == 'healthcare' ? 'selected' : '' }}>Healthcare</option>
                        <option value="manufacturing" {{ old('industry', $lead->industry ?? '') == 'manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                        <option value="retail" {{ old('industry', $lead->industry ?? '') == 'retail' ? 'selected' : '' }}>Retail</option>
                        <option value="education" {{ old('industry', $lead->industry ?? '') == 'education' ? 'selected' : '' }}>Education</option>
                        <option value="other" {{ old('industry', $lead->industry ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('industry')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- <div>
                    <label for="status_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Lead Status <span class="text-red-500">*</span>
                    </label>
                    <select id="status_id" name="status_id"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 @error('status_id') border-red-500 dark:border-red-400 @enderror"
                            required>
                        <option value="">Select Status</option>
                        @foreach($leadStatuses as $status)
                            <option value="{{ $status->id }}" 
                                {{ old('status_id', $lead->status_id ?? '') == $status->id ? 'selected' : '' }}>
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('status_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div> -->
            </div>
        </div>