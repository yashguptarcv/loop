<form id="userForm" class="form-ajax" method="POST" action="{{route('admin.widgets.assign', $widget->id)}}">
    @csrf

    @if(isset($widget))
        @method('PUT')
    @endif
    <div class="mb-6">
        <div class="bg-gray-50 p-4 rounded-lg">
            <h5 class="font-medium text-gray-700 mb-3">Available Groups</h5>
            <div id="available-groups" class="flex flex-wrap gap-3 justify-start mb-6">
                @foreach($groups as $group)
                <div class="checkbox-container">
                    <input id="filter-{{$group['id']}}"
                        name="user_groups[{{$group['id']}}]" type="checkbox" value="{{ $group['name'] }}"
                        @if(!empty($widget->user_groups[$group['id']])) checked @endif
                    class="h-4 w-4 text-primary-100 focus:ring-primary-600 border-primary-100 rounded">
                    <label for="filter-{{$group['id']}}"
                        class="ml-3 text-sm text-white-100">
                        {{ $group['name'] }}
                    </label>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="flex justify-end space-x-4">
        <x-button type="submit"
            class="primary"
            label="Save"
            icon=''
            name="button" />
    </div>
</form>