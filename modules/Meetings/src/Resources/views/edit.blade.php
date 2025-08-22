

        <form class="form-ajax" action="{{ route('admin.meetings.update', $meeting) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
                    <input type="text" name="title" value="{{ old('title', $meeting->title) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md">{{ old('description', $meeting->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Time *</label>
                        <input type="datetime-local" name="start_time" 
                               value="{{ old('start_time', \Carbon\Carbon::parse($meeting->start_time)->format('Y-m-d\TH:i')) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                        @error('start_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Slots</label>
                            <input type="text" name="end_time" class="w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="{{$meeting->end_time}}">
                            <small class="text-blue-600">Example: 10, 30, 50 Minutes.</small>
                        @error('end_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                    <input type="text" name="location" value="{{ old('location', $meeting->location) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex justify-end">
                    <x-button type="submit"                     
                        class="blue" 
                        label="Save" 
                        icon=''
                        name="button" 
                    />
                </div>
            </div>
        </form>
    