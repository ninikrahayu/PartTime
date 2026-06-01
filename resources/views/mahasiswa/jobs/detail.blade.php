@extends('layouts.mahasiswa')
@section('title', 'Detail Lowongan - Mahasiswa Partimeku')
@section('page_title', 'Detail Pekerjaan')

@php
    // Simulasi data user
    $user = App\Services\DummyData::findById('users', 'usr-student-001');
    $isVerified = $user['verification_status'] === 'terverifikasi';
    
    // Fetch provider reviews explicitly
    $reviews = App\Services\DummyData::getCollection('reviews', 'provider_id', $job['provider_id'])->where('review_type', 'for_provider');
    $avgRating = $reviews->count() > 0 ? $reviews->avg('rating') : 0;
@endphp

@section('content')
<div class="max-w-4xl mx-auto space-y-4 md:space-y-6 pb-20 md:pb-6">

    <!-- Nav Back -->
    <a href="{{ url('/mahasiswa/jobs') }}" class="inline-flex items-center text-sm font-medium text-text-gray hover:text-primary transition-colors">
        <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke daftar lowongan
    </a>

    <!-- Header Card -->
    <x-card class="p-0 border-border-color shadow-sm overflow-hidden relative">
        <!-- Banner BG Dummy -->
        <div class="h-24 md:h-32 bg-primary/10 w-full relative">
            <!-- Save Button -->
            <button class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/90 backdrop-blur border border-border-color flex items-center justify-center text-text-gray hover:text-danger hover:border-danger transition-colors shadow-sm z-10" onclick="this.classList.toggle('text-danger'); this.classList.toggle('text-text-gray'); this.querySelector('i').classList.toggle('fa-solid'); this.querySelector('i').classList.toggle('fa-regular'); showToast('Disimpan ke Favorit', 'success');">
                <i class="fa-regular fa-heart text-lg"></i>
            </button>
        </div>
        
        <div class="px-5 md:px-8 pb-6">
            <div class="flex flex-col md:flex-row gap-4 items-start md:items-end -mt-10 md:-mt-12 relative z-10 mb-4">
                <img src="{{ asset($job['provider_logo'] ?? 'images/dummy/default-logo.png') }}" alt="{{ $job['provider_name'] }}" class="w-20 h-20 md:w-24 md:h-24 rounded-md object-cover border-4 border-white shadow-sm bg-white" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($job['provider_name']) }}&background=F9FAFB'">
                
                <div class="flex-1 pt-2 md:pt-0">
                    <div class="flex items-center gap-2 mb-1">
                        <x-badge color="info">{{ $job['category'] }}</x-badge>
                        <x-status-badge :status="$job['status']" />
                    </div>
                    <h1 class="text-xl md:text-2xl font-bold text-text-dark line-clamp-2">{{ $job['title'] }}</h1>
                </div>
            </div>

            <div class="grid grid-cols-2 md:flex md:flex-wrap gap-4 md:gap-8 border-t border-border-color pt-4">
                <div>
                    <p class="text-xs text-text-gray mb-1"><i class="fa-solid fa-store w-4 text-center mr-1 text-primary/70"></i> Penyedia</p>
                    <p class="font-semibold text-sm text-text-dark line-clamp-1">{{ $job['provider_name'] }}</p>
                </div>
                <div>
                    <p class="text-xs text-text-gray mb-1"><i class="fa-solid fa-star w-4 text-center mr-1 text-secondary"></i> Rating</p>
                    <p class="font-semibold text-sm text-text-dark">{{ number_format($avgRating, 1) }} <span class="font-normal text-text-gray">({{ $reviews->count() }})</span></p>
                </div>
                <div>
                    <p class="text-xs text-text-gray mb-1"><i class="fa-solid fa-location-dot w-4 text-center mr-1 text-primary/70"></i> Lokasi</p>
                    <p class="font-semibold text-sm text-text-dark line-clamp-1">{{ $job['location'] }}</p>
                </div>
                <div>
                    <p class="text-xs text-text-gray mb-1"><i class="fa-solid fa-money-bill-wave w-4 text-center mr-1 text-primary/70"></i> Gaji</p>
                    <p class="font-semibold text-sm text-text-dark text-success">Rp {{ number_format($job['salary'], 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </x-card>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Left: Deskripsi & Syarat -->
        <div class="md:col-span-2 space-y-6">
            
            <x-card class="shadow-sm border-border-color p-5 md:p-6 text-sm">
                <h3 class="text-lg font-bold text-text-dark mb-3">Deskripsi Pekerjaan</h3>
                <div class="prose prose-sm max-w-none text-text-gray leading-relaxed mb-8">
                    {!! nl2br(e($job['description'])) !!}
                </div>

                <h3 class="text-lg font-bold text-text-dark mb-3">Persyaratan Khusus</h3>
                <ul class="space-y-3">
                    @foreach($job['requirements'] ?? [] as $req)
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-check text-success mt-0.5"></i>
                            <span class="text-text-gray">{{ $req }}</span>
                        </li>
                    @endforeach
                </ul>
            </x-card>

            @if($reviews->count() > 0)
            <x-card class="shadow-sm border-border-color p-5 text-sm">
                <h3 class="text-lg font-bold text-text-dark mb-4">Review Tempat Kerja</h3>
                <div class="space-y-4">
                    @foreach($reviews as $review)
                        <div class="bg-surface p-4 rounded-md border border-border-color">
                            <div class="flex items-center justify-between mb-2">
                                <p class="font-semibold text-text-dark">Mahasiswa Terverifikasi</p>
                                <div class="text-secondary text-xs">
                                    @for($i=1; $i<=5; $i++)
                                        <i class="fa-{{ $i <= $review['rating'] ? 'solid' : 'regular' }} fa-star"></i>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-text-gray italic">"{{ $review['comment'] }}"</p>
                            <p class="text-[10px] text-text-gray mt-2 text-right">{{ \Carbon\Carbon::parse($review['created_at'])->format('d M Y') }}</p>
                        </div>
                    @endforeach
                </div>
            </x-card>
            @endif
        </div>

        <!-- Right: Summary & Action -->
        <div class="md:col-span-1">
            <div class="sticky top-20 space-y-4">
                
                <x-card class="shadow-sm border-border-color p-5">
                    <h3 class="font-bold text-text-dark text-sm mb-4">Ringkasan Jadwal</h3>
                    <div class="p-3 bg-surface rounded-md border border-border-color flex items-center justify-center text-center mb-4">
                        <span class="font-semibold text-primary">{{ $job['schedule'] }}</span>
                    </div>
                    <p class="text-xs text-text-gray text-center mb-4">Dipublikasikan: {{ \Carbon\Carbon::parse($job['created_at'])->format('d M Y') }}</p>
                    
                    @if(!$isVerified)
                        <!-- Jika akun belum terverifikasi -->
                        <div class="p-3 bg-warning/10 border border-warning/20 rounded-md mb-4 text-center">
                            <i class="fa-solid fa-triangle-exclamation text-warning mb-2 text-xl"></i>
                            <p class="text-xs text-warning font-medium">Akun Anda belum terverifikasi. Tunggu proses verifikasi admin untuk dapat melamar pekerjaan.</p>
                        </div>
                        <x-button disabled class="w-full justify-center">Lamar Pekerjaan Ini</x-button>
                    @elseif($job['status'] !== 'aktif')
                        <!-- Jika lowongan tutup -->
                        <div class="p-3 bg-danger/10 border border-danger/20 rounded-md mb-4 text-center">
                            <i class="fa-solid fa-ban text-danger mb-2 text-xl"></i>
                            <p class="text-xs text-danger font-medium">Lowongan ini sudah ditutup atau tidak menerima lamaran baru.</p>
                        </div>
                        <x-button disabled class="w-full justify-center">Lamar Pekerjaan Ini</x-button>
                    @else
                        <!-- Bisa melamar -->
                        <x-button class="w-full justify-center text-base py-3" onclick="openModal('modal-lamar')">Lamar Pekerjaan Ini</x-button>
                        <p class="text-[10px] text-text-gray text-center mt-2">Dengan melamar, profil dan CV Anda akan dikirimkan kepada penyedia.</p>
                    @endif
                </x-card>

                <!-- Box Bantuan -->
                <div class="bg-blue-50 border border-blue-100 rounded-md p-4 flex gap-3 items-start">
                    <i class="fa-solid fa-circle-info text-primary mt-0.5"></i>
                    <div>
                        <p class="text-xs font-semibold text-primary mb-1">Tips Melamar</p>
                        <p class="text-[10px] text-blue-800 leading-relaxed">Pastikan CV dan profil Anda sudah terisi lengkap. Tuliskan pesan singkat yang menarik saat mengirim lamaran.</p>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<!-- Modal Lamar -->
<x-modal id="modal-lamar" title="Kirim Lamaran">
    <div class="space-y-4">
        <div class="p-3 bg-surface border border-border-color rounded-md flex items-center gap-3">
            <i class="fa-solid fa-file-pdf text-danger text-2xl"></i>
            <div>
                <p class="text-sm font-semibold text-text-dark">CV Anda Akan Dilampirkan</p>
                <p class="text-xs text-text-gray">Pastikan CV di profil Anda adalah yang terbaru.</p>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-text-dark mb-1">Cover Letter Singkat / Pesan</label>
            <x-textarea rows="4" placeholder="Halo Bapak/Ibu, saya sangat tertarik dengan posisi ini karena..."></x-textarea>
            <p class="text-[10px] text-text-gray mt-1">Maksimal 500 karakter.</p>
        </div>
    </div>
    <x-slot name="footer">
        <x-button onclick="closeModal('modal-lamar'); showToast('Lamaran berhasil dikirim!', 'success')">Kirim Lamaran Sekarang</x-button>
        <button type="button" class="ml-2 inline-flex justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-text-dark shadow-sm ring-1 ring-inset ring-border-color hover:bg-surface" onclick="closeModal('modal-lamar')">Batal</button>
    </x-slot>
</x-modal>

<!-- Mobile Fixed Bottom CTA Action -->
<div class="fixed bottom-16 inset-x-0 bg-white border-t border-border-color p-3 z-40 md:hidden shadow-[0_-5px_15px_rgba(0,0,0,0.05)]">
    <div class="flex gap-2 max-w-4xl mx-auto">
        <button class="w-12 flex-shrink-0 flex items-center justify-center rounded-md border border-border-color text-text-gray hover:bg-surface" onclick="this.classList.toggle('text-danger'); this.querySelector('i').classList.toggle('fa-solid'); this.querySelector('i').classList.toggle('fa-regular'); showToast('Disimpan ke Favorit', 'success');">
            <i class="fa-regular fa-heart text-xl"></i>
        </button>
        @if(!$isVerified || $job['status'] !== 'aktif')
            <x-button disabled class="flex-1 justify-center">Lamar</x-button>
        @else
            <x-button class="flex-1 justify-center bg-primary" onclick="openModal('modal-lamar')">Lamar Sekarang</x-button>
        @endif
    </div>
</div>

<!-- Toast Container (Adjusted for bottom nav on mobile) -->
<div id="toast-container" class="fixed bottom-36 md:bottom-4 right-4 z-[200] flex flex-col gap-2"></div>
<template id="toast-template">
    <div class="toast-item flex items-center w-full max-w-xs p-4 text-text-dark bg-white rounded-md shadow-lg border border-border-color transition-all duration-300 transform translate-x-full opacity-0">
        <div class="toast-icon inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg"></div>
        <div class="toast-message ml-3 text-sm font-medium"></div>
        <button type="button" class="toast-close ml-auto -mx-1.5 -my-1.5 bg-white text-text-gray hover:text-text-dark rounded-md p-1.5 inline-flex items-center justify-center h-8 w-8"><i class="fa-solid fa-xmark"></i></button>
    </div>
</template>

@push('scripts')
<script>
    function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
    function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
</script>
@endpush
@endsection
