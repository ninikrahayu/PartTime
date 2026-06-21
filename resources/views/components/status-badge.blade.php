@props(['status'])
@php
    $statusColors = [
        'aktif' => 'success',
        'selesai' => 'primary',
        'diterima' => 'success',
        'ditolak' => 'danger',
        'menunggu_review' => 'warning',
        'menunggu_verifikasi' => 'warning',
        'menunggu' => 'warning',
        'diproses' => 'info',
        'draft' => 'gray',
        'ditutup' => 'gray',
        'dibatalkan' => 'gray',
        'belum_upload_dokumen' => 'gray',
        'belum_bisa_review' => 'gray',
        'sudah_direview' => 'success',
        'terverifikasi' => 'success',
        'suspend' => 'danger',
        'pending' => 'warning',
        'verified' => 'success',
        'rejected' => 'danger',
        'aktif' => 'success',
        'nonaktif' => 'danger',
    ];
    
    // Normalize status string for matching (lowercase, replace spaces with underscores)
    $normalizedStatus = strtolower(str_replace(' ', '_', $status));
    $color = $statusColors[$normalizedStatus] ?? 'gray';
    
    // Format label for display (ucwords, replace underscores with spaces)
    $label = ucwords(str_replace('_', ' ', $status));
    
    // Translation map for common english statuses
    $translations = [
        'Pending' => 'Menunggu Verifikasi',
        'Verified' => 'Terverifikasi',
        'Rejected' => 'Ditolak',
    ];
    $label = $translations[$label] ?? $label;
@endphp
<x-badge :color="$color" {{ $attributes }}>
    {{ $label }}
</x-badge>