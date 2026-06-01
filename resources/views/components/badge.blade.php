@props(['color' => 'primary'])
@php
    $colors = [
        'primary' => 'bg-primary/10 text-primary',
        'secondary' => 'bg-secondary/20 text-text-dark',
        'success' => 'bg-success/10 text-success',
        'danger' => 'bg-danger/10 text-danger',
        'warning' => 'bg-warning/10 text-warning',
        'info' => 'bg-info/10 text-info',
        'gray' => 'bg-gray-100 text-text-gray border border-border-color',
    ];
    $colorClass = $colors[$color] ?? $colors['primary'];
@endphp
<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium $colorClass"]) }}>
    {{ $slot }}
</span>