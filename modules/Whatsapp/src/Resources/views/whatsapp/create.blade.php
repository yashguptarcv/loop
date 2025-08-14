@extends('admin::layouts.app')

@section('title', !empty($template) ? 'Edit Template' : 'Create New Template')

@section('content')

    
@include('admin::components.common.back-button', ['route' => route('admin.whatsapp.index'), 'name' => !empty($template) ? 'Edit Template' : 'Create New Template'])

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Template Form -->
    <div class="lg:col-span-2">
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow">            

            <form action="{{ route('admin.whatsapp.templates.store') }}" method="POST" class="form-ajax p-6" enctype="multipart/form-data">
                @csrf

                <!-- Basic Information -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white-200 mb-4">Basic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Template Name *
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200"
                                placeholder="e.g., order_confirmation" required>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                Use lowercase letters, numbers, and underscores only. No spaces.
                            </p>
                        </div>
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Category *
                            </label>
                            <select id="category" name="category"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200"
                                required>
                                <option value="utility" {{ old('category') === 'utility' ? 'selected' : '' }}>Utility</option>
                                <option value="marketing" {{ old('category') === 'marketing' ? 'selected' : '' }}>Marketing</option>
                                <option value="authentication" {{ old('category') === 'authentication' ? 'selected' : '' }}>Authentication</option>
                            </select>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                Marketing templates have more restrictions and longer approval times.
                            </p>
                        </div>
                    </div>
                    <div class="mt-6">
                        <label for="language" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Language *
                        </label>
                        <select id="language" name="language"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200"
                            required>
                            <option value="en_US" {{ old('language') === 'en_US' ? 'selected' : '' }}>English (US)</option>
                            <option value="en_GB" {{ old('language') === 'en_GB' ? 'selected' : '' }}>English (UK)</option>
                            <option value="es_ES" {{ old('language') === 'es_ES' ? 'selected' : '' }}>Spanish (Spain)</option>
                            <option value="es_MX" {{ old('language') === 'es_MX' ? 'selected' : '' }}>Spanish (Mexico)</option>
                            <option value="pt_BR" {{ old('language') === 'pt_BR' ? 'selected' : '' }}>Portuguese (Brazil)</option>
                            <option value="fr_FR" {{ old('language') === 'fr_FR' ? 'selected' : '' }}>French</option>
                            <option value="de_DE" {{ old('language') === 'de_DE' ? 'selected' : '' }}>German</option>
                            <option value="it_IT" {{ old('language') === 'it_IT' ? 'selected' : '' }}>Italian</option>
                            <option value="ru_RU" {{ old('language') === 'ru_RU' ? 'selected' : '' }}>Russian</option>
                            <option value="zh_CN" {{ old('language') === 'zh_CN' ? 'selected' : '' }}>Chinese (China)</option>
                            <option value="ja_JP" {{ old('language') === 'ja_JP' ? 'selected' : '' }}>Japanese</option>
                            <option value="ar_SA" {{ old('language') === 'ar_SA' ? 'selected' : '' }}>Arabic (Saudi Arabia)</option>
                            <option value="hi_IN" {{ old('language') === 'hi_IN' ? 'selected' : '' }}>Hindi</option>
                        </select>
                    </div>
                </div>

                <!-- Header Section -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white-200 mb-4">Header (Optional)</h3>
                    <div class="mb-6">
                        <label for="header_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Header Type
                        </label>
                        <select id="header_type" name="header_type"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200"
                            onchange="toggleHeaderFields()">
                            <option value="none" {{ old('header_type') === 'none' ? 'selected' : '' }}>No Header</option>
                            <option value="text" {{ old('header_type') === 'text' ? 'selected' : '' }}>Text</option>
                            <option value="image" {{ old('header_type') === 'image' ? 'selected' : '' }}>Image</option>
                            <option value="video" {{ old('header_type') === 'video' ? 'selected' : '' }}>Video</option>
                            <option value="document" {{ old('header_type') === 'document' ? 'selected' : '' }}>Document</option>
                        </select>
                    </div>

                    <!-- Text Header -->
                    <div id="header_text_container" class="{{ old('header_type') === 'text' ? '' : 'hidden' }} space-y-2">
                        <label for="header_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Header Text
                        </label>
                        <input type="text" id="header_text" name="header_text" value="{{ old('header_text') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200"
                            placeholder="e.g., Order Confirmation">
                        <p class="text-xs text-gray-500 dark:text-gray-400">Maximum 60 characters</p>
                    </div>

                    <!-- Image Header -->
                    <div id="header_image_container" class="{{ old('header_type') === 'image' ? '' : 'hidden' }} space-y-2">
                        <label for="header_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Header Image
                        </label>
                        <input type="file" id="header_image" name="header_image" accept="image/jpeg,image/png"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200">
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Supported formats: JPEG, PNG. Max size: 5MB.
                        </p>
                        <div id="image_preview" class="mt-2 hidden">
                            <img id="header_image_preview" src="#" alt="Image Preview" class="max-h-40 rounded-md">
                        </div>
                    </div>

                    <!-- Video Header -->
                    <div id="header_video_container" class="{{ old('header_type') === 'video' ? '' : 'hidden' }} space-y-2">
                        <label for="header_video" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Header Video
                        </label>
                        <input type="file" id="header_video" name="header_video" accept="video/mp4,video/3gpp"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200">
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Supported formats: MP4, 3GPP. Max size: 16MB.
                        </p>
                    </div>

                    <!-- Document Header -->
                    <div id="header_document_container" class="{{ old('header_type') === 'document' ? '' : 'hidden' }} space-y-2">
                        <label for="header_document" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Header Document
                        </label>
                        <input type="file" id="header_document" name="header_document" accept="application/pdf"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200">
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Supported formats: PDF. Max size: 100MB.
                        </p>
                    </div>
                </div>

                <!-- Body Section -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white-200 mb-4">Body *</h3>
                    <div class="space-y-2">
                        <label for="body_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Body Text
                        </label>
                        <textarea id="body_text" name="body_text" rows="5"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200"
                            placeholder="Enter your message body here..." required>{{ old('body_text') }}</textarea>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Maximum 1024 characters. Use {{1}}, {{2}}, etc. for variables.
                        </p>
                    </div>

                    <!-- Body Examples for Variables -->
                    <div id="body_examples_container" class="hidden mt-4 space-y-2">
                        <label for="body_examples" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Example Values for Variables
                        </label>
                        <input type="text" id="body_examples" name="body_examples" value="{{ old('body_examples') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200"
                            placeholder="e.g., John Doe, 12345, $99.99">
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Provide example values separated by commas for template variables ({{1}}, {{2}}, etc.)
                        </p>
                    </div>
                </div>

                <!-- Footer Section -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white-200 mb-4">Footer (Optional)</h3>
                    <div class="space-y-2">
                        <label for="footer_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Footer Text
                        </label>
                        <input type="text" id="footer_text" name="footer_text" value="{{ old('footer_text') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200"
                            placeholder="e.g., Thank you for your business">
                        <p class="text-xs text-gray-500 dark:text-gray-400">Maximum 60 characters</p>
                    </div>
                </div>

                <!-- Buttons Section -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white-200 mb-4">Buttons (Optional)</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                        Add up to 3 buttons to your template. You can mix button types.
                    </p>

                    <div id="buttons_container">
                        <div class="button-row mb-4 p-4 border border-blue-200 dark:border-blue-700 rounded-md bg-gray-50 dark:bg-gray-800">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Button Type</label>
                                    <select name="button_type[]" class="button-type w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200" onchange="toggleButtonFields(this)">
                                        <option value="">Select Type</option>
                                        <option value="url">URL Button</option>
                                        <option value="phone_number">Phone Button</option>
                                        <option value="quick_reply">Quick Reply</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Button Text</label>
                                    <input type="text" name="button_text[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200" placeholder="e.g., Visit Website">
                                </div>
                                <div class="button-url-field hidden">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">URL</label>
                                    <input type="url" name="button_url[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200" placeholder="https://example.com">
                                </div>
                                <div class="button-phone-field hidden">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone Number</label>
                                    <input type="text" name="button_phone[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200" placeholder="+1234567890">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-2">
                        <button type="button" id="add_button" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm font-medium flex items-center" onclick="addButton()">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Another Button
                        </button>
                    </div>
                </div>

                <div class="border-t border-blue-200 dark:border-blue-700 pt-6">
                   <x-button type="submit" class="blue" label="Save" icon='' name='button'/>
                </div>
            </form>
        </div>
    </div>

    <!-- Sidebar -->
    @include('whatsapp::whatsapp.components.info')


