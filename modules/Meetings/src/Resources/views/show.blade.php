<div class="bg-white rounded-lg shadow overflow-hidden">
    <!-- Header Section -->
    <div class="bg-blue-600 px-6 py-4">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-medium text-white">{{ $meeting->title }}</h2>
            <div class="text-white">
                {{ \Carbon\Carbon::parse($meeting->start_time)->format('D, M j') }}
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="px-6 py-4">
        <!-- Time/Location Card -->
        <div class="mb-6 p-4 border rounded-lg">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0 mt-1">
                    <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Time</p>
                    <p class="text-base font-medium text-gray-900">
                        {{ \Carbon\Carbon::parse($meeting->start_time)->format('g:i A') }} - 
                        {{ \Carbon\Carbon::parse($meeting->end_time)->format('g:i A') }}
                        <span class="text-gray-500">({{ \Carbon\Carbon::parse($meeting->start_time)->diffInHours(\Carbon\Carbon::parse($meeting->end_time)) }} hours)</span>
                    </p>
                </div>
            </div>

            @if($meeting->location)
            <div class="flex items-start space-x-4 mt-4">
                <div class="flex-shrink-0 mt-1">
                    <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Location</p>
                    <p class="text-base font-medium text-gray-900">{{ $meeting->location }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Description Section -->
        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-3">Description</h3>
            <div class="prose max-w-none text-gray-700 bg-gray-50 p-4 rounded-lg">
                {!! $meeting->description ?? '<span class="text-gray-400 italic">No description provided</span>' !!}
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
            <x-button type="submit" 
                id="modal-meeting-delete"
                class="red" 
                label="Delete" 
                icon='' 
                />   
                <!-- :calls="[
                    'onclick'     => 'openDeleteModal('{{ route('admin.meetings.destroy', $meeting->id)}}')'
                    ]" -->
    </div>
</div>