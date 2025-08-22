<form id="lead-form" method="POST"
    action="{{ isset($sources) ? route('admin.settings.statuses.source.update', $sources->id) : route('admin.settings.statuses.source.store') }}"
    class="form-ajax ">
    @csrf
    @if(isset($sources))
    @method('PUT')
    @endif

    <div class="flex flex-col gap-3">

        <!-- Name -->
        <div class="col-span-1">
            <label class="custom-label required">Name</label>
            <input type="text" name="name" id="name"
                value="{{ old('name', $sources->name ?? '') }}"
                class="input-field">
        </div>

        <!-- Slug -->
        <div class="col-span-1">
            <label class="custom-label required">Slug</label>
            <input type="text" name="slug" id="slug"
                value="{{ old('slug', $sources->slug ?? '') }}"
                class="input-field">
        </div>

        <!-- Description -->
        <div class="col-span-1">
            <label class="custom-label">Description</label>
            <input type="text" name="description" id="description"
                value="{{ old('description', $sources->description ?? $description ?? '') }}"
                class="input-field">
        </div>

        <!-- Status Dropdown -->
        <div class="col-span-1">
            <label class="custom-label">Status</label>
            <select name="is_active" id="is_active" class="input-field">
                <option value="">-- Select Status --</option>
                <option value="1" {{ old('is_active', $sources->is_active ?? '') == '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('is_active', $sources->is_active ?? '') == '0' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>


        <div class="mt-8 flex justify-end space-x-3">
            <x-button type="submit" class="blue" label="Save" icon='' name='button' />
        </div>


    </div>
</form>
