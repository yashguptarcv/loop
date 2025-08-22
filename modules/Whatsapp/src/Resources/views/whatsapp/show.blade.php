@extends('admin::layouts.app')

@section('title', !empty($template) ? 'Edit Template' : 'Create New Template')

@section('content')

    <div class="flex justify-between items-center mb-8">
        @include('admin::components.common.back-button', ['route' => route('admin.whatsapp.index'), 'name' => !empty($template) ? 'Edit Template / '.$template->formatted_name.' / '. $template->name : 'Create New Template'])

        <div class="flex items-center justify-between">
            <div class="flex space-x-3">

                @if($template->status === 'approved')
                <x-modal
                    buttonText='Send Message'
                    modalTitle="Send Message"
                    id='send_message'
                    ajaxUrl="#"
                    color="blue"
                    modalSize="sm" />
                @endif
                @if(bouncer()->hasPermission('admin.whatsapp.templates.destroy'))
                <form action="{{ route('admin.whatsapp.templates.destroy', $template) }}" method="POST" class="form-ajax inline">
                    @csrf
                    @method('DELETE')
                    <x-button type="submit"                     
                        class="red" 
                        label="Delete" 
                        icon=''
                        name="button"
                        />  
                </form>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Template Details -->
        <div class="lg:col-span-2">
            <!-- Status Card -->
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow mb-6">
                <div class="p-6 border-b border-blue-200 dark:border-blue-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Template Status</h2>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Current Status:</span>
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $template->status_badge }} dark:bg-opacity-80">
                            {{ ucfirst($template->status) }}
                        </span>
                    </div>

                    @if($template->status === 'rejected' && $template->rejection_reason)
                    <div class="bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 rounded-md p-4">
                        <h4 class="text-sm font-medium text-red-800 dark:text-red-200 mb-2">Rejection Reason:</h4>
                        <p class="text-sm text-red-700 dark:text-red-300">{{ $template->rejection_reason }}</p>
                    </div>
                    @endif

                    @if($template->status === 'pending')
                    <div class="bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-md p-4">
                        <p class="text-sm text-yellow-700 dark:text-yellow-300">
                            Your template is under review by Meta. This process typically takes 24-48 hours.
                        </p>
                    </div>
                    @endif

                    @if($template->status === 'approved')
                    <div class="bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-md p-4">
                        <p class="text-sm text-green-700 dark:text-green-300">
                            Your template has been approved and is ready to use!
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Template Content -->
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow mb-6">
                <div class="p-6 border-b border-blue-200 dark:border-blue-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Template Content</h2>
                </div>
                <div class="p-6">
                    <!-- Basic Info -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                {{ $template->category === 'marketing' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' :
                                   ($template->category === 'utility' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200') }}">
                                {{ ucfirst($template->category) }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">Language</label>
                            <p class="text-sm text-gray-900 dark:text-gray-200">{{ $template->language }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">Created</label>
                            <p class="text-sm text-gray-900 dark:text-gray-200">{{ $template->created_at->format('M j, Y H:i') }}</p>
                        </div>
                    </div>

                    <!-- Template Preview -->
                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50 dark:border-gray-700 dark:bg-gray-800">
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Template Preview</h3>
                        <div class="bg-white rounded-lg p-4 dark:bg-gray-900 max-w-sm mx-auto border border-gray-300 dark:border-gray-600 shadow-sm">
                            <!-- Header -->
                            @if($template->header_text)
                            <div class="mb-3">
                                <div class="font-semibold text-gray-900 dark:text-gray-200 text-sm">
                                    {{ $template->header_text }}
                                </div>
                            </div>
                            @endif

                            <!-- Body -->
                            <div class="mb-3">
                                <div class="text-gray-800 dark:text-gray-300 text-sm whitespace-pre-line">{{ $template->body_text }}</div>
                            </div>

                            <!-- Footer -->
                            @if($template->footer_text)
                            <div class="mb-3">
                                <div class="text-gray-500 dark:text-gray-400 text-xs">{{ $template->footer_text }}</div>
                            </div>
                            @endif

                            <!-- Buttons -->
                            @if($template->buttons && count($template->buttons) > 0)
                            <div class="space-y-2">
                                @foreach($template->buttons as $button)
                                <div class="border border-gray-300 rounded px-3 py-2 text-center text-sm dark:border-gray-600">
                                    @if($button['type'] === 'url')
                                    <span class="text-blue-600 dark:text-blue-400">🔗 {{ $button['text'] }}</span>
                                    @elseif($button['type'] === 'phone_number')
                                    <span class="text-green-600 dark:text-green-400">📞 {{ $button['text'] }}</span>
                                    @else
                                    <span class="text-gray-700 dark:text-gray-300">{{ $button['text'] }}</span>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Template Components -->
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow">
                <div class="p-6 border-b border-blue-200 dark:border-blue-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Template Components</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-6">
                        <!-- Header Component -->
                        @if($template->header_text)
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Header</h3>
                            <div class="bg-gray-50 dark:bg-gray-800 rounded-md p-3">
                                <p class="text-sm text-gray-900 dark:text-gray-200">{{ $template->header_text }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Type: {{ ucfirst($template->header_type) }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Body Component -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Body</h3>
                            <div class="bg-gray-50 dark:bg-gray-800 rounded-md p-3">
                                <p class="text-sm text-gray-900 dark:text-gray-200 whitespace-pre-line">{{ $template->body_text }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    Characters: {{ strlen($template->body_text) }}/1024
                                </p>
                            </div>
                        </div>

                        <!-- Footer Component -->
                        @if($template->footer_text)
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Footer</h3>
                            <div class="bg-gray-50 dark:bg-gray-800 rounded-md p-3">
                                <p class="text-sm text-gray-900 dark:text-gray-200">{{ $template->footer_text }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    Characters: {{ strlen($template->footer_text) }}/60
                                </p>
                            </div>
                        </div>
                        @endif

                        <!-- Buttons Component -->
                        @if($template->buttons && count($template->buttons) > 0)
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Buttons ({{ count($template->buttons) }})</h3>
                            <div class="space-y-2">
                                @foreach($template->buttons as $index => $button)
                                <div class="bg-gray-50 dark:bg-gray-800 rounded-md p-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium text-gray-900 dark:text-gray-200">Button {{ $index + 1 }}</span>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            {{ ucfirst(str_replace('_', ' ', $button['type'])) }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">{{ $button['text'] }}</p>
                                    @if(isset($button['url']))
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">URL: {{ $button['url'] }}</p>
                                    @endif
                                    @if(isset($button['phone_number']))
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Phone: {{ $button['phone_number'] }}</p>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Send Message Modal -->
        @if($template->status === 'approved')
        <div id="sendModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-900">
                <div class="mt-3">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Send Template Message</h3>
                        <button onclick="closeSendModal()" class="text-gray-400 hover:text-gray-600 dark:text-gray-300 dark:hover:text-gray-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('admin.whatsapp.send.template') }}" method="POST">
                        @csrf
                        <input type="hidden" name="template_name" value="{{ $template->name }}">
                        <input type="hidden" name="language" value="{{ $template->language }}">

                        <div class="mb-4">
                            <label for="modal_recipient_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="modal_recipient_phone" name="recipient_phone"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200"
                                placeholder="e.g., 1234567890" required>
                        </div>

                        <div class="mb-4">
                            <label for="modal_recipient_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Recipient Name
                            </label>
                            <input type="text" id="modal_recipient_name" name="recipient_name"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200"
                                placeholder="John Doe">
                        </div>

                        <!-- Dynamic parameters based on template body -->
                        @php
                        preg_match_all('/\{\{(\d+)\}\}/', $template->body_text, $matches);
                        $parameterCount = count(array_unique($matches[1]));
                        @endphp

                        @if($parameterCount > 0)
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Template Parameters <span class="text-red-500">*</span> </label>
                            @for($i = 1; $i <= $parameterCount; $i++)
                                <div class="mb-2">
                                <input type="text" name="parameters[]"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200"
                                    placeholder="Parameter {{ $i }}" required>
                        </div>
                        @endfor
                </div>
                @endif

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeSendModal()" class="bg-gray-300 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-400 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500">
                        Cancel
                    </button>
                    <button type="submit" class="bg-blue-100 text-white-200 py-2 px-4 rounded-md hover:bg-blue-700 dark:bg-green-500 dark:hover:bg-blue-100">
                        Send Message
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Sidebar -->
    @include('whatsapp::whatsapp.components.info')

@endsection
@section('scripts')
<script>
    function openSendModal() {
        document.getElementById('sendModal').classList.remove('hidden');
    }

    function closeSendModal() {
        document.getElementById('sendModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('sendModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeSendModal();
        }
    });
</script>


@endsection