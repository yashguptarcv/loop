@if($items->count() > 0)
@foreach($items as $application)
<div class="activity-item space-y-4">
    <div class="flex items-start">
        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 text-sm font-bold mr-3">
            SYS
        </div>
        <div>
            <div class="flex items-center">
                <p class="font-medium text-gray-900">Application ID #{{ $application->id }}</p>
                <span class="mx-2 text-gray-400">•</span>
                <span class="text-sm text-gray-500">{{ $application->created_at->diffForHumans() }}</span>
            </div>
            <p class="text-gray-700">{!! $application->full_name !!}</p>
        </div>
    </div>
</div>
@endforeach
@else
    <p class="bg-blue-100 text-blue-600 px-3 py-2">No application send yet.</p>
@endif