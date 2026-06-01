@props([
    'status' => 'belum_upload_dokumen',
    'title' => 'Status Verifikasi',
    'description' => null,
    'rejectionReason' => null,
])

@php
    $normalizedStatus = strtolower(str_replace(' ', '_', $status));
    $messages = [
        'belum_upload_dokumen' => 'Lengkapi dokumen agar akun dapat diverifikasi.',
        'menunggu_verifikasi' => 'Dokumen sudah dikirim dan sedang menunggu verifikasi admin.',
        'terverifikasi' => 'Akun sudah terverifikasi dan dapat menggunakan fitur utama.',
        'ditolak' => 'Dokumen belum memenuhi syarat verifikasi.',
    ];
@endphp

<section {{ $attributes->merge(['class' => 'rounded-md border border-border-color bg-white p-5 shadow-sm']) }}>
    <div class="flex items-start justify-between gap-4">
        <div>
            <h3 class="text-base font-semibold text-text-dark">{{ $title }}</h3>
            <p class="mt-1 text-sm text-text-gray">{{ $description ?? ($messages[$normalizedStatus] ?? 'Status verifikasi belum tersedia.') }}</p>
        </div>
        <x-status-badge :status="$status" class="shrink-0" />
    </div>

    @if($rejectionReason)
        <div class="mt-4 rounded-md border border-danger/20 bg-danger/5 p-3 text-sm text-danger">
            {{ $rejectionReason }}
        </div>
    @endif

    @if(isset($actions))
        <div class="mt-5 flex flex-wrap gap-2">
            {{ $actions }}
        </div>
    @endif
</section>
