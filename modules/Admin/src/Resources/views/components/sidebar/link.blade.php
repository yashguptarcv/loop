@props([
    'href' => '#',
    'icon' => 'dashboard',
    'label' => '',
    'active' => false,
    'badge' => null
])

@php
    $classes = $active
        ? 'bg-[var(--color-hover)] text-[var(--color-text-inverted)]'
        : 'text-[var(--color-text-inverted)] hover:bg-[var(--color-hover)]';
@endphp

<a href="{{ $href }}"
   class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200 text-sm font-medium {{ $classes }}">
    <span class="material-icons-outlined mr-3 text-[var(--color-primary-300)] group-hover:text-[var(--color-text-inverted)]">
        {{ $icon }}
    </span>
    <span class="flex-1">{{ $label }}</span>

    @if($badge)
        <span class="ml-auto bg-[var(--color-primary)] text-[var(--color-white)] text-xs font-semibold px-2 py-0.5 rounded-full">
            {{ $badge }}
        </span>
    @endif
</a>