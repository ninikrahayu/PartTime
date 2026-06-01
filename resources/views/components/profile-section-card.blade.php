@props([
    'title',
    'description' => null,
])

<section {{ $attributes->merge(['class' => 'rounded-md border border-border-color bg-white shadow-sm']) }}>
    <div class="flex items-start justify-between gap-4 border-b border-border-color px-5 py-4">
        <div>
            <h3 class="text-base font-semibold text-text-dark">{{ $title }}</h3>
            @if($description)
                <p class="mt-1 text-sm text-text-gray">{{ $description }}</p>
            @endif
        </div>
        @if(isset($actions))
            <div class="shrink-0">{{ $actions }}</div>
        @endif
    </div>
    <div class="p-5">
        {{ $slot }}
    </div>
</section>
