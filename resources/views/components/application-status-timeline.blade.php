@props([
    'timeline' => [],
])

<ol {{ $attributes->merge(['class' => 'space-y-4']) }}>
    @forelse($timeline as $item)
        <li class="flex gap-3">
            <span class="mt-1 flex h-6 w-6 shrink-0 items-center justify-center rounded-md border {{ ($item['is_done'] ?? false) ? 'border-success bg-success text-white' : 'border-border-color bg-white text-text-gray' }}">
                <i class="fa-solid {{ ($item['is_done'] ?? false) ? 'fa-check' : 'fa-clock' }} text-xs"></i>
            </span>
            <span class="min-w-0">
                <span class="block text-sm font-medium text-text-dark">{{ $item['label'] ?? '-' }}</span>
                <span class="mt-1 block text-xs text-text-gray">{{ $item['date'] ?? 'Belum tersedia' }}</span>
            </span>
        </li>
    @empty
        <li class="rounded-md border border-border-color bg-surface p-4 text-sm text-text-gray">
            Timeline status belum tersedia.
        </li>
    @endforelse
</ol>
