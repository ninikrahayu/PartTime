@extends('layouts.public')

@section('title', $job->judul . ' di ' . ($job->penyedia->name ?? 'Penyedia'))

@php
    // Fetch provider reviews explicitly within the view
    $reviews = \App\Models\Review::with('reviewer')->where('reviewee_id', $job->penyedia_id)->get();
    $avgRating = $reviews->count() > 0 ? $reviews->avg('rating') : 0;
    
    $providerName = $job->penyedia->name ?? 'Penyedia';
    $providerLogo = ($job->penyedia && $job->penyedia->profile && !empty($job->penyedia->profile->logo_path)) 
        ? Storage::url($job->penyedia->profile->logo_path) 
        : asset('images/dummy/default-logo.png');
@endphp

@section('content')
<!-- Header Detail -->
<div class="bg-white border-b border-border-color">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        <div class="flex flex-col md:flex-row md:items-center gap-6">
            <!-- Provider Logo -->
            <img src="{{ $providerLogo }}" alt="{{ $providerName }}" class="w-20 h-20 md:w-24 md:h-24 rounded-md object-cover border border-border-color shadow-sm" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($providerName) }}&background=F9FAFB'">
            
            <div class="flex-1">
                <div class="flex flex-wrap gap-2 mb-3">
                    <x-badge color="info">{{ $job->category }}</x-badge>
                    <x-status-badge :status="$job->status" />
                </div>
                <h1 class="text-2xl md:text-3xl font-bold text-text-dark mb-2">{{ $job->judul }}</h1>
                <p class="text-lg text-text-gray font-medium flex items-center gap-2">
                    {{ $providerName }}
                    @if($avgRating > 0)
                        <span class="text-sm bg-secondary/20 text-text-dark px-2 py-0.5 rounded-full flex items-center gap-1">
                            <i class="fa-solid fa-star text-secondary text-xs"></i> {{ number_format($avgRating, 1) }} ({{ $reviews->count() }} Review)
                        </span>
                    @endif
                </p>
            </div>
            
            <div class="mt-4 md:mt-0 flex gap-3">
                <button class="bg-surface border border-border-color text-text-dark hover:bg-gray-100 px-4 py-2 rounded-md font-medium transition-colors w-12 h-10 flex items-center justify-center" title="Simpan Lowongan">
                    <i class="fa-regular fa-heart text-xl"></i>
                </button>
                <a href="{{ url('/login') }}" class="bg-primary text-white hover:bg-blue-900 px-6 py-2 rounded-md font-medium transition-colors shadow-sm flex items-center gap-2 h-10">
                    Lamar Sekarang <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Main Content (Left) -->
        <div class="w-full lg:w-2/3 space-y-8">
            
            <!-- Deskripsi -->
            <section class="bg-white p-6 md:p-8 rounded-md border border-border-color">
                <h2 class="text-xl font-bold text-text-dark mb-4">Deskripsi Pekerjaan</h2>
                <div class="prose prose-sm max-w-none text-text-gray">
                    {!! nl2br(e($job->deskripsi)) !!}
                </div>
            </section>

            <!-- Syarat -->
            <section class="bg-white p-6 md:p-8 rounded-md border border-border-color">
                <h2 class="text-xl font-bold text-text-dark mb-4">Persyaratan</h2>
                <ul class="space-y-3">
                    @php
                        $requirements = is_string($job->kriteria) ? explode("\n", $job->kriteria) : ($job->kriteria ?? []);
                    @endphp
                    @foreach($requirements as $req)
                        @if(trim($req))
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-check text-success mt-1"></i>
                            <span class="text-text-gray">{{ trim($req) }}</span>
                        </li>
                        @endif
                    @endforeach
                </ul>
            </section>

            <!-- Reviews -->
            <section class="bg-white p-6 md:p-8 rounded-md border border-border-color">
                <h2 class="text-xl font-bold text-text-dark mb-6">Review Tempat Kerja ({{ $reviews->count() }})</h2>
                
                @if($reviews->count() > 0)
                    <div class="space-y-6">
                        @foreach($reviews as $review)
                            <div class="border-b border-border-color pb-6 last:border-0 last:pb-0">
                                <div class="flex items-start justify-between mb-2">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold">
                                            {{ strtoupper(substr($review->reviewer->name ?? 'M', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-text-dark text-sm">{{ $review->reviewer->name ?? 'Pengguna' }}</p>
                                            <p class="text-xs text-text-gray">{{ \Carbon\Carbon::parse($review->created_at)->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex text-secondary text-sm">
                                        @for($i=1; $i<=5; $i++)
                                            <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star"></i>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-sm text-text-gray mt-3">{{ $review->comment }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6 text-text-gray">
                        Belum ada review untuk tempat kerja ini.
                    </div>
                @endif
            </section>

        </div>

        <!-- Sidebar Info (Right) -->
        <div class="w-full lg:w-1/3 flex-shrink-0">
            <div class="sticky top-24 space-y-6">
                
                <!-- Ringkasan Job -->
                <div class="bg-white rounded-md border border-border-color p-5">
                    <h3 class="font-bold text-lg text-text-dark mb-4 pb-3 border-b border-border-color">Ringkasan</h3>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-md bg-primary/10 text-primary flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-money-bill-wave"></i>
                            </div>
                            <div>
                                <p class="text-xs text-text-gray mb-1">Gaji yang Ditawarkan</p>
                                <p class="font-semibold text-text-dark">Rp {{ number_format($job->gaji, 0, ',', '.') }} <span class="font-normal text-sm text-text-gray">/ {{ str_replace('Per ', '', $job->salary_type) }}</span></p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-md bg-primary/10 text-primary flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-calendar-days"></i>
                            </div>
                            <div>
                                <p class="text-xs text-text-gray mb-1">Jadwal Kerja</p>
                                <p class="font-semibold text-text-dark">{{ $job->shift }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-md bg-primary/10 text-primary flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <p class="text-xs text-text-gray mb-1">Lokasi</p>
                                <p class="font-semibold text-text-dark">{{ $job->lokasi }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-md bg-primary/10 text-primary flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                            </div>
                            <div>
                                <p class="text-xs text-text-gray mb-1">Dipublikasikan</p>
                                <p class="font-semibold text-text-dark">{{ \Carbon\Carbon::parse($job->created_at)->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Provider Info -->
                <div class="bg-surface rounded-md border border-border-color p-5 text-center">
                    <img src="{{ $providerLogo }}" alt="{{ $providerName }}" class="w-16 h-16 mx-auto rounded-full object-cover border border-border-color shadow-sm mb-3" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($providerName) }}&background=1E3A8A&color=fff'">
                    <h3 class="font-bold text-text-dark">{{ $providerName }}</h3>
                    <p class="text-xs text-text-gray mt-1">Penyedia Part Time Terverifikasi <i class="fa-solid fa-circle-check text-success ml-1"></i></p>
                    <div class="mt-4 pt-4 border-t border-border-color">
                        <a href="#" class="text-primary hover:underline text-sm font-medium">Lihat Profil Lengkap</a>
                    </div>
                </div>

                <!-- Bagikan -->
                <div class="bg-white rounded-md border border-border-color p-5">
                    <h3 class="font-semibold text-text-dark text-sm mb-3">Bagikan Lowongan Ini</h3>
                    <div class="flex gap-2">
                        <x-button class="flex-1 bg-green-600 hover:bg-green-700 text-white"><i class="fa-brands fa-whatsapp"></i></x-button>
                        <x-button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white"><i class="fa-brands fa-facebook-f"></i></x-button>
                        <x-button class="flex-1 bg-blue-400 hover:bg-blue-500 text-white"><i class="fa-brands fa-twitter"></i></x-button>
                        <x-button class="flex-1 bg-gray-200 hover:bg-gray-300 !text-text-dark"><i class="fa-solid fa-link"></i></x-button>
                    </div>
                </div>
                
            </div>
        </div>

    </div>

    <!-- Similar Jobs -->
    @if(count($similarJobs) > 0)
    <div class="mt-16 pt-8 border-t border-border-color">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-text-dark">Lowongan Serupa</h2>
            <a href="{{ url('/lowongan?category[]='.urlencode($job->category)) }}" class="text-primary hover:underline text-sm font-medium">Lihat Kategori Ini</a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($similarJobs as $simJob)
                @php
                    $simProviderName = $simJob->penyedia->name ?? 'Penyedia';
                    $simProviderLogo = ($simJob->penyedia && $simJob->penyedia->profile && !empty($simJob->penyedia->profile->logo_path)) 
                        ? Storage::url($simJob->penyedia->profile->logo_path) 
                        : asset('images/dummy/default-logo.png');
                @endphp
                <x-card class="hover:shadow-md transition-shadow group flex flex-col h-full cursor-pointer" onclick="window.location.href='{{ url('/lowongan/'.$simJob->id) }}'">
                    <div class="flex items-start gap-3 mb-3">
                        <img src="{{ $simProviderLogo }}" alt="{{ $simProviderName }}" class="w-10 h-10 rounded-md object-cover border border-border-color" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($simProviderName) }}&background=F9FAFB'">
                        <div class="flex-1">
                            <h3 class="font-bold text-text-dark group-hover:text-primary transition-colors line-clamp-1"><a href="{{ url('/lowongan/'.$simJob->id) }}">{{ $simJob->judul }}</a></h3>
                            <p class="text-xs text-text-gray">{{ $simProviderName }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-1.5 mb-4 flex-grow">
                        <div class="flex items-center text-xs text-text-gray">
                            <i class="fa-solid fa-location-dot w-4 text-center text-primary/70"></i> {{ $simJob->lokasi }}
                        </div>
                        <div class="flex items-center text-xs text-text-gray">
                            <i class="fa-solid fa-money-bill-wave w-4 text-center text-primary/70"></i> Rp {{ number_format($simJob->gaji, 0, ',', '.') }}
                        </div>
                    </div>
                </x-card>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
