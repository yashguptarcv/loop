<form class="form-ajax" action="{{ route('admin.meetings.store') }}" method="POST" id="asdasd">
    
    @csrf
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
        <input type="text" name="title" class="w-full px-3 py-2 border border-gray-300 rounded-md" >
    </div>
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
        <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
    </div>
    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
            <input type="datetime-local" name="start_time" class="w-full px-3 py-2 border border-gray-300 rounded-md" >
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Slots</label>
            <input type="text" name="end_time" class="w-full px-3 py-2 border border-gray-300 rounded-md" >
            <small class="text-blue-600">Example: 10, 30, 50 Minutes.</small>
        </div>
    </div>
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
        <input type="text" name="location" class="w-full px-3 py-2 border border-gray-300 rounded-md">
    </div>
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Event Color</label>
        <select name="color" class="w-full px-3 py-2 border border-gray-300 rounded-md">
            <option value="blue">Blue</option>
            <option value="red">Red</option>
            <option value="green">Green</option>
            <option value="yellow">Yellow</option>
            <option value="purple">Purple</option>
        </select>
    </div>
    <div class="flex justify-end">
        <x-button type="submit"  class="blue" label="Save" icon='' name='button'/>                
        
    </div>
</form>