@endsection
@section('scripts')
<script>
    function toggleHeaderFields() {
        const headerType = document.getElementById('header_type').value;
        const textContainer = document.getElementById('header_text_container');
        const imageContainer = document.getElementById('header_image_container');
        const videoContainer = document.getElementById('header_video_container');
        const documentContainer = document.getElementById('header_document_container');

        // Hide all containers first
        textContainer.classList.add('hidden');
        imageContainer.classList.add('hidden');
        videoContainer.classList.add('hidden');
        documentContainer.classList.add('hidden');

        // Show the relevant container
        if (headerType === 'text') {
            textContainer.classList.remove('hidden');
        } else if (headerType === 'image') {
            imageContainer.classList.remove('hidden');
        } else if (headerType === 'video') {
            videoContainer.classList.remove('hidden');
        } else if (headerType === 'document') {
            documentContainer.classList.remove('hidden');
        }
    }

    function toggleButtonFields(selectElement) {
        const row = selectElement.closest('.button-row');
        const urlField = row.querySelector('.button-url-field');
        const phoneField = row.querySelector('.button-phone-field');

        // Hide all fields first
        urlField.classList.add('hidden');
        phoneField.classList.add('hidden');

        // Show the relevant field based on selection
        const buttonType = selectElement.value;
        if (buttonType === 'url') {
            urlField.classList.remove('hidden');
        } else if (buttonType === 'phone_number') {
            phoneField.classList.remove('hidden');
        }
    }

    function addButton() {
        const container = document.getElementById('buttons_container');
        const buttonCount = container.querySelectorAll('.button-row').length;

        if (buttonCount < 3) { // WhatsApp allows max 3 buttons
            const newRow = document.createElement('div');
            newRow.className = 'button-row mb-4 p-4 border border-gray-200 dark:border-gray-600 rounded-md';
            newRow.innerHTML = `
            <div class="flex justify-between items-center mb-2">
                <h4 class="font-medium text-gray-900 dark:text-gray-200">Button ${buttonCount + 1}</h4>
                <button type="button" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300" onclick="removeButton(this)">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Button Type</label>
                    <select name="button_type[]" class="button-type w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200" onchange="toggleButtonFields(this)">
                        <option value="">Select Type</option>
                        <option value="url">URL Button</option>
                        <option value="phone_number">Phone Button</option>
                        <option value="quick_reply">Quick Reply</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Button Text</label>
                    <input type="text" name="button_text[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200" placeholder="e.g., Visit Website">
                </div>
                <div class="button-url-field hidden">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">URL</label>
                    <input type="url" name="button_url[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200" placeholder="https://example.com">
                </div>
                <div class="button-phone-field hidden">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone Number</label>
                    <input type="text" name="button_phone[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200" placeholder="+1234567890">
                </div>
            </div>
        `;
            container.appendChild(newRow);

            // Hide the add button if we've reached the limit
            if (buttonCount + 1 >= 3) {
                document.getElementById('add_button').style.display = 'none';
            }
        }
    }

    function removeButton(button) {
        const container = document.getElementById('buttons_container');
        const buttonRow = button.closest('.button-row');
        buttonRow.remove();

        // Show the add button again
        document.getElementById('add_button').style.display = 'flex';

        // Renumber the remaining buttons
        const buttonRows = container.querySelectorAll('.button-row');
        buttonRows.forEach((row, index) => {
            const heading = row.querySelector('h4');
            if (heading) {
                heading.textContent = `Button ${index + 1}`;
            }
        });
    }

    // Check for variables in body text and show examples field
    document.getElementById('body_text').addEventListener('input', function() {
        const bodyText = this.value;
        const hasVariables = /\{\{\d+\}\}/.test(bodyText);
        const examplesContainer = document.getElementById('body_examples_container');

        if (hasVariables) {
            examplesContainer.classList.remove('hidden');
        } else {
            examplesContainer.classList.add('hidden');
        }
    });

    // Image preview functionality
    document.getElementById('header_image').addEventListener('change', function(event) {
        const preview = document.getElementById('header_image_preview');
        const previewContainer = document.getElementById('image_preview');

        if (event.target.files && event.target.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }

            reader.readAsDataURL(event.target.files[0]);
        } else {
            previewContainer.classList.add('hidden');
        }
    });
</script>
@endsection