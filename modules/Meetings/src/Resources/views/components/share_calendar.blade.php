<div class="mb-4">
    <p class="text-sm text-gray-600 mb-3">Share this link with others to allow them to view and book meetings on your calendar:</p>
    <div class="public-link-container">
        <div class="flex items-center">
            <input type="text" id="publicLink" value="{{ route('public.calendar', ['hash' => auth('admin')->user()->calendar_hash]) }}"
                class="flex-1 px-3 py-2 border border-gray-300 rounded-l-md" readonly>
            <button data-action="copy-link" class="px-3 py-2 bg-blue-600 text-white-200 rounded-r-md hover:bg-blue-700">
                <i class="fas fa-copy"></i>
            </button>
        </div>
    </div>
    <div class="mt-3">
        <label class="inline-flex items-center">
            <input type="checkbox" id="enablePublicBooking" class="rounded border-gray-300 bg-blue-100 text-white-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-[var(--color-hover)]-200 focus:ring-opacity-50" checked>
            <span class="ml-2 text-sm text-gray-700">Allow public booking</span>
        </label>
    </div>
</div>

<script>
// Use event delegation for dynamically loaded content
document.addEventListener('click', function(e) {
    if (e.target.closest('[data-action="copy-link"]')) {
        const button = e.target.closest('[data-action="copy-link"]');
        const linkInput = document.getElementById('publicLink');
        
        if (!linkInput) return;
        
        linkInput.select();
        document.execCommand('copy');

        // Show notification
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check"></i> Copied!';
        setTimeout(() => {
            button.innerHTML = originalText;
        }, 2000);
    }
});
</script>