@php
    $dynamicAttributes = collect($calls)
        ->map(fn($value, $key) => $key . '="' . e($value) . '"')
        ->implode(' ');
@endphp

@php
    
    $textClass = 'amber';

    if($class == 'amber') {
        $textClass = 'primary';
    }

    
    $class = "inline-flex items-center px-4 py-2 rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 hover:text-$textClass-200 text-$textClass-100 bg-$class-100";
    if(empty($class) && !empty($custom_class)) {
        $class = $custom_class;

    } 


@endphp
@if ($as === 'a')
    <a href="{{ $href }}"
       id="{{ $id }}"
       name="{{ $name }}"
       {!! $dynamicAttributes !!}
       class="{{ $class }}">
        @if ($icon)
            {!! $icon !!}
        @endif
        {!! $label !!}
        @if ($badge)
            <span class="ml-2 inline-block bg-{{$class ?? 'primary'}}-100 hover:text-{{$textClass}}-200 text-{{$textClass}}-100 text-xs px-2 rounded-full">{{ $badge }}</span>
        @endif
    </a>
@elseif($as === 'link') 
    <a href="{{ $href }}"
       id="{{ $id }}"
       name="{{ $name }}"
       {!! $dynamicAttributes !!}
       class="{{ $class }}">
        @if ($icon)
            {!! $icon !!}
        @endif
        {!! $label !!}
        @if ($badge)
            <span class="ml-2 inline-block bg-{{$class ?? 'primary'}}-100 hover:text-{{$textClass}}-200 text-{{$textClass}}-100 text-xs px-2 rounded-full">{{ $badge }}</span>
        @endif
    </a>
@elseif($as === 'general') 
    <button type="{{ $type }}"
            id="{{ $id }}"
            name="{{ $name }}"
            {!! $dynamicAttributes !!}
            class="{{ $class }}">
        @if ($icon)
            {!! $icon !!}
        @endif
        {!! $label !!}
        @if ($badge)
            <span class="ml-2 inline-block hover:text-{{$textClass}}-200 text-{{$textClass}}-100 text-xs px-2">{{ $badge }}</span>
        @endif
    </button>
@else
    <button type="{{ $type }}"
            id="{{ $id }}"
            name="{{ $name }}"
            {!! $dynamicAttributes !!}
            class="{{ $class }}">
        @if ($icon)
            {!! $icon !!}
        @endif
        {!! $label !!}
        @if ($badge)
            <span class="ml-2 inline-block bg-{{$class ?? 'primary'}}-100 hover:text-{{$textClass}}-200 text-{{$textClass}}-100 text-xs px-2 rounded-full">{{ $badge }}</span>
        @endif
    </button>
@endif
