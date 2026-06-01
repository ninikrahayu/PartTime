@props([
    'review',
])

<article {{ $attributes->merge(['class' => 'rounded-md border border-border-color bg-white p-5 shadow-sm']) }}>
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0">
            <h3 class="text-base font-semibold text-text-dark">{{ $review['reviewer_name'] ?? 'Reviewer' }}</h3>
            <p class="mt-1 text-sm text-text-gray">{{ $review['job_title'] ?? '-' }}</p>
        </div>
        <div class="flex shrink-0 items-center gap-1 text-secondary" aria-label="Rating {{ $review['rating'] ?? 0 }} dari 5">
            @for($i = 1; $i <= 5; $i++)
                <i class="{{ $i <= ($review['rating'] ?? 0) ? 'fa-solid' : 'fa-regular' }} fa-star text-sm"></i>
            @endfor
        </div>
    </div>

    <p class="mt-4 text-sm leading-6 text-text-gray">{{ $review['comment'] ?? '-' }}</p>

    <div class="mt-4 flex flex-wrap items-center gap-2 text-xs text-text-gray">
        @if(isset($review['reviewer_role']))
            <x-badge color="gray">{{ ucfirst($review['reviewer_role']) }}</x-badge>
        @endif
        @if(isset($review['created_at']))
            <span>{{ $review['created_at'] }}</span>
        @endif
    </div>
</article>
