@if(bouncer()->hasPermission('admin.leads.activities.store'))
<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Add Activity</h3>
    <form class="form-ajax" method="POST" action="{{ route('admin.leads.activities.store', $lead) }}">
        @csrf
        <div class="mb-4">
            <select name="type" id="type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <option value="general">General</option>
                <option value="call">Call</option>
                <option value="email">Email</option>
                <option value="meeting">Meeting</option>
                <option value="whatsapp">Whatsapp</option>
                <option value="schedule_meeting">Schedule Meeting</option>
            </select>
        </div>

        <div id="meeting-date-container" class="mb-4 hidden">
            <label class="block text-sm font-medium text-gray-700 mb-1">Meeting Date & Time</label>
            <input type="datetime-local" name="meeting_date" id="meeting-date" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                   min="{{ now()->format('Y-m-d\TH:i') }}">
        </div>
        
        <input type="hidden" name="description" id="activity-description">
        <textarea id="message-editor" rows="8" class="hidden"></textarea>
        
        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Duration (minutes)</label>
            <input type="number" name="duration_minutes" class="w-full px-3 py-2 border border-gray-300 rounded-md" min="0" value="0">
        </div>
        
        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Outcome</label>
            <select name="outcome" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                <option value="positive">Positive</option>
                <option value="neutral">Neutral</option>
                <option value="negative">Negative</option>
                <option value="follow_up">Follow Up Needed</option>
            </select>
        </div>
        
        <div class="mt-4 flex justify-between items-center">
            <div class="flex space-x-2">
                <div class="mb-6">
                    <label for="images" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Attachments
                    </label>
                    <input type="file" id="images" name="images[]" multiple
                        class="block w-full text-sm text-gray-500 dark:text-gray-400
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 dark:file:bg-gray-700 file:text-blue-700 dark:file:text-blue-300
                                hover:file:bg-blue-100 dark:hover:file:bg-gray-600
                                focus:outline-none focus:ring-2 focus:ring-blue-500"
                        accept="image/*">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Upload multiple images (JPEG, PNG, etc.)</p>
                    @error('images')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <x-button type="submit"  class="blue" label="Send Message" icon='' name='button'/>                
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    const activityType = document.getElementById('type');
    const meetingDateContainer = document.getElementById('meeting-date-container');
    const meetingDateInput = document.getElementById('meeting-date');
    console.log(activityType);
    // Show/hide date field based on selection
    activityType.addEventListener('change', function() {
        if (this.value === 'schedule_meeting') {
            meetingDateContainer.classList.remove('hidden');
            meetingDateInput.setAttribute('required', 'required');
        } else {
            meetingDateContainer.classList.add('hidden');
            meetingDateInput.removeAttribute('required');
        }
    });
    
    // Initialize with correct visibility
    if (activityType.value === 'schedule_meeting') {
        meetingDateContainer.classList.remove('hidden');
        meetingDateInput.setAttribute('required', 'required');
    }
});
</script>
@endif