@extends('layouts.penyedia')
@section('title', 'Detail Lamaran - Penyedia Partimeku')
@section('page_title', 'Detail Lamaran')

@section('content')
<div class="space-y-6">
    <!-- Header Action -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-border-color pb-4">
        <div class="flex items-center gap-3">
            <a href="{{ url('/penyedia/applications') }}" class="w-10 h-10 flex items-center justify-center rounded-md bg-white border border-border-color text-text-gray hover:bg-surface transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="text-xl font-bold text-text-dark">ID: #{{ strtoupper(substr($application['id'], -6)) }}</h2>
                <p class="text-sm text-text-gray">Dilamar pada {{ \Carbon\Carbon::parse($application['applied_at'])->format('d F Y, H:i') }}</p>
            </div>
        </div>
        
        <div class="flex flex-wrap gap-2">
            @if($application['status'] === 'menunggu')
                <x-button onclick="showToast('Status diubah menjadi Diproses', 'info')" class="bg-white border border-info !text-info hover:bg-info/10">Mulai Proses</x-button>
            @endif
            
            @if(in_array($application['status'], ['menunggu', 'diproses']))
                <x-button onclick="openModal('modal-terima')" class="bg-success hover:bg-green-700 border-none">Terima Pelamar</x-button>
                <x-button onclick="openModal('modal-tolak')" class="bg-danger hover:bg-red-700 border-none">Tolak Pelamar</x-button>
            @endif

            @if($application['status'] === 'diterima')
                <x-button onclick="showToast('Pekerjaan ditandai selesai', 'success')" class="bg-primary border-none"><i class="fa-solid fa-check-double mr-2"></i>Tandai Selesai</x-button>
            @endif

            @if($application['status'] === 'selesai')
                <x-button onclick="openModal('modal-review')" class="bg-secondary !text-text-dark hover:bg-yellow-500 border-none"><i class="fa-solid fa-star mr-2"></i>Beri Review</x-button>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Kolom Kiri: Detail Lamaran & Dokumen -->
        <div class="lg:col-span-2 space-y-6">
            
            <x-card class="shadow-sm border-border-color p-0">
                <x-slot name="header">
                    <div class="flex justify-between items-center">
                        <h3 class="font-bold text-text-dark">Informasi Lowongan</h3>
                        <x-status-badge :status="$application['status']" />
                    </div>
                </x-slot>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6">
                    <div>
                        <p class="text-xs text-text-gray mb-1">Posisi / Judul Lowongan</p>
                        <p class="font-medium text-text-dark">{{ $application['job_title'] }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-text-gray mb-1">Status Saat Ini</p>
                        <p class="font-medium text-text-dark capitalize">{{ str_replace('_', ' ', $application['status']) }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-xs text-text-gray mb-1">Catatan dari Anda (Penyedia)</p>
                        @if($application['notes_from_provider'] ?? false)
                            <p class="text-sm text-text-dark bg-surface p-3 rounded-md border border-border-color">{{ $application['notes_from_provider'] }}</p>
                        @else
                            <p class="text-sm text-text-gray italic">Tidak ada catatan untuk pelamar.</p>
                        @endif
                    </div>
                </div>
            </x-card>

            <x-card class="shadow-sm border-border-color p-0">
                <x-slot name="header">
                    <h3 class="font-bold text-text-dark">Pesan & Dokumen Pelamar</h3>
                </x-slot>
                
                <div class="space-y-6">
                    <div>
                        <p class="text-sm font-semibold text-text-dark mb-2">Surat Lamaran / Cover Letter</p>
                        <div class="p-4 bg-surface rounded-md text-sm text-text-dark leading-relaxed whitespace-pre-wrap border border-border-color">{{ $application['cover_letter'] ?? 'Tidak ada surat lamaran / cover letter.' }}</div>
                    </div>
                    
                    <div class="pt-4 border-t border-border-color">
                        <p class="text-sm font-semibold text-text-dark mb-3">Dokumen Lampiran (CV)</p>
                        <div class="flex items-center justify-between p-3 border border-border-color rounded-md">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-file-pdf text-danger text-2xl"></i>
                                <div>
                                    <p class="text-sm font-medium text-text-dark line-clamp-1">CV_{{ str_replace(' ', '_', $application['student_name']) }}.pdf</p>
                                    <p class="text-xs text-text-gray">1.2 MB</p>
                                </div>
                            </div>
                            <x-button onclick="showToast('Mengunduh CV...', 'info')" class="text-sm py-1.5"><i class="fa-solid fa-download mr-1"></i> Download</x-button>
                        </div>
                    </div>
                </div>
            </x-card>

            @if($application['status'] === 'selesai')
            <x-card class="shadow-sm border-border-color p-0">
                <x-slot name="header">
                    <h3 class="font-bold text-text-dark">Review Pekerjaan</h3>
                </x-slot>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Review dari Penyedia -->
                    <div class="bg-surface p-4 rounded-md border border-border-color">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-sm font-semibold text-text-dark">Review Anda</p>
                            <div class="text-secondary text-sm"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        </div>
                        <p class="text-sm text-text-gray italic">"Pekerjaannya sangat bagus dan on-time." (Dummy Data)</p>
                    </div>

                    <!-- Review dari Mahasiswa -->
                    <div class="bg-surface p-4 rounded-md border border-border-color">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-sm font-semibold text-text-dark">Review dari Mahasiswa</p>
                            <div class="text-secondary text-sm"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i></div>
                        </div>
                        <p class="text-sm text-text-gray italic">"Lingkungan kerjanya enak, bosnya ramah." (Dummy Data)</p>
                    </div>
                </div>
            </x-card>
            @endif

        </div>

        <!-- Kolom Kanan: Profil Pelamar & Timeline -->
        <div class="space-y-6">
            
            <x-card class="shadow-sm border-border-color text-center">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($application['student_name']) }}&background=1E3A8A&color=fff&size=128" alt="{{ $application['student_name'] }}" class="w-24 h-24 mx-auto rounded-full object-cover border-4 border-surface shadow-sm mb-4">
                <h3 class="font-bold text-lg text-text-dark">{{ $application['student_name'] }}</h3>
                <p class="text-sm text-text-gray mb-1">Mahasiswa ITATS</p>
                <div class="flex items-center justify-center gap-1 text-xs font-medium text-text-dark bg-secondary/20 px-2 py-1 rounded-full w-max mx-auto mb-4">
                    <i class="fa-solid fa-star text-secondary"></i> 4.8 (12 Review)
                </div>
                
                <div class="border-t border-border-color pt-4 mt-4 text-left space-y-3">
                    <div class="flex items-center gap-3 text-sm">
                        <i class="fa-solid fa-envelope w-5 text-center text-text-gray"></i>
                        <span class="text-text-dark">{{ strtolower(str_replace(' ', '', $application['student_name'])) }}@gmail.com</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm">
                        <i class="fa-solid fa-phone w-5 text-center text-text-gray"></i>
                        <span class="text-text-dark">+62 812-3456-7890</span>
                    </div>
                </div>
            </x-card>

            <x-card class="shadow-sm border-border-color p-0">
                <x-slot name="header">
                    <h3 class="font-bold text-text-dark text-sm">Timeline Lamaran</h3>
                </x-slot>
                
                <div class="relative border-l-2 border-border-color ml-3 space-y-6">
                    <div class="relative pl-6">
                        <div class="absolute w-3 h-3 bg-primary rounded-full -left-[7px] top-1.5 ring-4 ring-white"></div>
                        <p class="text-sm font-semibold text-text-dark">Lamaran Dikirim</p>
                        <p class="text-xs text-text-gray">{{ \Carbon\Carbon::parse($application['applied_at'])->format('d M Y, H:i') }}</p>
                    </div>

                    @if(in_array($application['status'], ['diproses', 'diterima', 'ditolak', 'selesai']))
                    <div class="relative pl-6">
                        <div class="absolute w-3 h-3 bg-info rounded-full -left-[7px] top-1.5 ring-4 ring-white"></div>
                        <p class="text-sm font-semibold text-text-dark">Lamaran Diproses</p>
                        <p class="text-xs text-text-gray">Diperbarui oleh Anda</p>
                    </div>
                    @endif

                    @if(in_array($application['status'], ['diterima', 'selesai']))
                    <div class="relative pl-6">
                        <div class="absolute w-3 h-3 bg-success rounded-full -left-[7px] top-1.5 ring-4 ring-white"></div>
                        <p class="text-sm font-semibold text-text-dark">Pelamar Diterima</p>
                        <p class="text-xs text-text-gray">Wawancara berhasil</p>
                    </div>
                    @endif

                    @if($application['status'] === 'ditolak')
                    <div class="relative pl-6">
                        <div class="absolute w-3 h-3 bg-danger rounded-full -left-[7px] top-1.5 ring-4 ring-white"></div>
                        <p class="text-sm font-semibold text-text-dark">Pelamar Ditolak</p>
                        <p class="text-xs text-text-gray">Tidak sesuai kriteria</p>
                    </div>
                    @endif

                    @if($application['status'] === 'selesai')
                    <div class="relative pl-6">
                        <div class="absolute w-3 h-3 bg-primary rounded-full -left-[7px] top-1.5 ring-4 ring-white"></div>
                        <p class="text-sm font-semibold text-text-dark">Pekerjaan Selesai</p>
                        <p class="text-xs text-text-gray">Pekerjaan telah diselesaikan</p>
                    </div>
                    @endif
                </div>
            </x-card>

        </div>
    </div>
