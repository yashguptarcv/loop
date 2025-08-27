<form id="lead-form" method="POST"
    action="{{ isset($lead) ? route('admin.settings.statuses.leads.update', $lead->id) : route('admin.settings.statuses.leads.store') }}"
    class="form-ajax ">
    @csrf
    @if(isset($lead))
    @method('PUT')
    @endif

    <div class="flex flex-col gap-3">

        <!-- Name -->
        <div class="col-span-1">
            <label class="custom-label required">Name</label>
            <input type="text" name="name" id="name"
                value="{{ old('name', $lead->name ?? '') }}"
                class="input-field">
        </div>

        <!-- Color Name -->
        <div class="col-span-1">
            <label class="custom-label required" for="color">Color Name</label>
            <select name="color" id="color" class="input-field">
                <option value="">-- Select color --</option>
                @foreach ($tags as $tag)
                <option value="{{ $tag->id }}"
                    data-code="{{ $tag->color }}"
                    {{ old('color', $tag->color ?? null) == $tag->id ? 'selected' : '' }}>
                    {{ $tag->color }}
                </option>
                @endforeach
            </select>
        </div>
        <!-- Sort -->
        <div class="col-span-1">
            <label class="custom-label">Sort</label>
            <input type="number" name="sort" id="sort"
                value="{{ old('sort', $lead->sort ?? $nextSortNumber ?? '') }}"
                class="input-field" min="1">
        </div>

        <!-- Status Dropdown -->
        <div class="col-span-1">
            <label class="custom-label">Status</label>
            <select name="is_default" id="is_default" class="input-field">
                <option value="">-- Select Status --</option>
                <option value="1" {{ old('is_default', $lead->is_default ?? '') == '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('is_default', $lead->is_default ?? '') == '0' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>


        <div class="mt-8 flex justify-end space-x-3">
            <x-button type="submit" class="blue" label="Save" icon='' name='button' />
        </div>



    </div>


    <!-- <input type="hidden" name="id" id="lead_id" value="{{ $lead->id ?? '' }}"> -->


</form>