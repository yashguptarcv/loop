@php
$isMultiple = $isMultiple ?? false;
$images = [];

if(!empty($object_type)) {
    
    $images = fn_get_images($object_type, $object_id);
}
$input_name = $name ?? 'image';
$store = $store ?? true;
@endphp

<div class="flex flex-col gap-6">
    <!-- Existing & New Previews -->
    <div id="previewContainer" class="preview-container flex flex-wrap gap-4">
        @if(!empty($images) && $store)
        @foreach($images as $img)
        <div class="relative border rounded-lg p-2 w-[160px] h-[180px] flex flex-col justify-between items-center bg-white shadow existing-image" data-id="{{$img['id']}}">
            <img src="{{$img['url']}}" class="h-[100px] w-full object-contain rounded">

            <input type="hidden" name="existing_ids[]" value="{{$img['id']}}">

            <a onclick="openDeleteModal('{{route('admin.filemanager.delete', [$img['id']])}}', false)"
                class="text-red-600 hover:text-red-300 mr-3 cursor-pointer">
                <span class="material-icons-outlined">delete</span>

            </a>
            <input type="text" name="existing_alts[{{$img['id']}}]"
                value="{{$img['alt_text']}}"
                class="mt-2 px-2 py-1 border border-gray-300 rounded text-sm w-full"
                placeholder="Alt text">


        </div>
        @endforeach
        @endif
    </div>

    <!-- File Input -->
    <div class="image-uploader btn-group flex space-x-2 mb-5 border border-gray-300 rounded-lg p-2">
        <input type="file" name="{{$input_name}}" id="imageInput" @if($isMultiple) multiple @endif
            class="btn flex-1 py-2 px-4 bg-white text-gray-700 font-medium hover:bg-gray-50">
        <button type="button" class="btn flex-1 py-2 px-4 bg-white text-gray-700 font-medium hover:bg-gray-50">
            Filemanager
        </button>
    </div>
</div>