</div>

<!-- Modal Terima -->
<x-modal id="modal-terima" title="Terima Pelamar">
    <div class="space-y-4">
        <p class="text-sm text-text-gray">Dengan menerima pelamar ini, notifikasi akan dikirimkan ke mahasiswa bersangkutan.</p>
        <x-textarea placeholder="Pesan untuk pelamar (contoh: Jadwal hari pertama kerja)..." rows="3"></x-textarea>
    </div>
    <x-slot name="footer">
        <x-button onclick="closeModal('modal-terima'); showToast('Pelamar berhasil diterima', 'success')">Ya, Terima Pelamar</x-button>
        <button type="button" class="ml-2 inline-flex justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-text-dark shadow-sm ring-1 ring-inset ring-border-color hover:bg-surface" onclick="closeModal('modal-terima')">Batal</button>
    </x-slot>
</x-modal>

<!-- Modal Tolak -->
<x-modal id="modal-tolak" title="Tolak Pelamar">
    <div class="space-y-4">
        <p class="text-sm text-text-gray">Berikan alasan penolakan agar mahasiswa dapat mengevaluasi lamarannya. Pesan ini akan dikirimkan ke mahasiswa.</p>
        <x-textarea placeholder="Alasan penolakan..." rows="3"></x-textarea>
    </div>
    <x-slot name="footer">
        <x-button class="bg-danger hover:bg-red-700" onclick="closeModal('modal-tolak'); showToast('Lamaran ditolak', 'success')">Tolak Pelamar</x-button>
        <button type="button" class="ml-2 inline-flex justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-text-dark shadow-sm ring-1 ring-inset ring-border-color hover:bg-surface" onclick="closeModal('modal-tolak')">Batal</button>
    </x-slot>
</x-modal>

<!-- Modal Review -->
<x-modal id="modal-review" title="Beri Review Kepada Mahasiswa">
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
            <x-textarea placeholder="Ceritakan bagaimana kinerja mahasiswa ini..." rows="3"></x-textarea>
        </div>
    </div>
    <x-slot name="footer">
        <x-button onclick="closeModal('modal-review'); showToast('Review berhasil dikirim', 'success')">Kirim Review</x-button>
        <button type="button" class="ml-2 inline-flex justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-text-dark shadow-sm ring-1 ring-inset ring-border-color hover:bg-surface" onclick="closeModal('modal-review')">Batal</button>
    </x-slot>
</x-modal>

<!-- Toast Container -->
<div id="toast-container" class="fixed bottom-4 right-4 z-[200] flex flex-col gap-2"></div>
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
