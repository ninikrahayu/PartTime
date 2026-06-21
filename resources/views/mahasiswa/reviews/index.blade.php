@extends('layouts.mahasiswa')
@section('title', 'Review Saya - Mahasiswa Partimeku')
@section('page_title', 'Review Saya')

@section('content')
<div class="max-w-7xl mx-auto space-y-4 md:space-y-6">

    <div class="bg-primary text-white rounded-md p-6 flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden mb-6">
        <div class="relative z-10 flex items-center gap-6 w-full md:w-auto">
            <div class="w-20 h-20 rounded-full bg-white text-primary flex items-center justify-center text-3xl font-bold shadow-md shrink-0">
                {{ round(Auth::user()->receivedReviews()->avg('rating') ?? 0, 1) }}
            </div>
            <div>
                <h2 class="text-xl font-bold mb-1 text-white">Rating Rata-rata Anda</h2>
                <div class="flex text-secondary text-lg mb-1">
                    @php $avgRating = round(Auth::user()->receivedReviews()->avg('rating') ?? 0); @endphp
                    @for($i=1; $i<=5; $i++)
                        <i class="fa-{{ $i <= $avgRating ? 'solid' : 'regular' }} fa-star"></i>
                    @endfor
                </div>
                <p class="text-xs text-blue-100">Berdasarkan {{ Auth::user()->receivedReviews()->count() }} ulasan dari penyedia</p>
            </div>
        </div>
        
        <div class="relative z-10 grid grid-cols-2 gap-4 w-full md:w-auto text-center border-t md:border-t-0 md:border-l border-white/20 pt-4 md:pt-0 md:pl-6">
            <div>
                <p class="text-2xl font-bold">{{ Auth::user()->lamarans()->where('status', 'diterima')->count() }}</p>
                <p class="text-xs text-blue-200">Pekerjaan Diterima</p>
            </div>
            <div>
                <p class="text-2xl font-bold">{{ Auth::user()->lamarans()->where('status', 'diproses')->count() }}</p>
                <p class="text-xs text-blue-200">Sedang Diproses</p>
            </div>
        </div>
        <!-- Decorative bg -->
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white opacity-5 rounded-full blur-2xl"></div>
    </div>

    <h3 class="font-bold text-text-dark text-lg mb-4">Ulasan dari Penyedia</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($reviews as $review)
            <x-card class="shadow-sm border-border-color p-5 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-surface border border-border-color flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-store text-text-gray"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-text-dark text-sm">{{ $review->reviewer->name ?? 'Penyedia' }}</p>
                            <p class="text-[10px] text-text-gray">{{ $review->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="text-secondary text-xs flex gap-0.5">
                        @for($i=1; $i<=5; $i++)
                            <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star"></i>
                        @endfor
                    </div>
                </div>
                <p class="text-sm text-text-gray italic leading-relaxed">"{{ $review->comment }}"</p>
                <div class="mt-4 pt-3 border-t border-border-color flex items-center justify-between text-xs">
                    <span class="text-text-gray">Posisi: {{ $review->lamaran->lowongan->judul ?? '-' }}</span>
                    @if($review->lamaran && $review->lamaran->lowongan)
                        <a href="{{ url('/mahasiswa/lowongan/'.$review->lamaran->lowongan->id) }}" class="text-primary hover:underline font-medium">Lihat Lowongan</a>
                    @endif
                </div>
            </x-card>
        @empty
            <div class="col-span-full">
                <x-empty-state icon="fa-star" title="Belum Ada Ulasan" description="Anda belum menerima ulasan dari penyedia." />
            </div>
        @endforelse
    </div>
    
    <div class="mt-6">
        <div class="p-4 border-t border-border-color">
            {{ $reviews->links() }}
        </div>
    </div>

</div>
@endsection
