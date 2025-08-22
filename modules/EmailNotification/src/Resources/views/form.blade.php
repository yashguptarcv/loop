<form id="templateForm" class="form-ajax" method="POST"
    action="@isset($template) {{ route('admin.email-templates.update', $template->id) }} @else {{ route('admin.email-templates.store') }} @endisset">
    @csrf
    @isset($template) @method('PUT') @endisset

    <!-- Name Field -->
    <div class="mb-2">
        <label class="custom-label">Name <span class="text-red-500">*</span></label>
        <input type="text" name="name" id="name"
            value="{{ $template->name ?? old('name') }}"
            class="input-field @error('name') border-red-500 @enderror">
        <div class="error-message text-red-500 text-sm mt-1" id="name-error">
            @error('name') {{ $message }} @enderror
        </div>
        <input type="hidden" name="id" value="{{$template->id ?? 0}}">
    </div>

    <!-- subject Field -->
    <div class="mb-2">
        <label class="custom-label">Subject <span class="text-red-500">*</span></label>
        <input type="text" name="subject" id="subject"
            value="{{ $template->subject ?? old('subject') }}"
            class="input-field @error('subject') border-red-500 @enderror">
        <div class="error-message text-red-500 text-sm mt-1" id="subject-error">
            @error('subject') {{ $message }} @enderror
        </div>
    </div>

    <!-- Content Field -->
    <div class="mb-2">
        <label class="custom-label">Content</label>
        <textarea name="content" id="content" editor="true"
            class="input-field @error('content') border-red-500 @enderror">{{ $template->content ?? old('content') }}</textarea>
        <div class="error-message text-red-500 text-sm mt-1" id="content-error">
            @error('content') {{ $message }} @enderror
        </div>
    </div>

    <!-- Status Field -->
    <div class="mb-2">
        <label class="custom-label">Status</label>
        <select name="status" id="status" 
            class="input-field @error('status') border-red-500 @enderror">
            <option value="1" @selected(($template->status ?? old('status', true)) == true)>Active</option>
            <option value="0" @selected(($template->status ?? old('status', true)) == false)>Inactive</option>
        </select>
        <div class="error-message text-red-500 text-sm mt-1" id="status-error">
            @error('status') {{ $message }} @enderror
        </div>
    </div>

    <div class="mt-8 flex justify-end space-x-3">
        <x-button type="submit" class="blue" label="Save" icon='' name='button' />
    </div>
</form>