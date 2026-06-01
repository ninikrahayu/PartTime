@props([
    'job',
    'detailUrl' => '#',
    'favoriteUrl' => null,
    'showStatus' => true,
    'showFavorite' => false,
])

@php
    $salary = isset($job['salary']) ? 'Rp ' . number_format($job['salary'], 0, ',', '.') : '-';
    $quotaLeft = max(($job['quota'] ?? 0) - ($job['accepted_count'] ?? 0), 0);
@endphp

<article {{ $attributes->merge(['class' => 'rounded-md border border-border-color bg-white p-5 shadow-sm']) }}>
    <div class="flex items-start justify-between gap-3">
        <div class="min-w-0">
            <p class="text-sm font-medium text-text-gray">{{ $job['provider_name'] ?? 'Penyedia' }}</p>
            <h3 class="mt-1 text-lg font-semibold text-text-dark">{{ $job['title'] ?? 'Lowongan Part Time' }}</h3>
        </div>
        @if($showStatus && isset($job['status']))
            <x-status-badge :status="$job['status']" class="shrink-0" />
        @endif
    </div>

    <div class="mt-4 flex flex-wrap gap-2">
        @if(isset($job['category']))
            <x-badge color="secondary">{{ $job['category'] }}</x-badge>
        @endif
        <x-badge color="gray">
            <i class="fa-solid fa-star mr-1 text-secondary"></i>
            {{ $job['provider_rating'] ?? 0 }}
        </x-badge>
    </div>

    <dl class="mt-4 grid gap-3 text-sm text-text-gray sm:grid-cols-2">
        <div class="flex gap-2">
            <i class="fa-solid fa-location-dot mt-0.5 w-4 text-primary"></i>
            <span>{{ $job['location'] ?? '-' }}</span>
        </div>
        <div class="flex gap-2">
            <i class="fa-solid fa-money-bill-wave mt-0.5 w-4 text-primary"></i>
            <span>{{ $salary }} / {{ $job['salary_type'] ?? '-' }}</span>
        </div>
        <div class="flex gap-2">
            <i class="fa-solid fa-clock mt-0.5 w-4 text-primary"></i>
            <span>{{ $job['schedule'] ?? '-' }}</span>
        </div>
        <div class="flex gap-2">
            <i class="fa-solid fa-users mt-0.5 w-4 text-primary"></i>
            <span>Kuota tersisa {{ $quotaLeft }}</span>
        </div>
    </dl>

    @if(isset($job['deadline']))
        <p class="mt-4 text-sm text-text-gray">Batas lamaran: <span class="font-medium text-text-dark">{{ $job['deadline'] }}</span></p>
    @endif

    <div class="mt-5 flex flex-col gap-2 sm:flex-row">
        <a href="{{ $detailUrl }}" class="inline-flex w-full items-center justify-center rounded-md border border-transparent bg-primary px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-900 hover:text-white focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 sm:w-auto">Lihat Detail</a>
        @if($showFavorite)
            <a href="{{ $favoriteUrl ?? '#' }}" class="inline-flex w-full items-center justify-center rounded-md border border-border-color bg-white px-4 py-2 text-sm font-medium text-primary transition-colors hover:bg-surface hover:text-primary focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 sm:w-auto">
                <i class="fa-regular fa-bookmark mr-2"></i>
                Simpan
            </a>
        @endif
    </div>
</article>
