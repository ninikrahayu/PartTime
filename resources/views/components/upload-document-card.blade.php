@props([
    'name',
    'title',
    'description' => null,
    'fileName' => null,
    'formats' => 'PDF, JPG, PNG',
    'maxSize' => '5MB',
    'accept' => '',
])

<section {{ $attributes->merge(['class' => 'rounded-md border border-border-color bg-white p-5 shadow-sm']) }}>
    <div class="flex items-start justify-between gap-4">
        <div>
            <h3 class="text-base font-semibold text-text-dark">{{ $title }}</h3>
            @if($description)
                <p class="mt-1 text-sm text-text-gray">{{ $description }}</p>
            @endif
        </div>
        @if($fileName)
            <x-badge color="success">Tersedia</x-badge>
        @else
            <x-badge color="gray">Belum upload</x-badge>
        @endif
    </div>

    @if($fileName)
        <div class="mt-4 flex items-center justify-between gap-3 rounded-md border border-border-color bg-surface p-3">
            <div class="min-w-0">
                <p class="truncate text-sm font-medium text-text-dark">{{ $fileName }}</p>
                <p class="mt-1 text-xs text-text-gray">{{ $formats }} maksimal {{ $maxSize }}</p>
            </div>
            <a href="#" class="shrink-0 text-sm font-medium text-primary hover:text-blue-900">Preview</a>
        </div>
    @endif

    <div class="mt-4">
        <x-file-upload :name="$name" label="Pilih file" :accept="$accept" />
        <p class="mt-2 text-xs text-text-gray">Format {{ $formats }}. Maksimal {{ $maxSize }}.</p>
    </div>
</section>
