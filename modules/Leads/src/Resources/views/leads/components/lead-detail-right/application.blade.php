@if(request()->ajax())
    
    @if($items->count() > 0)
        <div class="activity-item space-y-4">
    @endif
@endif
<div id="render_url_lead" data-next-page="{{ $items->nextPageUrl() }}"
                data-current="{{ $items->currentPage() }}"
                data-total="{{ $items->lastPage() }}">
@foreach($items as $application)
    <div class="activity-item space-y-4">
        <div class="flex items-start">
            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 text-sm font-bold mr-3">
                SYS
            </div>
            <div>
                <div class="flex items-center">
                    <p class="font-medium text-gray-900">
                        Application ID #{{ $application->id }}
                    </p>
                    <span class="mx-2 text-gray-400">•</span>
                    <span class="text-sm text-gray-500">
                        {{ $application->created_at->diffForHumans() }}
                    </span>
                </div>
                <p class="text-gray-700">{!! $application->full_name !!}</p>
            </div>
        </div>
    </div>
@endforeach

{{-- Load More Button (always included) --}}
<div class="flex justify-center my-4" id="load-more-wrapper">
    @if ($items->hasMorePages())
        <button id="load-more-btn"
            class="rounded-full bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 text-sm font-medium"
            data-next-page="{{ $items->currentPage() + 1 }}">
            Load More ({{ $items->currentPage() }} / {{ $items->lastPage() }})
        </button>
    @endif
</div>
</div>

@if(request()->ajax())
    {{-- close wrapper or show "empty" --}}
    @if($items->count() > 0)
        </div> {{-- close wrapper --}}
    @else
        <p class="bg-primary-100 text-amber-100 px-3 py-2">
            No application sent yet.
        </p>
    @endif
@else
    {{-- Non-ajax (initial tab load) empty state --}}
    @if($items->count() === 0)
        <p class="bg-primary-100 text-amber-100 px-3 py-2">
            No application sent yet.
        </p>
    @endif
@endif
