@php
    $parent = 'parent_category_id';
    if(!empty($parentname)){
        $parent = $parentname;
    }

    $child = 'child_category_id';
    if(!empty($childname)){
        $child = $childname;
    }

    $other = 'custom_category';
    if(!empty($othername)){
        $other = $othername;
    }
@endphp
<div class="category_container space-y-4">
    <!-- Parent -->
    <div>
        @if($showLabel)
        <label class="block text-gray-300 mb-2">Parent Category</label>
        @endif
        <select 
            name="{{$parent}}"
            data-parent
            class="w-full bg-[#383c3c] text-gray-200 px-4 py-3 rounded-full border border-white/10 focus:outline-none">
            <option value="">-- Choose category --</option>
            @foreach($parentCategories as $parent)
                <option value="{{ $parent['id'] }}" @selected($selectedParent == $parent['id'])>
                    {{ $parent['name'] }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Child -->
    <div>
        @if($showLabel)
        <label class="block text-gray-300 mb-2">Child Category</label>
        @endif
        <select 
            name="{{$child}}"
            data-other-name="{{$other}}"
            data-child
            class="w-full bg-[#383c3c] text-gray-200 px-4 py-3 rounded-full border border-white/10 focus:outline-none">
            <option value=""></option>
        </select>
        <input type="hidden" data-selected-child value="{{ $selectedChild }}">
    </div>
</div>
