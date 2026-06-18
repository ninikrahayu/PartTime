@extends('layouts.public')

@section('title', 'Cari Lowongan Part Time - Partimeku')

@section('content')
<div class="bg-surface border-b border-border-color py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-text-dark mb-2">Cari Lowongan Part Time</h1>
        <p class="text-text-gray">Temukan pekerjaan yang cocok dengan jadwal kuliahmu.</p>
    </div>
</div>

<form method="GET" action="{{ url('/lowongan') }}" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Sidebar Filters -->
        <div class="w-full lg:w-1/4 flex-shrink-0">
            <div class="bg-white border border-border-color rounded-md p-5 sticky top-24">
                <div class="flex items-center justify-between mb-4 pb-4 border-b border-border-color">
                    <h3 class="font-bold text-lg text-text-dark">Filter</h3>
                    @if(request()->anyFilled(['category', 'location', 'schedule', 'min_salary', 'search', 'sort']))
                        <a href="{{ url('/lowongan') }}" class="text-sm text-primary hover:underline">Reset</a>
                    @endif
                </div>

                <!-- Kategori -->
                <div class="mb-6">
                    <h4 class="font-semibold text-text-dark mb-3 text-sm">Kategori Pekerjaan</h4>
                    <div class="space-y-2 max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($categories as $category)
                            <label class="flex items-center">
                                <x-checkbox name="category[]" value="{{ $category->name }}" {{ in_array($category->name, request('category', [])) ? 'checked' : '' }} />
                                <span class="ml-2 text-sm text-text-gray">{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Lokasi -->
                <div class="mb-6">
                    <h4 class="font-semibold text-text-dark mb-3 text-sm">Lokasi</h4>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <x-checkbox name="location[]" value="Surabaya Timur" {{ in_array('Surabaya Timur', request('location', [])) ? 'checked' : '' }} />
                            <span class="ml-2 text-sm text-text-gray">Surabaya Timur</span>
                        </label>
                        <label class="flex items-center">
                            <x-checkbox name="location[]" value="Surabaya Barat" {{ in_array('Surabaya Barat', request('location', [])) ? 'checked' : '' }} />
                            <span class="ml-2 text-sm text-text-gray">Surabaya Barat</span>
                        </label>
                        <label class="flex items-center">
                            <x-checkbox name="location[]" value="Surabaya Pusat" {{ in_array('Surabaya Pusat', request('location', [])) ? 'checked' : '' }} />
                            <span class="ml-2 text-sm text-text-gray">Surabaya Pusat</span>
                        </label>
                    </div>
                </div>

                <!-- Jadwal -->
                <div class="mb-6">
                    <h4 class="font-semibold text-text-dark mb-3 text-sm">Jadwal</h4>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <x-checkbox name="schedule[]" value="Weekend" {{ in_array('Weekend', request('schedule', [])) ? 'checked' : '' }} />
                            <span class="ml-2 text-sm text-text-gray">Akhir Pekan (Weekend)</span>
                        </label>
                        <label class="flex items-center">
                            <x-checkbox name="schedule[]" value="Shift Malam" {{ in_array('Shift Malam', request('schedule', [])) ? 'checked' : '' }} />
                            <span class="ml-2 text-sm text-text-gray">Shift Malam</span>
                        </label>
                        <label class="flex items-center">
                            <x-checkbox name="schedule[]" value="Fleksibel" {{ in_array('Fleksibel', request('schedule', [])) ? 'checked' : '' }} />
                            <span class="ml-2 text-sm text-text-gray">Fleksibel</span>
                        </label>
                    </div>
                </div>

                <!-- Gaji -->
                <div>
                    <h4 class="font-semibold text-text-dark mb-3 text-sm">Gaji Minimal (Rp)</h4>
                    <x-input name="min_salary" type="number" placeholder="Contoh: 50000" value="{{ request('min_salary') }}" />
                </div>
                
                <div class="mt-6 pt-6 border-t border-border-color">
                    <x-button type="submit" class="w-full">Terapkan Filter</x-button>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Search & Sort -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                <div class="w-full sm:w-96 flex gap-2">
                    <x-search-input name="search" value="{{ request('search') }}" placeholder="Cari posisi atau nama tempat kerja..." />
                    <x-button type="submit" class="hidden sm:inline-flex px-3 shrink-0"><i class="fa-solid fa-search"></i></x-button>
                </div>
                <div class="w-full sm:w-auto flex items-center gap-2">
                    <span class="text-sm text-text-gray whitespace-nowrap">Urutkan:</span>
                    <x-select name="sort" class="w-full sm:w-48 text-sm" onchange="this.form.submit()">
                        <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="gaji_tertinggi" {{ request('sort') == 'gaji_tertinggi' ? 'selected' : '' }}>Gaji Tertinggi</option>
                    </x-select>
                </div>
            </div>
            
            <div class="mb-4 text-sm text-text-gray">
                Menampilkan {{ $jobs->firstItem() ?? 0 }} - {{ $jobs->lastItem() ?? 0 }} dari {{ $jobs->total() }} pekerjaan
            </div>

            <!-- Job List -->
            @if(count($jobs) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 mb-8">
                    @foreach($jobs as $job)
                        <x-card class="hover:shadow-md transition-shadow group flex flex-col h-full cursor-pointer" onclick="window.location.href='{{ url('/lowongan/'.$job->id) }}'">
                            <div class="flex items-start gap-4 mb-4">
                                <img src="{{ ($job->penyedia && $job->penyedia->profile && $job->penyedia->profile->logo_path) ? Storage::url($job->penyedia->profile->logo_path) : asset('images/dummy/default-logo.png') }}" alt="{{ $job->penyedia->name ?? 'Penyedia' }}" class="w-12 h-12 rounded-md object-cover border border-border-color" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($job->penyedia->name ?? 'Penyedia') }}&background=F9FAFB'">
                                <div class="flex-1">
                                    <h3 class="font-bold text-lg text-text-dark group-hover:text-primary transition-colors line-clamp-1"><a href="{{ url('/lowongan/'.$job->id) }}">{{ $job->judul }}</a></h3>
                                    <p class="text-sm text-text-gray">{{ $job->penyedia->name ?? '-' }}</p>
                                </div>
                            </div>
                            
                            <div class="space-y-2 mb-6 flex-grow">
                                <div class="flex items-center gap-2 text-sm text-text-gray">
                                    <i class="fa-solid fa-location-dot w-5 text-center text-primary/70"></i> <span>{{ $job->lokasi }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-text-gray">
                                    <i class="fa-solid fa-clock w-5 text-center text-primary/70"></i> <span>{{ $job->shift }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-text-gray">
                                    <i class="fa-solid fa-money-bill-wave w-5 text-center text-primary/70"></i> <span>Rp {{ number_format($job->gaji, 0, ',', '.') }} / {{ str_replace('Per ', '', $job->salary_type) }}</span>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between mt-auto pt-4 border-t border-border-color">
                                <x-badge color="info">{{ $job->category }}</x-badge>
                                <span class="text-xs text-text-gray">{{ $job->created_at->diffForHumans() }}</span>
                            </div>
                        </x-card>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="p-4 mt-8 border-t border-border-color">
                    {{ $jobs->appends(request()->query())->links() }}
                </div>
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
</form>
@endsection
