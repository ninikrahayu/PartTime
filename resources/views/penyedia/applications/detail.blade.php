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
                <h2 class="text-xl font-bold text-text-dark">ID: #{{ strtoupper(substr($application->id, -6)) }}</h2>
                <p class="text-sm text-text-gray">Dilamar pada {{ $application->created_at->format('d F Y, H:i') }}</p>
            </div>
        </div>
        
        <div class="flex flex-wrap gap-2">
            @if($application->status === 'pending')
                <form action="{{ route('penyedia.lamaran.status', $application->id) }}" method="POST">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="diproses">
                    <x-button type="submit" class="bg-white border border-info !text-info hover:bg-info/10">Mulai Proses</x-button>
                </form>
            @endif
            
            @if(in_array($application->status, ['pending', 'diproses']))
                <x-button onclick="openModal('modal-terima')" class="bg-success hover:bg-green-700 border-none">Terima Pelamar</x-button>
                <x-button onclick="openModal('modal-tolak')" class="bg-danger hover:bg-red-700 border-none">Tolak Pelamar</x-button>
            @endif

            @if($application->status === 'diterima')
                <form action="{{ route('penyedia.lamaran.status', $application->id) }}" method="POST">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="selesai">
                    <x-button type="submit" class="bg-primary border-none"><i class="fa-solid fa-check-double mr-2"></i>Tandai Selesai</x-button>
                </form>
            @endif

            @if($application->status === 'selesai')
                <x-button onclick="openModal('modal-review')" class="bg-secondary !text-text-dark hover:bg-yellow-500 border-none"><i class="fa-solid fa-star mr-2"></i>Beri Review</x-button>
            @endif
            
            <a href="{{ route('chat.show', $application->id) }}" class="inline-flex justify-center items-center rounded-md border border-primary text-primary bg-primary/5 px-4 py-2 text-sm font-medium hover:bg-primary/10 transition-colors">
                <i class="fa-solid fa-comments mr-2"></i> Chat
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Kolom Kiri: Detail Lamaran & Dokumen -->
        <div class="lg:col-span-2 space-y-6">
            
            <x-card class="shadow-sm border-border-color p-0">
                <x-slot name="header">
                    <div class="flex justify-between items-center">
                        <h3 class="font-bold text-text-dark">Informasi Lowongan</h3>
                        <x-status-badge :status="$application->status" />
                    </div>
                </x-slot>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6">
                    <div>
                        <p class="text-xs text-text-gray mb-1">Posisi / Judul Lowongan</p>
                        <p class="font-medium text-text-dark">{{ $application->lowongan->judul ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-text-gray mb-1">Status Saat Ini</p>
                        <p class="font-medium text-text-dark capitalize">{{ str_replace('_', ' ', $application->status) }}</p>
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
                        <div class="p-4 bg-surface rounded-md text-sm text-text-dark leading-relaxed whitespace-pre-wrap border border-border-color">{{ $application->catatan_tambahan ?? 'Tidak ada surat lamaran / cover letter.' }}</div>
                    </div>
                    
                    <div class="pt-4 border-t border-border-color">
                        <p class="text-sm font-semibold text-text-dark mb-3">Dokumen Lampiran (CV / KTM)</p>
                        <div class="flex items-center justify-between p-3 border border-border-color rounded-md">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-file-pdf text-danger text-2xl"></i>
                                <div>
                                    <p class="text-sm font-medium text-text-dark line-clamp-1">Berkas_{{ str_replace(' ', '_', $application->pelamar->name) }}.pdf</p>
                                </div>
                            </div>
                            @if(!empty($application->pelamar->profile->ktm_path))
                                <a href="{{ Storage::url($application->pelamar->profile->ktm_path) }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 border border-transparent font-medium rounded-md text-white bg-primary hover:bg-blue-900 shadow-sm transition-colors text-sm"><i class="fa-solid fa-download mr-1"></i> Download</a>
                            @else
                                <span class="text-xs text-text-gray">Belum ada berkas</span>
                            @endif
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
                            @if($penyediaReview)
                                <div class="text-secondary text-sm">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="{{ $i <= $penyediaReview->rating ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
                                    @endfor
                                </div>
                            @endif
                        </div>
                        @if($penyediaReview)
                            <p class="text-sm text-text-gray italic">"{{ $penyediaReview->comment ?? 'Tidak ada komentar.' }}"</p>
                            <p class="text-xs text-text-gray mt-2">Dikirim {{ $penyediaReview->created_at->diffForHumans() }}</p>
                        @else
                            <p class="text-sm text-text-gray italic">Anda belum memberikan review.</p>
                            <button onclick="openModal('modal-review')" class="mt-2 text-sm text-primary font-medium hover:underline"><i class="fa-solid fa-star mr-1"></i>Beri Review Sekarang</button>
                        @endif
                    </div>

                    <!-- Review dari Mahasiswa -->
                    <div class="bg-surface p-4 rounded-md border border-border-color">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-sm font-semibold text-text-dark">Review dari Mahasiswa</p>
                            @if($mahasiswaReview)
                                <div class="text-secondary text-sm">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="{{ $i <= $mahasiswaReview->rating ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
                                    @endfor
                                </div>
                            @endif
                        </div>
                        @if($mahasiswaReview)
                            <p class="text-sm text-text-gray italic">"{{ $mahasiswaReview->comment ?? 'Tidak ada komentar.' }}"</p>
                            <p class="text-xs text-text-gray mt-2">Dikirim {{ $mahasiswaReview->created_at->diffForHumans() }}</p>
                        @else
                            <p class="text-sm text-text-gray italic">Mahasiswa belum memberikan review.</p>
                        @endif
                    </div>
                </div>
            </x-card>
            @endif

        </div>

        <!-- Kolom Kanan: Profil Pelamar & Timeline -->
        <div class="space-y-6">
            
            <x-card class="shadow-sm border-border-color text-center">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($application->pelamar->name) }}&background=1E3A8A&color=fff&size=128" alt="{{ $application->pelamar->name }}" class="w-24 h-24 mx-auto rounded-full object-cover border-4 border-surface shadow-sm mb-4">
                <h3 class="font-bold text-lg text-text-dark">{{ $application->pelamar->name }}</h3>
                <p class="text-sm text-text-gray mb-1">Mahasiswa {{ $application->pelamar->profile->universitas ?? '-' }}</p>
                <div class="flex items-center justify-center gap-1 text-xs font-medium text-text-dark bg-secondary/20 px-2 py-1 rounded-full w-max mx-auto mb-4">
                    <i class="fa-solid fa-star text-secondary"></i> {{ $totalReviews > 0 ? number_format($avgRating, 1) : '-' }} ({{ $totalReviews }} Review)
                </div>
                
                <div class="border-t border-border-color pt-4 mt-4 text-left space-y-3">
                    <div class="flex items-center gap-3 text-sm">
                        <i class="fa-solid fa-envelope w-5 text-center text-text-gray"></i>
                        <span class="text-text-dark">{{ $application->pelamar->email }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm">
                        <i class="fa-solid fa-phone w-5 text-center text-text-gray"></i>
                        <span class="text-text-dark">{{ $application->pelamar->no_hp ?? '-' }}</span>
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
                        <p class="text-xs text-text-gray">{{ $application->created_at->format('d M Y, H:i') }}</p>
                    </div>

                    @if(in_array($application->status, ['diproses', 'diterima', 'ditolak', 'selesai']))
                    <div class="relative pl-6">
                        <div class="absolute w-3 h-3 bg-info rounded-full -left-[7px] top-1.5 ring-4 ring-white"></div>
                        <p class="text-sm font-semibold text-text-dark">Lamaran Diproses</p>
                        <p class="text-xs text-text-gray">Diperbarui oleh Anda</p>
                    </div>
                    @endif

                    @if(in_array($application->status, ['diterima', 'selesai']))
                    <div class="relative pl-6">
                        <div class="absolute w-3 h-3 bg-success rounded-full -left-[7px] top-1.5 ring-4 ring-white"></div>
                        <p class="text-sm font-semibold text-text-dark">Pelamar Diterima</p>
                        <p class="text-xs text-text-gray">Wawancara berhasil</p>
                    </div>
                    @endif

                    @if($application->status === 'ditolak')
                    <div class="relative pl-6">
                        <div class="absolute w-3 h-3 bg-danger rounded-full -left-[7px] top-1.5 ring-4 ring-white"></div>
                        <p class="text-sm font-semibold text-text-dark">Pelamar Ditolak</p>
                        <p class="text-xs text-text-gray">Tidak sesuai kriteria</p>
                    </div>
                    @endif

                    @if($application->status === 'selesai')
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
    <form action="{{ route('penyedia.lamaran.status', $application->id) }}" method="POST">
        @csrf @method('PUT')
        <input type="hidden" name="status" value="diterima">
        <div class="space-y-4">
            <p class="text-sm text-text-gray">Dengan menerima pelamar ini, status akan berubah menjadi diterima.</p>
        </div>
        <div class="mt-6 flex justify-end">
            <button type="button" class="mr-2 inline-flex justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-text-dark shadow-sm ring-1 ring-inset ring-border-color hover:bg-surface" onclick="closeModal('modal-terima')">Batal</button>
            <x-button type="submit" class="bg-success hover:bg-green-700">Ya, Terima Pelamar</x-button>
        </div>
    </form>
</x-modal>

<!-- Modal Tolak -->
<x-modal id="modal-tolak" title="Tolak Pelamar">
    <form action="{{ route('penyedia.lamaran.status', $application->id) }}" method="POST">
        @csrf @method('PUT')
        <input type="hidden" name="status" value="ditolak">
        <div class="space-y-4">
            <p class="text-sm text-text-gray">Dengan menolak pelamar ini, status akan berubah menjadi ditolak.</p>
        </div>
        <div class="mt-6 flex justify-end">
            <button type="button" class="mr-2 inline-flex justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-text-dark shadow-sm ring-1 ring-inset ring-border-color hover:bg-surface" onclick="closeModal('modal-tolak')">Batal</button>
            <x-button type="submit" class="bg-danger hover:bg-red-700">Tolak Pelamar</x-button>
        </div>
    </form>
</x-modal>

<!-- Modal Review -->
<x-modal id="modal-review" title="Beri Review Kepada Mahasiswa">
    <form action="{{ route('penyedia.lamaran.review', $application->id) }}" method="POST">
        @csrf
        <div class="space-y-4">
            <div class="text-center mb-4">
                <p class="text-sm font-medium text-text-dark mb-2">Beri Rating</p>
                <div class="flex justify-center gap-2 text-3xl text-border-color cursor-pointer" id="rating-stars">
                    <input type="hidden" name="rating" id="rating-input" required>
                    <i class="fa-solid fa-star hover:text-secondary" data-rating="1"></i>
                    <i class="fa-solid fa-star hover:text-secondary" data-rating="2"></i>
                    <i class="fa-solid fa-star hover:text-secondary" data-rating="3"></i>
                    <i class="fa-solid fa-star hover:text-secondary" data-rating="4"></i>
                    <i class="fa-solid fa-star hover:text-secondary" data-rating="5"></i>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-text-dark mb-1">Ulasan Anda</label>
                <x-textarea name="comment" placeholder="Ceritakan bagaimana kinerja mahasiswa ini..." rows="3"></x-textarea>
            </div>
        </div>
        <div class="mt-6 flex justify-end gap-2">
            <button type="button" class="inline-flex justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-text-dark shadow-sm ring-1 ring-inset ring-border-color hover:bg-surface" onclick="closeModal('modal-review')">Batal</button>
            <x-button type="submit">Kirim Review</x-button>
        </div>
    </form>
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

    // Rating Stars Logic
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('#rating-stars i');
        const ratingInput = document.getElementById('rating-input');
        
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.getAttribute('data-rating');
                ratingInput.value = rating;
                
                // Update stars visual
                stars.forEach(s => {
                    if (s.getAttribute('data-rating') <= rating) {
                        s.classList.add('text-secondary');
                        s.classList.remove('text-border-color');
                    } else {
                        s.classList.remove('text-secondary');
                        s.classList.add('text-border-color');
                    }
                });
            });
        });
    });
</script>
@endpush
@endsection
