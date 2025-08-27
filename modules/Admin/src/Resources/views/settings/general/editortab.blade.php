<div class="mt-8 bg-white shadow rounded-lg overflow-hidden">
    <div class="px-6 py-6">
        <div class="space-y-6">
            <!-- Editor Api key  -->
             <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-1">
                    <label for="editor_type" class="block text-sm font-medium text-gray-700">Editor</label>
                    <p class="mt-1 text-sm text-gray-500">Set the editor.</p>
                </div>
                <div class="md:col-span-2">
                    <select id="editor_type" name="settings[general.editor.type]" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        @foreach (['tinymce'] as $tzValue => $tzLabel)
                        <option value="{{ $tzLabel }}" {{ old('settings[general.editor.type]', fn_get_setting('general.editor.type')) == $tzLabel ? 'selected' : '' }}>
                            {{ $tzLabel }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t divide-gray-100">
                <div class="md:col-span-1">
                    <label for="tax" class="block text-sm font-medium text-gray-700">Tincy Editor</label>
                    <p class="mt-1 text-sm text-gray-500">Add Tincy Editor API Key</p>
                </div>
                <div class="md:col-span-2">
                    <input type="text" id="tiny_api_key" name="settings[general.editor.api_key]"
                        value="{{ old('general.editor.api_key', fn_get_setting('general.editor.api_key')) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
            </div>
        </div>
    </div>
</div>