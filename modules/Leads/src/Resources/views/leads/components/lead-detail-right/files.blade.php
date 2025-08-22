@if($items->count() > 0)

<div class="space-y-4">
    @foreach($items as $attachment)
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
                
                    <x-button as="a" type="button"  class="blue" label="" icon="<span class='material-icons-outlined mr-1'>file_download</span>" name='button'/> 
                @endif
                @if(bouncer()->hasPermission('admin.leads.attachments.destroy'))
                
                <form action="{{route('admin.leads.attachments.destroy', [$lead->id, $attachment->id])}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <x-button type="submit"  class="red" label="" icon="<span class='material-icons-outlined mr-1'>delete</span>" name='button'/> 
                    
                </form>
                
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<p class="bg-blue-100 text-blue-600 px-3 py-2">No attachments available.</p>
@endif