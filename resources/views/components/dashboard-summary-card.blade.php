@props([
    'label',
    'value',
    'icon' => 'fa-chart-line',
    'trend' => null,
    'href' => null,
])

@php
    $content = 'flex items-start justify-between gap-4 rounded-md border border-border-color bg-white p-5 shadow-sm transition-colors hover:border-primary/40';
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $content]) }}>
        <span class="min-w-0">
            <span class="block text-sm font-medium text-text-gray">{{ $label }}</span>
            <span class="mt-2 block text-2xl font-semibold text-text-dark">{{ $value }}</span>
            @if($trend)
                <span class="mt-2 block text-xs font-medium text-success">{{ $trend }}</span>
            @endif
        </span>
        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-primary/10 text-primary">
            <i class="fa-solid {{ $icon }}"></i>
        </span>
    </a>
@else
    <div {{ $attributes->merge(['class' => $content]) }}>
        <div class="min-w-0">
            <p class="text-sm font-medium text-text-gray">{{ $label }}</p>
            <p class="mt-2 text-2xl font-semibold text-text-dark">{{ $value }}</p>
            @if($trend)
                <p class="mt-2 text-xs font-medium text-success">{{ $trend }}</p>
            @endif
        </div>
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-primary/10 text-primary">
            <i class="fa-solid {{ $icon }}"></i>
        </div>
    </div>
@endif
