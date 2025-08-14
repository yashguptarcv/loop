@props([
    'href' => '#',
    'icon' => 'dashboard',
    'label' => '',
    'active' => false,
    'badge' => null
])

@php
    $classes = $active
        ? 'bg-blue-100 text-white'
        : 'text-white-200 hover:bg-blue-100';
@endphp

<a href="{{ $href }}"
   class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200 text-sm font-medium {{ $classes }}">
    <span class="material-icons-outlined mr-3 text-blue-600 group-hover:text-white text-sm">
        {{ $icon }}
    </span>
    <span class="flex-1 text-blue-600">{{ $label }}</span>

    @if($badge)
        <span class="ml-auto bg-blue-600 text-blue-600 text-xs font-semibold px-2 py-0.5 rounded-full">
            {{ $badge }}
        </span>
    @endif
</a>