@php
    $dynamicAttributes = collect($calls)
        ->map(fn($value, $key) => $key . '="' . e($value) . '"')
        ->implode(' ');
@endphp

@if ($as === 'a')
    <a href="{{ $href }}"
       id="{{ $id }}"
       name="{{ $name }}"
       {!! $dynamicAttributes !!}
       class="inline-flex items-center gap-2 px-4 py-2 rounded bg-[var(--color-hover)] text-[var(--color-text-inverted)]-600 text-white hover:bg-[var(--color-hover)] text-[var(--color-text-inverted)]-700 {{ $class }}">
        @if ($icon)
            {!! $icon !!}
        @endif
        {{ $label }}
        @if ($badge)
            <span class="ml-2 inline-block bg-red-500 text-white text-xs px-2 rounded-full">{{ $badge }}</span>
        @endif
    </a>
@else
    <button type="{{ $type }}"
            id="{{ $id }}"
            name="{{ $name }}"
            {!! $dynamicAttributes !!}
            class="inline-flex items-center gap-2 px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700 {{ $class }}">
        @if ($icon)
            {!! $icon !!}
        @endif
        {{ $label }}
        @if ($badge)
            <span class="ml-2 inline-block bg-red-500 text-white text-xs px-2 rounded-full">{{ $badge }}</span>
        @endif
    </button>
@endif
