@php
    $pagination = request('pagination', []);
    $currentPage = $pagination['page'] ?? $data['current_page'];
    $perPage = $pagination['per_page'] ?? $data['per_page'];
@endphp

<div class="flex items-center justify-between mt-4 px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
    
    <!-- Desktop view -->
    <div class="flex-1 flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-700">
                Showing <span class="font-medium">{{ $data['from'] }}</span> to
                <span class="font-medium">{{ $data['to'] }}</span> of
                <span class="font-medium">{{ $data['total'] }}</span> results
            </p>
        </div>
    </div>
</div>