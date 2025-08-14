@if($lead->attachments->count() > 0)

<div class="space-y-4">
    @foreach($lead->attachments as $attachment)
    <div class="border border-gray-200 rounded-md p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-gray-100 rounded-md p-3">
                @if(str_starts_with($attachment->mime_type, 'image/'))
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                @else
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                @endif
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-900">{{ $attachment->original_filename }}</p>
                <p class="text-sm text-gray-500">
                    {{ fn_format_bytes($attachment->size) }} •
                    Uploaded {{ $attachment->created_at->format('M d, Y') }}
                </p>
            </div>
            <div class="ml-auto flex space-x-2">
                @if(bouncer()->hasPermission('admin.leads.attachments.download'))
                <a href="{{route('admin.leads.attachments.download', [$lead->id, $attachment->id])}}"
                    class="text-blue-600 hover:text-blue-800"
                    title="Download">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                </a>
                @endif
                @if(bouncer()->hasPermission('admin.leads.attachments.destroy'))
                @can('delete', $attachment)
                <form action="{{route('admin.leads.attachments.destroy', [$lead->id, $attachment->id])}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800" title="Delete">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </form>
                @endcan
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="text-center py-8">
    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
    </svg>
    <h3 class="mt-2 text-sm font-medium text-gray-900">No attachments</h3>
</div>
@endif