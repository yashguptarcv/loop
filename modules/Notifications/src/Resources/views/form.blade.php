<form id="templateMappingForm" class="form-ajax" method="POST" action="{{route('admin.notification.update', $currentEventId)}}">
    @csrf
    @isset($channels)
    @method('PUT')
    @endisset
    <input type="hidden" name="event_id" value="{{ $currentEventId }}">
    
    <!-- Channel Mappings Section -->
    <div class="space-y-4">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($channelMappings as $channel)
            <div class="border border-blue-100 rounded-lg p-4 bg-white">
                <h4 class="font-medium text-gray-800 mb-3">{{ $channel['name'] }}</h4>
                
                <div class="space-y-3">
                    <div class="flex items-center">
                        <input type="checkbox" id="admin_{{ $channel['channel_id'] }}" name="channels[{{ $channel['channel_id'] }}][notify_admin]"
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" value="1"
                               {{ $channel['notify_admin'] ? 'checked' : '' }}>
                        <label for="admin_{{ $channel['channel_id'] }}" class="ml-2 block text-sm text-gray-700">
                            Notify Admin
                        </label>
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" id="customer_{{ $channel['channel_id'] }}" name="channels[{{ $channel['channel_id'] }}][notify_customer]"
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" value="1"
                               {{ $channel['notify_customer'] ? 'checked' : '' }}>
                        <label for="customer_{{ $channel['channel_id'] }}" class="ml-2 block text-sm text-gray-700">
                            Notify Customer
                        </label>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Templates Section -->
    <div class="space-y-4 mt-3">
        <h3 class="text-lg font-medium text-gray-900">Template Selection</h3>
        
        <div class="grid grid-cols-1 gap-4">
            @foreach($channelMappings as $channel)
                @if(count($templates[$channel['channel_id']]) > 0)
                <div class="border border-blue-100 rounded-lg p-4 bg-white">
                    <h4 class="font-medium text-gray-800 mb-3">{{ $channel['name'] }} Template</h4>
                    
                    <select name="channels[{{ $channel['channel_id'] }}][template_id]"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">-- No Template --</option>
                        @foreach($templates[$channel['channel_id']] as $template)
                        <option value="{{ $template['id'] }}"
                                {{ $channelMappings[$channel['channel_id']]['template_id'] == $template['id'] ? 'selected' : '' }}>
                            {{ $template['name'] }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @endif
            @endforeach
        </div>
    </div>

    <!-- Submit Button -->
    <div class="pt-4">
        <x-button type="submit"                     
            class="blue" 
            label="Save" 
            icon=''
            name="button" 
        />
    </div>
</form>