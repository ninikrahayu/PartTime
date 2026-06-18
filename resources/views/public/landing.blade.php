@extends('layouts.public')

@section('title', 'Partimeku - Temukan Kerja Part Time Pertamamu')

@section('content')
    <!-- Hero Section -->
    <section class="bg-surface py-16 md:py-24 border-b border-border-color relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="text-4xl md:text-6xl font-bold text-text-dark mb-6 leading-tight">
                    Temukan Pekerjaan <span class="text-primary">Part Time</span> yang Tepat Untukmu
                </h1>
                <p class="text-lg md:text-xl text-text-gray mb-10">
                    Platform terbaik yang menghubungkan mahasiswa dengan peluang kerja paruh waktu di berbagai UMKM dan instansi lokal.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ url('/lowongan') }}" class="inline-flex justify-center items-center px-6 py-3 bg-primary text-white rounded-md font-semibold hover:bg-blue-900 transition-colors shadow-sm text-lg">
                        <i class="fa-solid fa-search mr-2"></i> Cari Lowongan
                    </a>
                    <a href="{{ url('/register/penyedia') }}" class="inline-flex justify-center items-center px-6 py-3 bg-white text-text-dark border border-border-color rounded-md font-semibold hover:bg-gray-50 transition-colors shadow-sm text-lg">
                        <i class="fa-solid fa-plus mr-2 text-primary"></i> Pasang Lowongan
                    </a>
                </div>
            </div>
        </div>
        <!-- Simple decorative background elements -->
        <div class="absolute top-10 left-10 w-64 h-64 bg-secondary/10 rounded-full blur-3xl -z-10"></div>
        <div class="absolute bottom-10 right-10 w-64 h-64 bg-primary/10 rounded-full blur-3xl -z-10"></div>
    </section>

    <!-- Statistik Singkat -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="p-4">
                    <h3 class="text-4xl font-bold text-primary mb-2">{{ $stats['total_jobs'] ?? 0 }}+</h3>
                    <p class="text-text-gray font-medium">Lowongan Aktif</p>
                </div>
                <div class="p-4">
                    <h3 class="text-4xl font-bold text-primary mb-2">{{ $stats['total_providers'] ?? 0 }}+</h3>
                    <p class="text-text-gray font-medium">Penyedia Terverifikasi</p>
                </div>
                <div class="p-4">
                    <h3 class="text-4xl font-bold text-primary mb-2">{{ $stats['total_students'] ?? 0 }}+</h3>
                    <p class="text-text-gray font-medium">Mahasiswa Terdaftar</p>
                </div>
                <div class="p-4">
                    <h3 class="text-4xl font-bold text-primary mb-2">{{ $stats['total_applications'] ?? 0 }}+</h3>
                    <p class="text-text-gray font-medium">Lamaran Berhasil</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Kategori Pekerjaan -->
    <section class="py-16 bg-surface border-t border-b border-border-color">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-text-dark mb-4">Kategori Pekerjaan</h2>
                <p class="text-text-gray max-w-2xl mx-auto">Temukan pekerjaan yang sesuai dengan minat dan bakatmu melalui berbagai kategori yang tersedia.</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                @foreach($categories as $category)
                <a href="{{ url('/lowongan?category[]='.urlencode($category['name'])) }}" class="bg-white p-6 rounded-md border border-border-color text-center hover:border-primary hover:shadow-md transition-all group">
                    <div class="w-12 h-12 mx-auto bg-primary/10 text-primary rounded-full flex items-center justify-center mb-4 group-hover:bg-primary group-hover:text-white transition-colors">
                        <i class="fa-solid fa-tags text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-text-dark group-hover:text-primary transition-colors">{{ $category['name'] }}</h3>
                    <p class="text-sm text-text-gray mt-1">{{ $category['jobs_count'] ?? 0 }} Lowongan</p>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Lowongan Terbaru -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <h2 class="text-3xl font-bold text-text-dark mb-4">Lowongan Terbaru</h2>
                    <p class="text-text-gray">Jangan lewatkan kesempatan kerja part time terupdate.</p>
                </div>
                <a href="{{ url('/lowongan') }}" class="hidden md:flex items-center text-primary font-semibold hover:text-blue-900 transition-colors">
                    Lihat Semua <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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
                        <a href="{{ url('/lowongan/'.$job->id) }}" class="text-sm font-semibold text-primary hover:text-blue-900 transition-colors">Detail <i class="fa-solid fa-chevron-right text-xs ml-1"></i></a>
                    </div>
                </x-card>
                @endforeach
            </div>

            <div class="mt-8 text-center md:hidden">
                <x-button class="w-full" onclick="window.location.href='{{ url('/lowongan') }}'">Lihat Semua Lowongan</x-button>
            </div>
        </div>
    </section>

    <!-- Cara Kerja Aplikasi -->
    <section id="cara-kerja" class="py-16 bg-surface border-t border-b border-border-color">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-text-dark mb-4">Cara Kerja Partimeku</h2>
                <p class="text-text-gray max-w-2xl mx-auto">Proses mudah dan transparan dari awal hingga akhir, baik untuk mahasiswa maupun penyedia lowongan.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 relative">
                <!-- Decorative line for desktop -->
                <div class="hidden md:block absolute top-12 left-[15%] right-[15%] h-0.5 bg-border-color z-0"></div>

                <div class="relative z-10 text-center">
                    <div class="w-24 h-24 mx-auto bg-white border-4 border-surface rounded-full shadow-sm flex items-center justify-center text-3xl text-primary mb-6">
                        1
                    </div>
                    <h3 class="text-xl font-bold text-text-dark mb-3">Buat Akun</h3>
                    <p class="text-text-gray">Daftar sebagai mahasiswa menggunakan KTM, atau sebagai penyedia menggunakan dokumen legalitas usaha.</p>
                </div>
                
                <div class="relative z-10 text-center">
                    <div class="w-24 h-24 mx-auto bg-white border-4 border-surface rounded-full shadow-sm flex items-center justify-center text-3xl text-primary mb-6">
                        2
                    </div>
                    <h3 class="text-xl font-bold text-text-dark mb-3">Cari / Pasang Lowongan</h3>
                    <p class="text-text-gray">Mahasiswa dapat langsung mencari dan melamar, sementara penyedia dapat mempublikasikan lowongan part time.</p>
                </div>
                
                <div class="relative z-10 text-center">
                    <div class="w-24 h-24 mx-auto bg-white border-4 border-surface rounded-full shadow-sm flex items-center justify-center text-3xl text-primary mb-6">
                        3
                    </div>
                    <h3 class="text-xl font-bold text-text-dark mb-3">Kerja & Beri Review</h3>
                    <p class="text-text-gray">Selesaikan pekerjaan dengan baik, dan bangun reputasi melalui sistem review dua arah (Rating 1-5 Bintang).</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Keunggulan Platform -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-text-dark mb-6">Mengapa Memilih Partimeku?</h2>
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="w-12 h-12 shrink-0 bg-primary/10 text-primary rounded-md flex items-center justify-center text-xl">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-text-dark mb-1">Aman & Terverifikasi</h4>
                                <p class="text-text-gray text-sm">Setiap penyedia lowongan dan mahasiswa harus melalui tahap verifikasi dokumen oleh admin.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-12 h-12 shrink-0 bg-primary/10 text-primary rounded-md flex items-center justify-center text-xl">
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-text-dark mb-1">Sistem Review Transparan</h4>
                                <p class="text-text-gray text-sm">Lihat rekam jejak penyedia atau pelamar melalui ulasan jujur setelah pekerjaan selesai.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-12 h-12 shrink-0 bg-primary/10 text-primary rounded-md flex items-center justify-center text-xl">
                                <i class="fa-solid fa-bolt"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-text-dark mb-1">Cepat & Mudah</h4>
                                <p class="text-text-gray text-sm">Navigasi intuitif untuk apply langsung dari smartphone kamu, tanpa proses rekrutmen berbelit.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-surface rounded-md border border-border-color p-8 flex items-center justify-center min-h-[400px]">
                    <div class="text-center text-text-gray">
                        <i class="fa-solid fa-handshake text-8xl mb-6 text-secondary opacity-80"></i>
                        <h4 class="text-xl font-bold text-text-dark">Sinergi Lokal</h4>
                        <p class="mt-2">Mendukung pertumbuhan UMKM sekaligus membantu ekonomi mahasiswa.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-primary text-white relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-800 rounded-full mix-blend-multiply filter blur-3xl opacity-70"></div>
            <div class="absolute top-10 -right-10 w-72 h-72 bg-secondary rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto">
                <h2 class="text-3xl md:text-4xl text-secondary font-bold mb-6">Siap Memulai Perjalananmu?</h2>
                <p class="text-blue-100 text-lg mb-10">Bergabunglah dengan ribuan mahasiswa dan UMKM lainnya yang sudah merasakan manfaat dari Partimeku.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ url('/register/mahasiswa') }}" class="inline-flex justify-center items-center px-8 py-4 bg-white text-primary rounded-md font-bold hover:bg-gray-100 transition-colors shadow-lg text-lg">
                        Daftar sebagai Mahasiswa
                    </a>
                    <a href="{{ url('/register/penyedia') }}" class="inline-flex justify-center items-center px-8 py-4 bg-transparent border-2 border-white text-white rounded-md font-bold hover:bg-white/10 transition-colors shadow-sm text-lg">
                        Daftar sebagai Penyedia
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
