@extends('admin::layouts.app')

@section('title', isset($Page) ? 'Edit Page' : 'Create Page')

@section('content')
@include('admin::components.common.back-button', ['route' => route('admin.pages.index'), 'name' => isset($page) ? 'Edit page' : 'Create Page'])

<form id="pageForm" class="form-ajax grid grid-cols-1 lg:grid-cols-3 gap-6" method="POST"
    action="@isset($page) {{ route('admin.pages.update', $page->id) }} @else {{ route('admin.pages.store') }} @endisset"
    enctype="multipart/form-data">
    @csrf
    @isset($page) @method('PUT') @endisset

    <!-- Left Column (2/3) -->
    <div class="lg:col-span-2 bg-white rounded-lg p-6 space-y-6">
        <!-- meta_description -->
        <div>
            <label class="custom-label">Meta Description</label>
            <textarea id="message-editor"  name="meta_description" rows="4" class="input-field"
                >{{ old('meta_description', $page->meta_description ?? '') }}</textarea>
        </div>

        @include('filemanager::components.file-uploader', ['object_type' => 'page', 'object_id' => $page->id ?? 0, 'name' => 'meta_og_image'])
        <!-- Image -->


        <!-- meta keywords -->
         <div>
            <label class="custom-label ">Meta Keyword </label>
            <input type="text" name="meta_keywords" id="meta_keywords"
                value="{{ old('meta_keywords', $page->meta_keywords ?? '') }}"
                class="input-field">
        </div>
       
        <!-- page view -->
         <div>
            <label class="custom-label ">Page view</label>
            <select name="view" id="view" class="input-field">
                <option value="shop::shop.page" {{ old('view', $page->view ?? '') == 'shop::shop.page' ? 'selected' : '' }}>Default Page</option>
                <option value="shop::shop.index" {{ old('view', $page->view ?? '') == 'shop::shop.index' ? 'selected' : '' }}>Home Page</option>
                <option value="shop::shop.about" {{ old('view', $page->view ?? '') == 'shop::shop.about' ? 'selected' : '' }}>About Page</option>
                <option value="shop::shop.destination" {{ old('view', $page->view ?? '') == 'shop::shop.destination' ? 'selected' : '' }}>Destination Page</option>
                <option value="custom" {{ !in_array(old('view', $page->view ?? ''), ['shop::shop.page', 'shop::shop.index', 'shop::shop.about', 'shop::shop.destination']) ? 'selected' : '' }}>Custom View</option>
            </select>
            <input type="text" name="custom_view" id="custom_view" placeholder="Enter custom view path"
                value="{{ !in_array(old('view', $page->view ?? ''), ['shop::shop.page', 'shop::shop.index', 'shop::shop.about', 'shop::shop.destination']) ? old('view', $page->view ?? '') : '' }}"
                class="input-field mt-2" @if(in_array(old('view', $page->view ?? ''), ['shop::shop.page', 'shop::shop.index', 'shop::shop.about', 'shop::shop.destination'])) style="display: none;" @endif>
        </div>
       

        <!-- page content -->
        <div>
            <label class="custom-label">Page content</label>
            <textarea id="message-editor"  name="content" rows="4" class="input-field"
                >{{ old('content', $page->content ?? '') }}</textarea>
        </div>
    </div>

    <!-- Right Column (1/3) -->
    <div class="bg-white rounded-lg p-6 space-y-6">
        <h3 class="text-lg font-medium text-gray-900 mb-3">Basic Info</h3>
        <!-- Title -->
        <div>
            <label class="custom-label ">Title </label>
            <input type="text" name="title" id="title"
                value="{{ old('title', $page->title ?? '') }}"
                class="input-field" >
        </div>

        <!-- Slug -->
        <div>
            <label class="custom-label ">Slug</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug', $page->slug ?? '') }}"
                class="input-field">
        </div>

        <!-- meta title -->
        <div>
            <label class="custom-label ">Meta Title </label>
            <input type="text" name="meta_title" id="meta_title"
                value="{{ old('meta_title', $page->meta_title ?? '') }}"
                class="input-field">
        </div>

        <!-- Status -->
        <div>
            <label class="custom-label ">Status</label>
            <select name="status" id="status" class="input-field">
                <option value="active" {{ old('status', $page->status ?? 'active') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $page->status ?? 'active') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>


        <div class="flex justify-end">
            <x-button type="submit"
                class="primary"
                label="Save"
                icon=''
                name="button" />
        </div>
    </div>
</form>

@endsection

@section('scripts')
<script>
    // Function to generate slug from text
    function generateSlug(text) {
        return text
            .toLowerCase()
            .trim()
            .replace(/\s+/g, '-')
            .replace(/[^a-z0-9\-]/g, '');
    }

    // Auto-generate slug from title
    document.getElementById('title').addEventListener('input', function() {
        const slugField = document.getElementById('slug');
        // Only auto-generate if slug field is empty or hasn't been manually edited
        if (!slugField.dataset.manuallyEdited) {
            slugField.value = generateSlug(this.value);
        }
    });

    // Format slug when manually typed
    document.getElementById('slug').addEventListener('input', function() {
        // Mark as manually edited
        this.dataset.manuallyEdited = 'true';
        this.value = generateSlug(this.value);
    });

    // Reset manual edit flag when slug is cleared
    document.getElementById('slug').addEventListener('focus', function() {
        if (this.value === '') {
            delete this.dataset.manuallyEdited;
        }
    });

    // Handle view selection and custom view input
    document.getElementById('view').addEventListener('change', function() {
        const customViewInput = document.getElementById('custom_view');
        if (this.value === 'custom') {
            customViewInput.style.display = 'block';
            customViewInput.setAttribute('name', 'view');
        } else {
            customViewInput.style.display = 'none';
            customViewInput.removeAttribute('name');
        }
    });
</script>
@endsection