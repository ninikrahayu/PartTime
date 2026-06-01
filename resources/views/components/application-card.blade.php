@props([
    'application',
    'detailUrl' => '#',
    'showProvider' => true,
])

<article {{ $attributes->merge(['class' => 'rounded-md border border-border-color bg-white p-5 shadow-sm']) }}>
    <div class="flex items-start justify-between gap-3">
        <div class="min-w-0">
            <h3 class="text-base font-semibold text-text-dark">{{ $application['job_title'] ?? 'Lamaran Part Time' }}</h3>
            <p class="mt-1 text-sm text-text-gray">
                @if($showProvider)
                    {{ $application['provider_name'] ?? '-' }}
                @else
                    {{ $application['student_name'] ?? '-' }}
                @endif
            </p>
        </div>
        @if(isset($application['status']))
            <x-status-badge :status="$application['status']" class="shrink-0" />
        @endif
    </div>

    <div class="mt-4 grid gap-3 text-sm text-text-gray sm:grid-cols-2">
        <div class="flex gap-2">
            <i class="fa-solid fa-calendar-day mt-0.5 w-4 text-primary"></i>
            <span>Melamar {{ $application['applied_at'] ?? '-' }}</span>
        </div>
        <div class="flex gap-2">
            <i class="fa-solid fa-file-lines mt-0.5 w-4 text-primary"></i>
            <span>{{ $application['cv_file'] ?? 'CV belum tersedia' }}</span>
        </div>
    </div>

    @if(!empty($application['student_note']))
        <p class="mt-4 rounded-md border border-border-color bg-surface p-3 text-sm text-text-gray">{{ $application['student_note'] }}</p>
    @endif

    <div class="mt-5 flex items-center justify-between gap-3">
        @if(isset($application['review_status']))
            <x-status-badge :status="$application['review_status']" />
        @endif
        <a href="{{ $detailUrl }}" class="text-sm font-medium text-primary hover:text-blue-900">Lihat detail</a>
    </div>
</article>
