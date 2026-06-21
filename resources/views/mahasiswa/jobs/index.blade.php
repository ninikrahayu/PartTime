@extends('layouts.mahasiswa')
@section('title', 'Cari Lowongan - Mahasiswa Partimeku')
@section('page_title', 'Lowongan Tersedia')

@section('content')
<div class="flex flex-col h-full max-w-7xl mx-auto space-y-4 md:space-y-6">

    <form method="GET" action="{{ route('mahasiswa.lowongan.index') }}" id="search-form">
    <!-- Search Bar & Mobile Filter Trigger -->
    <div class="flex items-center gap-2">
        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Cari posisi part time..." class="w-full bg-white shadow-sm border border-border-color rounded-md px-4 py-2" />
        <button type="button" onclick="document.getElementById('mobile-filter-drawer').classList.remove('translate-y-full')" class="md:hidden w-10 h-10 flex-shrink-0 rounded-md bg-white border border-border-color shadow-sm flex items-center justify-center text-text-dark hover:text-primary transition-colors">
            <i class="fa-solid fa-sliders"></i>
        </button>
    </div>

    <div class="flex flex-col md:flex-row gap-6">
        
        <!-- Desktop Sidebar Filters -->
        <div class="hidden md:block w-64 flex-shrink-0">
            <div class="bg-white border border-border-color rounded-md p-5 sticky top-24 shadow-sm">
                <div class="flex items-center justify-between mb-4 pb-4 border-b border-border-color">
                    <h3 class="font-bold text-lg text-text-dark">Filter</h3>
                    <button class="text-sm text-primary hover:underline">Reset</button>
                </div>

                <div class="mb-6">
                    <h4 class="font-semibold text-text-dark mb-3 text-sm">Kategori</h4>
                    <div class="space-y-2 max-h-48 overflow-y-auto custom-scrollbar">
                        @foreach($categories as $category)
                            <label class="flex items-center">
                                <input type="radio" name="category" value="{{ $category['name'] }}" {{ request('category') == $category['name'] ? 'checked' : '' }} class="text-primary focus:ring-primary h-4 w-4 rounded" />
                                <span class="ml-2 text-sm text-text-gray">{{ $category['name'] }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="font-semibold text-text-dark mb-3 text-sm">Gaji Minimal</h4>
                    <div class="space-y-2">
                        <input type="number" name="gaji_min" value="{{ request('gaji_min') }}" class="w-full rounded-md border border-border-color px-3 py-1.5 text-sm" placeholder="Contoh: 1000000">
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="font-semibold text-text-dark mb-3 text-sm">Jadwal / Shift</h4>
                    <div class="space-y-2 text-sm text-text-gray">
                        <x-select name="shift" class="w-full text-sm">
                            <option value="">Semua Shift</option>
                            <option value="Pagi" {{ request('shift') == 'Pagi' ? 'selected' : '' }}>Pagi</option>
                            <option value="Siang" {{ request('shift') == 'Siang' ? 'selected' : '' }}>Siang</option>
                            <option value="Sore" {{ request('shift') == 'Sore' ? 'selected' : '' }}>Sore</option>
                            <option value="Malam" {{ request('shift') == 'Malam' ? 'selected' : '' }}>Malam</option>
                            <option value="Fleksibel" {{ request('shift') == 'Fleksibel' ? 'selected' : '' }}>Fleksibel</option>
                        </x-select>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-border-color">
                    <x-button type="submit" class="w-full">Terapkan Filter</x-button>
                </div>
            </div>
        </div>
    </form>

        <!-- Main Content -->
        <div class="flex-1">
            <div class="hidden md:flex justify-between items-center mb-4">
                <p class="text-sm text-text-gray">Menampilkan <strong>{{ $jobs->count() }}</strong> lowongan part time aktif.</p>
                <div class="flex items-center gap-2">
                    <span class="text-sm text-text-gray">Urutkan:</span>
                    <x-select class="text-sm py-1.5 h-auto">
                        <option>Terbaru</option>
                        <option>Gaji Tertinggi</option>
                    </x-select>
                </div>
            </div>

            <!-- Job List Mobile/Desktop Grid -->
            @if($jobs->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($jobs as $job)
                        <x-card class="hover:shadow-md transition-shadow group flex flex-col h-full cursor-pointer relative border-border-color shadow-sm" onclick="window.location.href='{{ url('/mahasiswa/lowongan/'.$job->id) }}'">
                            
                            <!-- Heart Button (Favorit) -->
                            <form method="POST" action="{{ route('mahasiswa.lowongan.favorite', $job->id) }}" class="absolute top-3 right-3 z-20">
                                @csrf
                                @php
                                    $isFav = \App\Models\Favorite::where('user_id', Auth::id())->where('lowongan_id', $job->id)->exists();
                                @endphp
                                <button type="submit" class="w-8 h-8 rounded-full bg-surface border border-border-color flex items-center justify-center {{ $isFav ? 'text-danger border-danger' : 'text-text-gray hover:text-danger hover:border-danger' }} transition-colors" onclick="event.stopPropagation();">
                                    <i class="{{ $isFav ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                                </button>
                            </form>

                            <div class="flex items-start gap-3 mb-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($job->penyedia->name ?? 'P') }}&background=F9FAFB" alt="{{ $job->penyedia->name ?? '' }}" class="w-12 h-12 rounded-md object-cover border border-border-color">
                                <div class="flex-1 pr-8">
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
                            
                            <div class="flex items-center justify-between mt-auto pt-3 border-t border-border-color">
                                <x-badge color="info">{{ !empty($job->category) ? $job->category : 'Umum' }}</x-badge>
                                <span class="text-[10px] text-text-gray">{{ $job->created_at->diffForHumans() }}</span>
                            </div>
                        </x-card>
                    @endforeach
                </div>
                
                <div class="mt-6 pb-6">
                    <div class="p-4 border-t border-border-color">
                        {{ $jobs->links() }}
                    </div>
                </div>
            @else
                <x-empty-state icon="fa-search" title="Pekerjaan Tidak Ditemukan" description="Cobalah mengubah filter pencarian." />
            @endif
        </div>
    </div>
</div>

<!-- Mobile Filter Drawer -->
<div id="mobile-filter-drawer" class="fixed inset-x-0 bottom-0 z-[100] transform translate-y-full transition-transform duration-300 md:hidden flex flex-col bg-white rounded-t-2xl shadow-[0_-10px_40px_rgba(0,0,0,0.1)] h-[85vh]">
    <div class="p-4 border-b border-border-color flex justify-between items-center sticky top-0 bg-white rounded-t-2xl z-10">
        <h3 class="font-bold text-lg text-text-dark">Filter Lowongan</h3>
        <button onclick="document.getElementById('mobile-filter-drawer').classList.add('translate-y-full')" class="w-8 h-8 rounded-full bg-surface text-text-dark flex items-center justify-center">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    
    <div class="flex-1 overflow-y-auto p-4 space-y-6">
        <div>
            <h4 class="font-semibold text-text-dark mb-3 text-sm">Kategori</h4>
            <div class="space-y-3">
                @foreach($categories as $category)
                    <label class="flex items-center">
                        <x-checkbox name="mob_category[]" value="{{ $category['id'] }}" class="w-5 h-5" />
                        <span class="ml-3 text-sm text-text-dark">{{ $category['name'] }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div>
            <h4 class="font-semibold text-text-dark mb-3 text-sm">Lokasi</h4>
            <div class="space-y-3">
                <label class="flex items-center"><x-checkbox class="w-5 h-5" /> <span class="ml-3 text-sm text-text-dark">Surabaya Timur</span></label>
                <label class="flex items-center"><x-checkbox class="w-5 h-5" /> <span class="ml-3 text-sm text-text-dark">Surabaya Barat</span></label>
            </div>
        </div>
    </div>
    
    <div class="p-4 border-t border-border-color bg-white pb-safe pt-safe-bottom">
        <div class="flex gap-3">
            <x-button class="flex-1 bg-surface !text-text-dark border border-border-color hover:bg-gray-100" onclick="document.getElementById('mobile-filter-drawer').classList.add('translate-y-full')">Reset</x-button>
            <x-button class="flex-[2]" onclick="document.getElementById('mobile-filter-drawer').classList.add('translate-y-full'); showToast('Filter diterapkan', 'success')">Terapkan</x-button>
        </div>
    </div>
</div>

<!-- Toast Container (Adjusted for bottom nav on mobile) -->
<div id="toast-container" class="fixed bottom-20 md:bottom-4 right-4 z-[200] flex flex-col gap-2"></div>
<template id="toast-template">
    <div class="toast-item flex items-center w-full max-w-xs p-4 text-text-dark bg-white rounded-md shadow-lg border border-border-color transition-all duration-300 transform translate-x-full opacity-0">
        <div class="toast-icon inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg"></div>
        <div class="toast-message ml-3 text-sm font-medium"></div>
        <button type="button" class="toast-close ml-auto -mx-1.5 -my-1.5 bg-white text-text-gray hover:text-text-dark rounded-md p-1.5 inline-flex items-center justify-center h-8 w-8"><i class="fa-solid fa-xmark"></i></button>
    </div>
</template>
@endsection
