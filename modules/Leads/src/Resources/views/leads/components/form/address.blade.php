<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6 pb-2 border-b border-gray-200 dark:border-gray-700">
                Address Information
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Street Address
                    </label>
                    <input type="text" id="address" name="address" 
                           value="{{ old('address', $lead->address ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 @error('address') border-red-500 dark:border-red-400 @enderror">
                    @error('address')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        City
                    </label>
                    <input type="text" id="city" name="city" 
                           value="{{ old('city', $lead->city ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 @error('city') border-red-500 dark:border-red-400 @enderror">
                    @error('city')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="state" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        State/Province
                    </label>
                    <input type="text" id="state" name="state" 
                           value="{{ old('state', $lead->state ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 @error('state') border-red-500 dark:border-red-400 @enderror">
                    @error('state')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="postal_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Postal Code
                    </label>
                    <input type="text" id="postal_code" name="postal_code" 
                           value="{{ old('postal_code', $lead->postal_code ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 @error('postal_code') border-red-500 dark:border-red-400 @enderror">
                    @error('postal_code')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Country
                    </label>
                    <select id="country" name="country"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 @error('country') border-red-500 dark:border-red-400 @enderror">
                        <option value="">Select Country</option>
                        <option value="US" {{ old('country', $lead->country ?? '') == 'US' ? 'selected' : '' }}>United States</option>
                        <option value="CA" {{ old('country', $lead->country ?? '') == 'CA' ? 'selected' : '' }}>Canada</option>
                        <option value="UK" {{ old('country', $lead->country ?? '') == 'UK' ? 'selected' : '' }}>United Kingdom</option>
                        <option value="AU" {{ old('country', $lead->country ?? '') == 'AU' ? 'selected' : '' }}>Australia</option>
                        <option value="IN" {{ old('country', $lead->country ?? '') == 'IN' ? 'selected' : '' }}>India</option>
                    </select>
                    @error('country')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>