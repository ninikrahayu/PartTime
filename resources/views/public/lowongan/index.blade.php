@extends('layouts.public')

@section('title', 'Cari Lowongan Part Time - Partimeku')

@section('content')
<div class="bg-surface border-b border-border-color py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-text-dark mb-2">Cari Lowongan Part Time</h1>
        <p class="text-text-gray">Temukan pekerjaan yang cocok dengan jadwal kuliahmu.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Sidebar Filters -->
        <div class="w-full lg:w-1/4 flex-shrink-0">
            <div class="bg-white border border-border-color rounded-md p-5 sticky top-24">
                <div class="flex items-center justify-between mb-4 pb-4 border-b border-border-color">
                    <h3 class="font-bold text-lg text-text-dark">Filter</h3>
                    <button class="text-sm text-primary hover:underline">Reset</button>
                </div>

                <!-- Kategori -->
                <div class="mb-6">
                    <h4 class="font-semibold text-text-dark mb-3 text-sm">Kategori Pekerjaan</h4>
                    <div class="space-y-2 max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($categories as $category)
                            <label class="flex items-center">
                                <x-checkbox name="category[]" value="{{ $category['id'] }}" />
                                <span class="ml-2 text-sm text-text-gray">{{ $category['name'] }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Lokasi -->
                <div class="mb-6">
                    <h4 class="font-semibold text-text-dark mb-3 text-sm">Lokasi</h4>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <x-checkbox name="location[]" value="Surabaya Timur" />
                            <span class="ml-2 text-sm text-text-gray">Surabaya Timur</span>
                        </label>
                        <label class="flex items-center">
                            <x-checkbox name="location[]" value="Surabaya Barat" />
                            <span class="ml-2 text-sm text-text-gray">Surabaya Barat</span>
                        </label>
                        <label class="flex items-center">
                            <x-checkbox name="location[]" value="Surabaya Pusat" />
                            <span class="ml-2 text-sm text-text-gray">Surabaya Pusat</span>
                        </label>
                    </div>
                </div>

                <!-- Jadwal -->
                <div class="mb-6">
                    <h4 class="font-semibold text-text-dark mb-3 text-sm">Jadwal</h4>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <x-checkbox name="schedule[]" value="Weekend" />
                            <span class="ml-2 text-sm text-text-gray">Akhir Pekan (Weekend)</span>
                        </label>
                        <label class="flex items-center">
                            <x-checkbox name="schedule[]" value="Shift Malam" />
                            <span class="ml-2 text-sm text-text-gray">Shift Malam</span>
                        </label>
                        <label class="flex items-center">
                            <x-checkbox name="schedule[]" value="Fleksibel" />
                            <span class="ml-2 text-sm text-text-gray">Fleksibel</span>
                        </label>
                    </div>
                </div>

                <!-- Gaji -->
                <div>
                    <h4 class="font-semibold text-text-dark mb-3 text-sm">Gaji Minimal (Rp)</h4>
                    <x-input type="number" placeholder="Contoh: 50000" />
                </div>
                
                <div class="mt-6 pt-6 border-t border-border-color">
                    <x-button class="w-full">Terapkan Filter</x-button>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Search & Sort -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                <div class="w-full sm:w-96">
                    <x-search-input placeholder="Cari posisi atau nama tempat kerja..." />
                </div>
                <div class="w-full sm:w-auto flex items-center gap-2">
                    <span class="text-sm text-text-gray whitespace-nowrap">Urutkan:</span>
                    <x-select class="w-full sm:w-48 text-sm">
                        <option>Terbaru</option>
                        <option>Gaji Tertinggi</option>
                        <option>Terpopuler</option>
                    </x-select>
                </div>
            </div>

            <!-- Job List -->
            @if(count($jobs) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 mb-8">
                    @foreach($jobs as $job)
                        <x-card class="hover:shadow-md transition-shadow group flex flex-col h-full cursor-pointer" onclick="window.location.href='{{ url('/lowongan/'.$job['id']) }}'">
                            <div class="flex items-start gap-4 mb-4">
                                <img src="{{ asset($job['provider_logo'] ?? 'images/dummy/default-logo.png') }}" alt="{{ $job['provider_name'] }}" class="w-12 h-12 rounded-md object-cover border border-border-color" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($job['provider_name']) }}&background=F9FAFB'">
                                <div class="flex-1">
                                    <h3 class="font-bold text-lg text-text-dark group-hover:text-primary transition-colors line-clamp-1"><a href="{{ url('/lowongan/'.$job['id']) }}">{{ $job['title'] }}</a></h3>
                                    <p class="text-sm text-text-gray">{{ $job['provider_name'] }}</p>
                                </div>
                            </div>
                            
                            <div class="space-y-2 mb-6 flex-grow">
                                <div class="flex items-center gap-2 text-sm text-text-gray">
                                    <i class="fa-solid fa-location-dot w-5 text-center text-primary/70"></i> <span>{{ $job['location'] }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-text-gray">
                                    <i class="fa-solid fa-clock w-5 text-center text-primary/70"></i> <span>{{ $job['schedule'] }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-text-gray">
                                    <i class="fa-solid fa-money-bill-wave w-5 text-center text-primary/70"></i> <span>Rp {{ number_format($job['salary'], 0, ',', '.') }} / {{ str_replace('Per ', '', $job['salary_type']) }}</span>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between mt-auto pt-4 border-t border-border-color">
                                <x-badge color="info">{{ $job['category'] }}</x-badge>
                                <span class="text-xs text-text-gray">{{ \Carbon\Carbon::parse($job['created_at'])->diffForHumans() }}</span>
                            </div>
                        </x-card>
                    @endforeach
                </div>
                
                <!-- Pagination Dummy -->
                <x-pagination />
            @else
                <x-empty-state 
                    icon="fa-search" 
                    title="Pekerjaan Tidak Ditemukan" 
                    description="Cobalah menyesuaikan filter pencarian atau kata kunci."
                >
                    <x-slot name="action">
                        <x-button onclick="window.location.reload()">Reset Pencarian</x-button>
                    </x-slot>
                </x-empty-state>
            @endif

        </div>
    </div>
</div>
@endsection
