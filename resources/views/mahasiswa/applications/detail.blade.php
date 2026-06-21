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
                    <h1 class="text-xl font-bold text-text-dark mb-1">{{ $application->lowongan->judul ?? '-' }}</h1>
                    <p class="text-sm text-text-gray mb-3">{{ $application->lowongan->penyedia->name ?? '-' }}</p>
                    <div class="flex gap-2">
                        <x-badge color="info">Part Time</x-badge>
                        <x-status-badge :status="$application->status" />
                    </div>
                </div>
            </div>
            
            <div class="w-full md:w-auto flex flex-col gap-2 mt-4 md:mt-0 pt-4 md:pt-0 border-t md:border-t-0 border-border-color">
                <a href="{{ url('/mahasiswa/lowongan/' . $application->lowongan_id) }}" class="w-full justify-center inline-flex items-center px-4 py-2 bg-white border border-border-color text-text-dark text-sm font-medium rounded-md hover:bg-surface transition-colors shadow-sm"><i class="fa-solid fa-eye mr-2"></i> Lihat Lowongan</a>
                @if(in_array($application->status, ['diterima', 'diproses', 'selesai']))
                    <a href="{{ route('chat.show', $application->id) }}" class="w-full justify-center inline-flex items-center rounded-md border border-primary text-primary bg-primary/5 px-4 py-2 text-sm font-medium hover:bg-primary/10 transition-colors">
                        <i class="fa-solid fa-comments mr-2"></i> Chat Penyedia
                    </a>
                @endif
                @if($application->status === 'selesai')
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
                    <p class="text-sm text-text-gray leading-relaxed whitespace-pre-wrap">{{ $application->catatan_tambahan ?? 'Tidak ada pesan / cover letter tambahan.' }}</p>
                </div>
            </x-card>


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
                        <p class="text-xs text-text-gray mb-1">{{ $application->created_at->format('d M Y, H:i') }}</p>
                        <p class="text-xs text-text-gray">Lamaran berhasil dikirim ke penyedia.</p>
                    </div>

                    @if(in_array($application->status, ['diproses', 'diterima', 'ditolak', 'selesai']))
                    <div class="relative pl-6">
                        <div class="absolute w-4 h-4 bg-info rounded-full -left-[9px] top-0.5 ring-4 ring-white"></div>
                        <p class="text-sm font-bold text-text-dark">Sedang Diproses</p>
                        <p class="text-xs text-text-gray mb-1">Penyedia sedang meninjau profil Anda.</p>
                    </div>
                    @endif

                    @if(in_array($application->status, ['diterima', 'selesai']))
                    <div class="relative pl-6">
                        <div class="absolute w-4 h-4 bg-success rounded-full -left-[9px] top-0.5 ring-4 ring-white"></div>
                        <p class="text-sm font-bold text-text-dark">Selamat, Diterima!</p>
                        <p class="text-xs text-text-gray mb-1">Tunggu instruksi selanjutnya dari penyedia kerja.</p>
                    </div>
                    @endif

                    @if($application->status === 'ditolak')
                    <div class="relative pl-6">
                        <div class="absolute w-4 h-4 bg-danger rounded-full -left-[9px] top-0.5 ring-4 ring-white"></div>
                        <p class="text-sm font-bold text-text-dark">Lamaran Ditolak</p>
                        <p class="text-xs text-text-gray mb-1">Jangan patah semangat, coba lamar di tempat lain!</p>
                    </div>
                    @endif

                    @if($application->status === 'selesai')
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

    @if($application->status === 'selesai')
    <x-card class="shadow-sm border-border-color p-0">
        <x-slot name="header">
            <h3 class="font-bold text-text-dark">Review Pekerjaan</h3>
        </x-slot>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Review dari Mahasiswa (Anda) -->
            <div class="bg-surface p-4 rounded-md border border-border-color">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-sm font-semibold text-text-dark">Review Anda</p>
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
                    <p class="text-sm text-text-gray italic">Anda belum memberikan review.</p>
                    <button onclick="openModal('modal-review')" class="mt-2 text-sm text-primary font-medium hover:underline"><i class="fa-solid fa-star mr-1"></i>Beri Review Sekarang</button>
                @endif
            </div>

            <!-- Review dari Penyedia -->
            <div class="bg-surface p-4 rounded-md border border-border-color">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-sm font-semibold text-text-dark">Review dari Penyedia</p>
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
                    <p class="text-sm text-text-gray italic">Penyedia belum memberikan review.</p>
                @endif
            </div>
        </div>
    </x-card>
    @endif

</div>

<!-- Modal Review -->
<x-modal id="modal-review" title="Beri Review Kepada Penyedia">
    <form action="{{ route('mahasiswa.applications.review', $application->id) }}" method="POST">
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
                <x-textarea name="comment" placeholder="Ceritakan bagaimana pengalaman Anda bekerja di tempat ini..." rows="3"></x-textarea>
            </div>
        </div>
        <div class="mt-6 flex justify-end gap-2">
            <button type="button" class="inline-flex justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-text-dark shadow-sm ring-1 ring-inset ring-border-color hover:bg-surface" onclick="closeModal('modal-review')">Batal</button>
            <x-button type="submit">Kirim Review</x-button>
        </div>
    </form>
</x-modal>

@push('scripts')
<script>
    function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
    function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

    // Rating Stars Logic
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('#rating-stars i');
        const ratingInput = document.getElementById('rating-input');
        
        if (stars.length && ratingInput) {
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = this.getAttribute('data-rating');
                    ratingInput.value = rating;
                    
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
        }
    });
</script>
@endpush
@endsection
