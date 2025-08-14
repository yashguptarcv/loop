    @if(!empty($lead->activities))
    @foreach($lead->activities as $activity)
    <div class="activity-item mb-2">
        <div class="flex items-start">
            @php
                $nameHash = crc32($activity->admin->name);
                $colors = [
                    'bg-red-100 text-red-600',
                    'bg-blue-100 text-blue-600',
                    'bg-green-100 text-green-600',
                    'bg-yellow-100 text-yellow-600',
                    'bg-purple-100 text-purple-600',
                    'bg-pink-100 text-pink-600',
                    'bg-indigo-100 text-indigo-600'
                ];
                $colorIndex = abs($nameHash) % count($colors);
                $colorClass = $colors[$colorIndex];
                $initials = strtoupper(substr($activity->admin->name, 0, 2));
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
    </div>
    @endforeach
    @else
        <p class="text-gray-500">No activities yet</p>
    @endif