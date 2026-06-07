@extends('layouts.mahasiswa')
@section('title', 'Review Saya - Mahasiswa Partimeku')
@section('page_title', 'Review Saya')

@section('content')
<div class="max-w-7xl mx-auto space-y-4 md:space-y-6">

    <div class="bg-primary text-white rounded-md p-6 flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden mb-6">
        <div class="relative z-10 flex items-center gap-6 w-full md:w-auto">
            <div class="w-20 h-20 rounded-full bg-white text-primary flex items-center justify-center text-3xl font-bold shadow-md shrink-0">
                4.8
            </div>
            <div>
                <h2 class="text-xl font-bold mb-1 text-white">Rating Rata-rata Anda</h2>
                <div class="flex text-secondary text-lg mb-1">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                </div>
                <p class="text-xs text-blue-100">Berdasarkan 12 ulasan dari penyedia</p>
            </div>
        </div>
        
        <div class="relative z-10 grid grid-cols-2 gap-4 w-full md:w-auto text-center border-t md:border-t-0 md:border-l border-white/20 pt-4 md:pt-0 md:pl-6">
            <div>
                <p class="text-2xl font-bold">12</p>
                <p class="text-xs text-blue-200">Pekerjaan Selesai</p>
            </div>
            <div>
                <p class="text-2xl font-bold">100%</p>
                <p class="text-xs text-blue-200">Tepat Waktu</p>
            </div>
        </div>
        <!-- Decorative bg -->
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white opacity-5 rounded-full blur-2xl"></div>
    </div>

    <h3 class="font-bold text-text-dark text-lg mb-4">Ulasan dari Penyedia</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Dummy Reviews -->
        @for($i=1; $i<=6; $i++)
            <x-card class="shadow-sm border-border-color p-5 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-surface border border-border-color flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-store text-text-gray"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-text-dark text-sm">Penyedia Terverifikasi {{ $i }}</p>
                            <p class="text-[10px] text-text-gray">{{ \Carbon\Carbon::now()->subDays($i*3)->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="text-secondary text-xs flex gap-0.5">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                </div>
                <p class="text-sm text-text-gray italic leading-relaxed">"Mahasiswa ini kerjanya sangat bagus, rajin, dan selalu datang tepat waktu. Sangat direkomendasikan untuk part time di sini lagi."</p>
                <div class="mt-4 pt-3 border-t border-border-color flex items-center justify-between text-xs">
                    <span class="text-text-gray">Posisi: Barista Part Time</span>
                    <a href="#" class="text-primary hover:underline font-medium">Lihat Lowongan</a>
                </div>
            </x-card>
        @endfor
    </div>
    
    <div class="mt-6">
        <x-pagination />
    </div>

</div>
@endsection
