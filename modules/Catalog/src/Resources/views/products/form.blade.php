@extends('admin::layouts.app')

@section('title', isset($product) ? 'Edit Product' : 'Create Product')

@section('content')
@include('admin::components.common.back-button', ['route' => route('admin.catalog.products.index'), 'name' => isset($product) ? 'Edit Product' : 'Create Product'])

<form id="productForm" class="form-ajax grid grid-cols-1 lg:grid-cols-3 gap-6" method="POST"
    action="@isset($product) {{ route('admin.catalog.products.update', $product->id) }} @else {{ route('admin.catalog.products.store') }} @endisset"
    enctype="multipart/form-data">
    @csrf
    @isset($product) @method('PUT') @endisset

    <!-- Left Column (2/3) -->
    <div class="lg:col-span-2 bg-white rounded-lg p-6 space-y-6">        
        <!-- Description -->
        <div>
            <label class="custom-label">Description</label>
            <textarea id="message-editor" editor="true" name="description" rows="8"
                class="hidden">{{ old('description', $product->description ?? '') }}</textarea>
        </div>

        @include('filemanager::components.file-uploader', ['object_type' => 'product', 'object_id' => $product->id ?? 0, 'name' => 'image'])
        <!-- Image -->
      

        <!-- Pricing -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="custom-label">Price <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" name="price" id="price" 
                    value="{{ old('price', $product->price ?? '') }}" 
                    class="input-field" required>
            </div>
            <div>
                <label class="custom-label">Sale Price</label>
                <input type="number" step="0.01" name="sale_price" id="sale_price" 
                    value="{{ old('sale_price', $product->sale_price ?? '') }}" 
                    class="input-field">
            </div>
        </div>

        <div class="mb-6">
            <label for="tags" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Tags
            </label>
            
         <div class="relative">
            <div id="tag-container" class="flex flex-wrap items-center gap-2 p-2 border rounded-md min-h-[42px] 
                border-gray-300 dark:border-gray-600 dark:bg-gray-700 bg-white
                @error('tags') border-red-500 dark:border-red-400 @enderror">
                <!-- Existing tags will appear here -->
                <input type="text" id="tags-input" 
                    class="flex-1 min-w-[100px] px-2 py-1 bg-transparent border-0 focus:outline-none focus:ring-0
                        dark:text-gray-200 placeholder-gray-400 dark:placeholder-gray-500"
                    placeholder="Type to search tags or add new ones"
                    list="tagList" />
            </div>
            
            <input type="hidden" id="tags" name="tags" 
                value="{{ old('tags', isset($product) ? implode(',', $product->tags->pluck('name')->toArray()) : '') }}" />
        </div>

        <datalist id="tagList">
            @foreach(\Modules\Leads\Models\TagsModel::all() as $tag)
                <option value="{{ $tag->name }}"></option>
            @endforeach
        </datalist>

        @error('tags')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
        </div>
    </div>

    <!-- Right Column (1/3) -->
    <div class="bg-white rounded-lg p-6 space-y-6">
        <h3 class="text-lg font-medium text-gray-900 mb-3">Basic Info</h3>
        <!-- Name -->
        <div>
            <label class="custom-label">Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" 
                value="{{ old('name', $product->name ?? '') }}" 
                class="input-field" required>
        </div>

         <!-- Slug -->
        <div>
            <label class="custom-label">Slug</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug', $category->slug ?? '') }}"
                class="input-field">
        </div>

        <!-- Categories (Multiple Select) -->
        <div>
            <label class="custom-label">Categories</label>
            <select name="categories[]" id="categories" multiple
                class="w-full bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-md leading-tight h-auto">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                        @if(isset($product) && $product->categories->contains($category->id)) selected @endif>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Inventory Management -->
        <div class="border-t border-gray-200 pt-4">
            <h3 class="text-lg font-medium text-gray-900 mb-3">Inventory</h3>
            
            <!-- Track Stock -->
            <div class="flex items-center mb-3">
                <input type="hidden" id="track_stock" name="track_stock" value="N">
                <input type="checkbox" id="track_stock" name="track_stock" value="Y" 
                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                    {{ (isset($product) && $product->track_stock === 'Y') ? 'checked' : '' }}>
                <label for="track_stock" class="ml-2 block text-sm text-gray-900">
                    Track stock quantity
                </label>
            </div>

            <!-- Stock Fields (shown/hidden based on track_stock) -->
            <div id="stock_fields" class="{{ (isset($product) && $product->track_stock === 'Y') ? '' : 'hidden' }} space-y-3">
                <div>
                    <label class="custom-label">Stock Quantity</label>
                    <input type="number" name="stock_quantity" id="stock_quantity" 
                        value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}" 
                        class="input-field">
                </div>

                <!-- Stock Status -->
                <div>
                    <label class="custom-label">Stock Status</label>
                    <select name="stock_status" class="w-full bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-md leading-tight">
                        <option value="in_stock" {{ (isset($product) && $product->stock_status == 'in_stock') ? 'selected' : '' }}>In Stock</option>
                        <option value="out_of_stock" {{ (isset($product) && $product->stock_status == 'out_of_stock') ? 'selected' : '' }}>Out of Stock</option>
                        <option value="backorder" {{ (isset($product) && $product->stock_status == 'backorder') ? 'selected' : '' }}>Available on Backorder</option>
                    </select>
                </div>

            </div>

            <!-- SKU -->
            <div class="mt-3">
                <label class="custom-label">SKU</label>
                <input type="text" name="sku" id="sku" 
                    value="{{ old('sku', $product->sku ?? '') }}" 
                    class="input-field">
            </div>
        </div>

        <!-- Status -->
        <div>
            <label class="custom-label">Status</label>
            <select name="status" class="w-full bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-md leading-tight">
                @foreach($statuses as $key => $status)
                    <option value="{{ $key }}" {{ (isset($product) && $product->status == $key) ? 'selected' : '' }}>
                        {{ $status }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Featured -->
        <div class="flex items-center">
            <input type="checkbox" id="is_featured" name="is_featured" value="1" 
                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                {{ (isset($product) && $product->is_featured) ? 'checked' : '' }}>
            <label for="is_featured" class="ml-2 block text-sm text-gray-900">
                Featured Product
            </label>
        </div>

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

    // Initialize select2 for multiple categories
    $(document).ready(function() {
        $('#categories').select2({
            placeholder: "Select categories",
            allowClear: true
        });
    });

    // Toggle stock fields based on track_stock checkbox
    document.getElementById('track_stock').addEventListener('change', function() {        
        const stockFields = document.getElementById('stock_fields');
        if (this.checked) {
            stockFields.classList.remove('hidden');
        } else {
            stockFields.classList.add('hidden');
        }
    });
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
@endsection