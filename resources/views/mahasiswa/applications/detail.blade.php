@extends('layouts.mahasiswa')
@section('title', 'Detail Lamaran - Mahasiswa Partimeku')
@section('page_title', 'Detail Lamaran')

@section('content')
<div class="max-w-4xl mx-auto space-y-4 md:space-y-6 pb-20 md:pb-6">

    <a href="{{ url('/mahasiswa/applications') }}" class="inline-flex items-center text-sm font-medium text-text-gray hover:text-primary transition-colors">
        <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke status lamaran
    </a>

    <x-card class="shadow-sm border-border-color p-0 overflow-hidden">
        <div class="p-5 md:p-6 flex flex-col md:flex-row gap-5 items-start justify-between">
            <div class="flex items-start gap-4">
                <div class="w-16 h-16 rounded-md bg-surface border border-border-color flex items-center justify-center shrink-0 shadow-sm">
                    <i class="fa-solid fa-briefcase text-text-gray text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-text-dark mb-1">{{ $application['job_title'] }}</h1>
                    <p class="text-sm text-text-gray mb-3">{{ $application['provider_name'] }}</p>
                    <div class="flex gap-2">
                        <x-badge color="info">Part Time</x-badge>
                        <x-status-badge :status="$application['status']" />
                    </div>
                </div>
            </div>
            
            <div class="w-full md:w-auto flex flex-col gap-2 mt-4 md:mt-0 pt-4 md:pt-0 border-t md:border-t-0 border-border-color">
                <a href="#" class="w-full justify-center inline-flex items-center px-4 py-2 bg-white border border-border-color text-text-dark text-sm font-medium rounded-md hover:bg-surface transition-colors shadow-sm"><i class="fa-solid fa-eye mr-2"></i> Lihat Lowongan</a>
                @if($application['status'] === 'selesai')
                    <x-button onclick="openModal('modal-review')" class="w-full justify-center bg-secondary !text-text-dark hover:bg-yellow-500 border-none"><i class="fa-solid fa-star mr-2"></i> Beri Review</x-button>
                @endif
            </div>
        </div>
    </x-card>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <div class="space-y-6">
            <x-card class="shadow-sm border-border-color p-0">
                <x-slot name="header">
                    <h3 class="font-bold text-text-dark text-sm uppercase tracking-wider">Pesan / Cover Letter Anda</h3>
                </x-slot>
                <div class="p-5">
                    <p class="text-sm text-text-gray leading-relaxed whitespace-pre-wrap">{{ $application['cover_letter'] }}</p>
                </div>
            </x-card>

            @if($application['notes_from_provider'])
            <x-card class="shadow-sm border-border-color p-0">
                <x-slot name="header">
                    <h3 class="font-bold text-text-dark text-sm uppercase tracking-wider text-primary">Catatan dari Penyedia</h3>
                </x-slot>
                <div class="p-5">
                    <div class="bg-blue-50 border border-blue-100 rounded-md p-4 flex gap-3 items-start">
                        <i class="fa-solid fa-comment-dots text-primary mt-1"></i>
                        <p class="text-sm text-text-dark leading-relaxed font-medium">{{ $application['notes_from_provider'] }}</p>
                    </div>
                </div>
            </x-card>
            @endif
        </div>

        <div>
            <x-card class="shadow-sm border-border-color p-0">
                <x-slot name="header">
                    <h3 class="font-bold text-text-dark text-sm uppercase tracking-wider">Timeline Lamaran</h3>
                </x-slot>
                
                <div class="p-5 relative border-l-2 border-border-color ml-8 space-y-6 my-2">
                    <div class="relative pl-6">
                        <div class="absolute w-4 h-4 bg-primary rounded-full -left-[9px] top-0.5 ring-4 ring-white"></div>
                        <p class="text-sm font-bold text-text-dark">Terkirim</p>
                        <p class="text-xs text-text-gray mb-1">{{ \Carbon\Carbon::parse($application['applied_at'])->format('d M Y, H:i') }}</p>
                        <p class="text-xs text-text-gray">Lamaran berhasil dikirim ke penyedia.</p>
                    </div>

                    @if(in_array($application['status'], ['diproses', 'diterima', 'ditolak', 'selesai']))
                    <div class="relative pl-6">
                        <div class="absolute w-4 h-4 bg-info rounded-full -left-[9px] top-0.5 ring-4 ring-white"></div>
                        <p class="text-sm font-bold text-text-dark">Sedang Diproses</p>
                        <p class="text-xs text-text-gray mb-1">Penyedia sedang meninjau profil Anda.</p>
                    </div>
                    @endif

                    @if(in_array($application['status'], ['diterima', 'selesai']))
                    <div class="relative pl-6">
                        <div class="absolute w-4 h-4 bg-success rounded-full -left-[9px] top-0.5 ring-4 ring-white"></div>
                        <p class="text-sm font-bold text-text-dark">Selamat, Diterima!</p>
                        <p class="text-xs text-text-gray mb-1">Silakan baca catatan dari penyedia untuk info lebih lanjut.</p>
                    </div>
                    @endif

                    @if($application['status'] === 'ditolak')
                    <div class="relative pl-6">
                        <div class="absolute w-4 h-4 bg-danger rounded-full -left-[9px] top-0.5 ring-4 ring-white"></div>
                        <p class="text-sm font-bold text-text-dark">Lamaran Ditolak</p>
                        <p class="text-xs text-text-gray mb-1">Jangan patah semangat, coba lamar di tempat lain!</p>
                    </div>
                    @endif

                    @if($application['status'] === 'selesai')
                    <div class="relative pl-6">
                        <div class="absolute w-4 h-4 bg-primary rounded-full -left-[9px] top-0.5 ring-4 ring-white"></div>
                        <p class="text-sm font-bold text-text-dark">Pekerjaan Selesai</p>
                        <p class="text-xs text-text-gray mb-1">Pekerjaan telah ditandai selesai oleh penyedia. Jangan lupa berikan ulasan.</p>
                    </div>
                    @endif
                </div>
            </x-card>
        </div>

    </div>
</div>

<!-- Modal Review -->
<x-modal id="modal-review" title="Beri Review Kepada Penyedia">
    <div class="space-y-4">
        <div class="text-center mb-4">
            <p class="text-sm font-medium text-text-dark mb-2">Beri Rating</p>
            <div class="flex justify-center gap-2 text-3xl text-border-color cursor-pointer">
                <i class="fa-solid fa-star hover:text-secondary"></i>
                <i class="fa-solid fa-star hover:text-secondary"></i>
                <i class="fa-solid fa-star hover:text-secondary"></i>
                <i class="fa-solid fa-star hover:text-secondary"></i>
                <i class="fa-solid fa-star hover:text-secondary"></i>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-text-dark mb-1">Ulasan Anda</label>
            <x-textarea placeholder="Ceritakan bagaimana pengalaman Anda bekerja di tempat ini..." rows="3"></x-textarea>
        </div>
    </div>
    <x-slot name="footer">
        <x-button onclick="closeModal('modal-review'); showToast('Review berhasil dikirim', 'success')">Kirim Review</x-button>
        <button type="button" class="ml-2 inline-flex justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-text-dark shadow-sm ring-1 ring-inset ring-border-color hover:bg-surface" onclick="closeModal('modal-review')">Batal</button>
    </x-slot>
</x-modal>

<!-- Toast Container -->
<div id="toast-container" class="fixed bottom-20 md:bottom-4 right-4 z-[200] flex flex-col gap-2"></div>
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
