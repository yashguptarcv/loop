@foreach($leads as $lead)
@php
    list($initials, $colorClass) = fn_get_name_placeholder($lead->createdBy->name);
@endphp
<div class="lead-card bg-white border border-gray-200 rounded-lg p-4 cursor-move" 
     draggable="true" data-lead-id="{{ $lead->id }}">
     <div class="flex items-center mb-2 mt-2 gap-3">
        <div class="text-xs text-gray-500">{{ $lead->created_at->diffForHumans() }}</div>
        <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold mr-1 {{ $colorClass }}">{{ $initials }}</div>
        <div class="flex-1">
            <div class="flex items-center">
                <p class="font-small text-gray-900 text-sm truncate max-w-[180px]">{{ $lead->createdBy->name }}</p>
            </div>
        </div>
    </div>
    <div class="flex justify-between items-start mb-2">
        <h3 class="font-medium text-gray-900">
            @if(bouncer()->hasPermission('admin.leads.show'))    
                <a class="truncate max-w-[180px]" href="{{route('admin.leads.show', $lead->id)}}">{{ $lead->name }}</a>
            @else
                <a class="truncate max-w-[180px]" href="#">{{ $lead->name }}</a>
            @endif
        </h3>
    </div>
    <div class="mt-2 mb-2">
        <div class="flex flex-wrap gap-1">
            @foreach($lead->tags as $tag)
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                        @if($tag->color) bg-{{ $tag->color }}-100 text-{{ $tag->color }}-800 
                        dark:bg-{{ $tag->color }}-900 dark:text-{{ $tag->color }}-200
                        @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                    {{ $tag->name }}                                   
                </span>
            @endforeach
        </div>
    </div>
    
    <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-gray-500">
        @if($lead->email)
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <span class="truncate max-w-[180px]">{{ $lead->email }}</span>
        </div>
        @endif
        
        @if($lead->phone)
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
            </svg>
            {{ $lead->phone }}
        </div>
        @endif
    </div>
</div>
@endforeach