    @if($items->count() > 0 || $lead->description)
    <div class="activity-item space-y-4">
        <div class="flex items-start">
            <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold mr-2 bg-blue-100 text-blue-600">
                <span class="material-icons-outlined">push_pin</span>
            </div>
            <div class="flex-1">
                <div class="flex items-center">
                    <p class="font-medium text-gray-900">{{ $lead->createdBy->name }}</p>
                </div>
                <div class="prose max-w-none text-gray-700">
                    {!! $lead->description !!}
                </div>
            </div>
        </div>
    @foreach($items as $activity)
        <div class="flex items-start">
            @php
                list($initials, $colorClass) = fn_get_name_placeholder($activity->admin->name);
            @endphp
            
            <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold mr-3 {{ $colorClass }}">
                {{ $initials }}
            </div>
            <div class="flex-1">
                <div class="flex items-center">
                    <p class="font-medium text-gray-900">{{ $activity->admin->name }}</p>
                    <span class="mx-2 text-gray-400">•</span>
                    <span class="text-sm text-gray-500">{{ $activity->created_at->diffForHumans() }}</span>
                    <span class="ml-2 px-2 py-1 text-xs rounded-full 
                        @if($activity->type === 'call') bg-blue-100 text-blue-800
                        @elseif($activity->type === 'email') bg-green-100 text-green-800
                        @elseif($activity->type === 'meeting') bg-purple-100 text-purple-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst($activity->type) }}
                    </span>
                </div>
                <div class="prose max-w-none mt-2 text-gray-700">
                    {!! $activity->description !!}
                </div>
                @if($activity->duration_minutes > 0)
                <div class="mt-2 text-sm text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Duration: {{ $activity->duration_minutes }} minutes
                </div>
                @endif
            </div>
        </div>
    @endforeach
    </div>
    @else
        <p class="bg-blue-100 text-blue-600 px-3 py-2">No activities yet</p>
    @endif