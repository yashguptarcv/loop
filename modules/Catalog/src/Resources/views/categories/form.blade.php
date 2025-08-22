@extends('admin::layouts.app')

@section('title', isset($category) ? 'Edit Category' : 'Create Category')

@section('content')
@include('admin::components.common.back-button', ['route' => route('admin.catalog.categories.index'), 'name' => isset($category) ? 'Edit Category' : 'Create Category'])

<form id="categoryForm" class="form-ajax grid grid-cols-1 lg:grid-cols-3 gap-6" method="POST"
    action="@isset($category) {{ route('admin.catalog.categories.update', $category->id) }} @else {{ route('admin.catalog.categories.store') }} @endisset"
    enctype="multipart/form-data">
    @csrf
    @isset($category) @method('PUT') @endisset

    <!-- Left Column (2/3) -->
    <div class="lg:col-span-2 bg-white rounded-lg  p-6 space-y-6">

        <!-- Description -->
        
        <div>
            <label class="custom-label">Description</label>
            <textarea id="message-editor" editor="true" name="description" rows="8"
                class="hidden">{{ old('description', $category->description ?? '') }}</textarea>
        </div>

        <!-- Parent Category -->
        <div id="auto-complete">
            <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Parent Category</label>
            <input
                type="text"
                autocomplete="dropdown"
                name="country_name"
                value="{{fn_get_category_name($category->parent_id ?? 0)}}"
                placeholder=""
                id="input-parent_id"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                data-table="categories"
                data-select_columns="id, name"
                data-search_column="name"
                data-target="parent_id"
                data-original-value="" />
            <input
                type="hidden"
                name="parent_id"
                id="parent_id"
                value="{{$category->parent_id ?? ''}}"
                class="mt-1"
                data-original-value="" />
        </div>

        <!-- Category Image -->
       @include('filemanager::components.file-uploader', ['object_type' => 'category', 'object_id' => $category->id ?? 0, 'name' => 'image'])

        <!-- Meta Title -->
        <div>
            <label class="custom-label">Meta Title</label>
            <input type="text" name="meta_title" class="input-field"
                value="{{ old('meta_title', $category->meta_title ?? '') }}">
        </div>

        <!-- Meta Description -->
        <div>
            <label class="custom-label">Meta Description</label>
            <input type="text" name="meta_description" class="input-field"
                value="{{ old('meta_description', $category->meta_description ?? '') }}">
        </div>

        <!-- Meta Keywords -->
        <div>
            <label class="custom-label">Meta Keywords</label>
            <input type="text" name="meta_keywords" class="input-field"
                value="{{ old('meta_keywords', $category->meta_keywords ?? '') }}">
        </div>
    </div>

    <!-- Right Column (1/3) -->
    <div class="bg-white rounded-lg  p-6 space-y-6">
        <h3 class="text-lg font-medium text-gray-900 mb-3">Basic Info</h3>
        <!-- Name -->
        <div>
            <label class="custom-label">Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $category->name ?? '') }}"
                class="input-field" >
        </div>

        <!-- Slug -->
        <div>
            <label class="custom-label">Slug</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug', $category->slug ?? '') }}"
                class="input-field">
        </div>

        <div>
            <label class="custom-label">Status</label>
            
                <select name="status" class="w-full bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-md leading-tight">
                    <option value="A" @if(!empty($category->status) && $category->status == 'A')selected @endif>Active</option>
                    <option value="D" @if(!empty($category->status) && $category->status == 'D')selected @endif>Inactive</option>
                </select>
        </div>

        <!-- Position -->
        <div>
            <label class="custom-label">Position</label>
            <input type="number" name="position" id="position"
                value="{{ old('position', $category->position ?? 0) }}" class="input-field">
        </div>

        <!-- Status Toggle -->


        <div class="flex justify-end">

            <x-button type="submit"
                class="blue"
                label="Save"
                icon=''
                name="button" />
        </div>
    </div>
</form>

@endsection

@section('scripts')
<script>
    document.getElementById('name').addEventListener('input', function() {
        const nameValue = this.value.trim();
        document.getElementById('slug').value = nameValue
            .toLowerCase()
            .replace(/\s+/g, '-')
            .replace(/[^a-z0-9\-]/g, ''); // Remove invalid chars
    });

    document.getElementById('slug').addEventListener('input', function() {
        this.value = this.value
            .toLowerCase()
            .replace(/\s+/g, '-')
            .replace(/[^a-z0-9\-]/g, '');
    });
</script>

<script>
    // TinyMCE
    tinymce.init({
        selector: '#message-editor',
        plugins: 'link lists mentions',
        toolbar: 'undo redo | bold italic | bullist numlist | link | mentions',
        menubar: false,
        statusbar: false,
        height: 200,
        setup: function(editor) {
            editor.on('change', function() {
                document.getElementById('activity-description').value = editor.getContent();
            });
        }
    });

    // Image preview
    document.getElementById('image').addEventListener('change', function(e) {
        const preview = document.getElementById('image-preview');
        const file = e.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        }
    });
</script>
@endsection