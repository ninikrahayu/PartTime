@props([
    'title',
    'subtitle' => null,
    'chartId',
    'height' => 'h-72',
])

<x-card {{ $attributes }}>
    <x-slot:header>
        <div class="flex items-start justify-between gap-4">
            <div>
                <h3 class="text-base font-semibold text-text-dark">{{ $title }}</h3>
                @if($subtitle)
                    <p class="mt-1 text-sm text-text-gray">{{ $subtitle }}</p>
                @endif
            </div>
            @if(isset($actions))
                <div class="shrink-0">{{ $actions }}</div>
            @endif
        </div>
    </x-slot:header>

    <div class="{{ $height }} relative">
        <canvas id="{{ $chartId }}" class="h-full w-full"></canvas>
    </div>
</x-card>
