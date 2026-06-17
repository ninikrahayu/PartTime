@extends('layouts.mahasiswa')
@section('title', 'Dashboard Mahasiswa - Partimeku')
@section('page_title', 'Dashboard')

@section('content')
<div class="space-y-6">

    <!-- Header / Greeting -->
    <div class="bg-primary text-white rounded-md p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 relative overflow-hidden">
        <div class="relative z-10">
            <h2 class="text-2xl text-white font-bold mb-1">Halo, {{ explode(' ', $user->name)[0] }}!</h2>
            <p class="text-blue-100 text-sm">Siap untuk mencari pengalaman kerja baru hari ini?</p>
        </div>
        <div class="relative z-10 flex items-center bg-white/10 rounded-md px-4 py-3 backdrop-blur-sm">
            <div class="text-center mr-4 border-r border-white/20 pr-4">
                <p class="text-xs text-blue-200 uppercase tracking-wider mb-1">Rating Kamu</p>
                <div class="flex items-center justify-center gap-1 text-lg font-bold">
                    <i class="fa-solid fa-star text-secondary"></i> {{ $stats['rating'] }}
                </div>
            </div>
            <div class="text-center">
                <p class="text-xs text-blue-200 uppercase tracking-wider mb-1">Total Review</p>
                <p class="text-lg font-bold">12</p>
            </div>
        </div>
        <!-- Decorative bg -->
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white opacity-5 rounded-full blur-2xl"></div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <x-card class="p-4 flex flex-col justify-center border-border-color shadow-sm">
            <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center text-lg mb-3">
                <i class="fa-solid fa-briefcase"></i>
            </div>
            <p class="text-2xl font-bold text-text-dark">97+</p>
            <p class="text-xs font-medium text-text-gray mt-1">Lowongan Tersedia</p>
        </x-card>
        
        <x-card class="p-4 flex flex-col justify-center border-border-color shadow-sm">
            <div class="w-10 h-10 rounded-full bg-info/10 text-info flex items-center justify-center text-lg mb-3">
                <i class="fa-solid fa-paper-plane"></i>
            </div>
            <p class="text-2xl font-bold text-text-dark">{{ $stats['lamaran_dikirim'] }}</p>
            <p class="text-xs font-medium text-text-gray mt-1">Total Lamaran</p>
        </x-card>

        <x-card class="p-4 flex flex-col justify-center border-border-color shadow-sm">
            <div class="w-10 h-10 rounded-full bg-warning/10 text-warning flex items-center justify-center text-lg mb-3">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
            <p class="text-2xl font-bold text-text-dark">{{ $stats['lamaran_diproses'] }}</p>
            <p class="text-xs font-medium text-text-gray mt-1">Lamaran Diproses</p>
        </x-card>

        <x-card class="p-4 flex flex-col justify-center border-border-color shadow-sm">
            <div class="w-10 h-10 rounded-full bg-success/10 text-success flex items-center justify-center text-lg mb-3">
                <i class="fa-solid fa-check-double"></i>
            </div>
            <p class="text-2xl font-bold text-text-dark">{{ $stats['lamaran_diterima'] }}</p>
            <p class="text-xs font-medium text-text-gray mt-1">Lamaran Diterima</p>
        </x-card>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Column: Status Lamaran & Review -->
        <div class="lg:col-span-1 space-y-6">
            
            <!-- Status Lamaran Terakhir -->
            <x-card class="shadow-sm border-border-color p-0 flex flex-col">
                <x-slot name="header">
                    <h3 class="font-bold text-text-dark text-sm uppercase tracking-wider">Status Lamaran Terakhir</h3>
                </x-slot>
                <div class="p-5">
                    @if($last_application)
                        <div class="flex items-center gap-4 mb-4 pb-4 border-b border-border-color">
                            <div class="w-12 h-12 rounded-md bg-surface border border-border-color flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-store text-text-gray text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-text-dark text-sm line-clamp-1">{{ $last_application->lowongan->judul ?? '-' }}</h4>
                                <p class="text-xs text-text-gray mt-0.5">{{ $last_application->lowongan->penyedia->name ?? '-' }}</p>
                            </div>
                        </div>
                        
                        <div class="relative border-l-2 border-border-color ml-2 space-y-4">
                            <div class="relative pl-5">
                                <div class="absolute w-3 h-3 bg-primary rounded-full -left-[7px] top-1.5 ring-4 ring-white"></div>
                                <p class="text-sm font-semibold text-text-dark">Terkirim</p>
                                <p class="text-xs text-text-gray">{{ $last_application->created_at->format('d M, H:i') }}</p>
                            </div>
                            @if(in_array($last_application->status, ['diproses', 'diterima', 'ditolak']))
                            <div class="relative pl-5">
                                <div class="absolute w-3 h-3 bg-info rounded-full -left-[7px] top-1.5 ring-4 ring-white"></div>
                                <p class="text-sm font-semibold text-text-dark">Diproses Penyedia</p>
                                <p class="text-xs text-text-gray">Sedang di-review</p>
                            </div>
                            @endif
                        </div>
                        
                        <div class="mt-6 pt-4 border-t border-border-color text-center">
                            <a href="{{ url('/mahasiswa/applications/'.$last_application->id) }}" class="text-sm text-primary font-medium hover:underline">Lihat Detail Lamaran</a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-sm text-text-gray">Belum ada lamaran.</p>
                        </div>
                    @endif
                </div>
            </x-card>

            <!-- Review Terbaru -->
            <x-card class="shadow-sm border-border-color p-0">
                <x-slot name="header">
                    <h3 class="font-bold text-text-dark text-sm uppercase tracking-wider">Review Terbaru</h3>
                </x-slot>
                <div class="p-0">
                    @forelse($recent_reviews as $review)
                        <div class="p-4 border-b border-border-color last:border-0 hover:bg-surface transition-colors">
                            <div class="flex justify-between items-start mb-2">
                                <p class="text-xs font-semibold text-text-dark">Dari: Penyedia (Dummy)</p>
                                <div class="text-secondary text-xs">
                                    @for($i=1; $i<=5; $i++)
                                        <i class="fa-{{ $i <= $review['rating'] ? 'solid' : 'regular' }} fa-star"></i>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-sm text-text-gray italic line-clamp-2">"{{ $review['comment'] }}"</p>
                        </div>
                    @empty
                        <div class="p-6 text-center">
                            <p class="text-sm text-text-gray">Belum ada review diterima.</p>
                        </div>
                    @endforelse
                </div>
            </x-card>

        </div>

        <!-- Right Column: Lowongan Terbaru -->
        <div class="lg:col-span-2">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-lg text-text-dark">Rekomendasi Lowongan</h3>
                <a href="{{ url('/mahasiswa/jobs') }}" class="text-sm text-primary font-medium hover:underline">Lihat Semua</a>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($recent_jobs as $job)
                <x-card class="hover:shadow-md transition-shadow group flex flex-col  cursor-pointer relative" onclick="window.location.href='{{ url('/mahasiswa/jobs/'.$job->id) }}'">
                    <!-- Favorit Button Overlay -->
                    <button class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/80 backdrop-blur border border-border-color flex items-center justify-center text-text-gray hover:text-danger hover:border-danger transition-colors z-10" onclick="event.stopPropagation(); this.classList.toggle('text-danger'); this.classList.toggle('text-text-gray'); this.querySelector('i').classList.toggle('fa-solid'); this.querySelector('i').classList.toggle('fa-regular'); showToast('Favorit diperbarui', 'success');">
                        <i class="fa-regular fa-heart"></i>
                    </button>

                    <div class="flex items-start gap-3 mb-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($job->penyedia->name ?? 'P') }}&background=F9FAFB" alt="{{ $job->penyedia->name ?? '' }}" class="w-12 h-12 rounded-md object-cover border border-border-color">
                        <div class="flex-1 pr-6">
                            <h3 class="font-bold text-text-dark group-hover:text-primary transition-colors line-clamp-1 text-base">{{ $job->judul }}</h3>
                            <p class="text-xs text-text-gray">{{ $job->penyedia->name ?? '-' }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-1.5 mb-4 flex-grow">
                        <div class="flex items-center text-xs text-text-gray">
                            <i class="fa-solid fa-location-dot w-4 text-center text-primary/70"></i> {{ $job->lokasi }}
                        </div>
                        <div class="flex items-center text-xs text-text-gray">
                            <i class="fa-solid fa-clock w-4 text-center text-primary/70"></i> {{ $job->shift }}
                        </div>
                        <div class="flex items-center text-xs text-text-gray font-medium text-text-dark mt-2">
                            <i class="fa-solid fa-money-bill-wave w-4 text-center text-primary/70"></i> Rp {{ number_format($job->gaji ?? 0, 0, ',', '.') }}
                        </div>
                    </div>
                </x-card>
                @endforeach
            </div>
        </div>
        
    </div>

</div>

<!-- Toast Container -->
<div id="toast-container" class="fixed bottom-20 md:bottom-4 right-4 z-[200] flex flex-col gap-2"></div>
<template id="toast-template">
    <div class="toast-item flex items-center w-full max-w-xs p-4 text-text-dark bg-white rounded-md shadow-lg border border-border-color transition-all duration-300 transform translate-x-full opacity-0">
        <div class="toast-icon inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg"></div>
        <div class="toast-message ml-3 text-sm font-medium"></div>
        <button type="button" class="toast-close ml-auto -mx-1.5 -my-1.5 bg-white text-text-gray hover:text-text-dark rounded-md p-1.5 inline-flex items-center justify-center h-8 w-8"><i class="fa-solid fa-xmark"></i></button>
    </div>
</template>
@endsection
