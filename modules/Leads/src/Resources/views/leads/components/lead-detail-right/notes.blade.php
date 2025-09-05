@if(request()->ajax())
    {{-- Render wrapper only for first load --}}
    @if($items->count() > 0)
        <div class="space-y-4">
    @endif
@endif

{{-- Always render notes --}}
<div id="render_url_lead" data-next-page="{{ $items->nextPageUrl() }}"
                data-current="{{ $items->currentPage() }}"
                data-total="{{ $items->lastPage() }}">
@foreach($items as $notes)
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 space-y-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" 
                          d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" 
                          clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700">
                    {!! $notes->note !!}
                </p>
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
    @if($items->count() > 0)
        </div> {{-- close wrapper --}}
    @else
        <p class="bg-primary-100 text-amber-100 px-3 py-2">No notes yet.</p>
    @endif
@else
    @if($items->count() === 0)
        <p class="bg-primary-100 text-amber-100 px-3 py-2">No notes yet.</p>
    @endif
@endif
