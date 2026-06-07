@extends('layouts.admin')
@section('title', 'Detail Lowongan - Admin Partimeku')
@section('page_title', 'Detail Lowongan')

@section('content')
<div class="space-y-6 max-w-6xl">
    <!-- Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ url('/admin/jobs') }}" class="text-text-gray hover:text-primary transition-colors">
                <i class="fa-solid fa-arrow-left text-xl"></i>
            </a>
            <h2 class="text-2xl font-bold text-text-dark">Detail Lowongan</h2>
        </div>
        <div class="flex flex-wrap gap-2">
            @if(($job['status'] ?? 'aktif') === 'aktif')
                <button onclick="openModal('modal-nonaktif')" class="inline-flex items-center rounded-md bg-white border border-danger/30 text-danger px-4 py-2 text-sm font-medium hover:bg-danger/5 transition-colors">
                    <i class="fa-solid fa-ban mr-2"></i> Nonaktifkan
                </button>
            @else
                <button onclick="showToast('Lowongan berhasil diaktifkan', 'success')" class="inline-flex items-center rounded-md bg-white border border-success/30 text-success px-4 py-2 text-sm font-medium hover:bg-success/5 transition-colors">
                    <i class="fa-solid fa-check mr-2"></i> Aktifkan
                </button>
            @endif
        </div>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg border border-border-color shadow-sm p-4 flex items-center gap-4">
            <div class="h-10 w-10 rounded-full bg-primary/10 text-primary flex items-center justify-center text-lg">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-text-gray uppercase tracking-wider mb-0.5">Total Pelamar</p>
                <p class="text-lg font-bold text-text-dark leading-none">{{ rand(10, 50) }} <span class="text-sm font-medium text-text-gray normal-case">Orang</span></p>
            </div>
        </div>
        <div class="bg-white rounded-lg border border-border-color shadow-sm p-4 flex items-center gap-4">
            <div class="h-10 w-10 rounded-full bg-info/10 text-info flex items-center justify-center text-lg">
                <i class="fa-solid fa-eye"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-text-gray uppercase tracking-wider mb-0.5">Dilihat</p>
                <p class="text-lg font-bold text-text-dark leading-none">{{ rand(100, 500) }} <span class="text-sm font-medium text-text-gray normal-case">Kali</span></p>
            </div>
        </div>
        <div class="bg-white rounded-lg border border-border-color shadow-sm p-4 flex items-center gap-4">
            <div class="h-10 w-10 rounded-full bg-surface text-text-gray flex items-center justify-center text-lg">
                <i class="fa-solid fa-tag"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-text-gray uppercase tracking-wider mb-1">Status Lowongan</p>
                <div class="leading-none">
                    @php
                        $st = $job['status'] ?? 'aktif';
                        if($st === 'aktif') echo '<span class="inline-flex items-center gap-1.5 rounded-full bg-success/10 px-2 py-0.5 text-xs font-bold text-success"><span class="h-1.5 w-1.5 rounded-full bg-success"></span> Aktif</span>';
                        elseif($st === 'selesai') echo '<span class="inline-flex items-center gap-1.5 rounded-full bg-text-gray/10 px-2 py-0.5 text-xs font-bold text-text-gray"><span class="h-1.5 w-1.5 rounded-full bg-text-gray"></span> Ditutup / Selesai</span>';
                        elseif($st === 'menunggu_review') echo '<span class="inline-flex items-center gap-1.5 rounded-full bg-warning/10 px-2 py-0.5 text-xs font-bold text-warning"><span class="h-1.5 w-1.5 rounded-full bg-warning"></span> Menunggu Verifikasi</span>';
                        else echo '<span class="inline-flex items-center gap-1.5 rounded-full bg-danger/10 px-2 py-0.5 text-xs font-bold text-danger"><span class="h-1.5 w-1.5 rounded-full bg-danger"></span> Ditolak</span>';
                    @endphp
                </div>
            </div>
        </div>
    </div>

    <!-- Main Layout -->
    <div class="flex flex-col md:flex-row gap-6 items-start">
        
        <!-- Sidebar Info -->
        <div class="w-full md:w-1/3 flex flex-col gap-6">
            <!-- Job Summary Card -->
            <x-card>
                <div class="mb-6 flex flex-col items-center border-b border-border-color pb-6">
                    <div class="h-16 w-16 bg-primary/10 rounded-xl flex items-center justify-center text-primary text-2xl mb-4">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                    <h3 class="text-xl font-bold text-text-dark text-center leading-tight">{{ $job['title'] }}</h3>
                    <p class="text-primary font-semibold text-sm mt-2 text-center">{{ $job['category'] ?? 'Kategori Umum' }}</p>
                </div>

                <div class="space-y-5">
                    <div>
                        <p class="text-xs text-text-gray uppercase tracking-wider font-semibold mb-1.5">Gaji / Honor</p>
                        <p class="font-medium text-text-dark flex items-center gap-3">
                            <i class="fa-solid fa-money-bill-wave text-success w-5 text-center"></i>
                            Rp {{ number_format($job['salary'] ?? 0, 0, ',', '.') }} {{ isset($job['salary_type']) ? '/ '.$job['salary_type'] : '' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-text-gray uppercase tracking-wider font-semibold mb-1.5">Lokasi</p>
                        <p class="font-medium text-text-dark flex items-start gap-3">
                            <i class="fa-solid fa-location-dot text-danger mt-1 w-5 text-center"></i>
                            {{ $job['location'] ?? 'Belum ditentukan' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-text-gray uppercase tracking-wider font-semibold mb-1.5">Jam Kerja</p>
                        <p class="font-medium text-text-dark flex items-center gap-3">
                            <i class="fa-solid fa-clock text-warning w-5 text-center"></i>
                            {{ $job['working_hours'] ?? 'Belum ditentukan' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-text-gray uppercase tracking-wider font-semibold mb-1.5">Jenis Pekerjaan</p>
                        <p class="font-medium text-text-dark flex items-center gap-3">
                            <i class="fa-solid fa-user-clock text-info w-5 text-center"></i>
                            Part Time
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-text-gray uppercase tracking-wider font-semibold mb-1.5">Kuota Pelamar</p>
                        <p class="font-medium text-text-dark flex items-center gap-3">
                            <i class="fa-solid fa-user-group text-primary w-5 text-center"></i>
                            {{ $job['quota'] ?? rand(5, 20) }} Orang
                        </p>
                    </div>
                </div>
            </x-card>

            <!-- Provider Info Card -->
            <x-card>
                <h4 class="text-sm font-bold text-text-dark uppercase tracking-wider border-b border-border-color pb-3 mb-4">Informasi Penyedia</h4>
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($job['provider_name'] ?? 'Penyedia') }}&background=E0E7FF&color=1E3A8A&bold=true" class="w-12 h-12 rounded-full border border-border-color" alt="Logo">
                        <div>
                            <p class="font-bold text-text-dark text-base">{{ $job['provider_name'] ?? 'Penyedia Tidak Diketahui' }}</p>
                            <p class="text-xs text-text-gray mt-0.5">Perusahaan / Instansi</p>
                        </div>
                    </div>
                    <div class="text-sm space-y-3 bg-surface p-3 rounded-md border border-border-color">
                        <div class="flex items-center gap-3 text-text-dark font-medium">
                            <i class="fa-solid fa-envelope text-text-gray w-4 text-center"></i>
                            {{ strtolower(str_replace(' ', '', $job['provider_name'] ?? 'provider')) }}@gmail.com
                        </div>
                        <div class="flex items-center gap-3 text-text-dark font-medium">
                            <i class="fa-solid fa-phone text-text-gray w-4 text-center"></i>
                            08{{ rand(100000000, 999999999) }}
                        </div>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Main Content (Desc & Req) -->
        <div class="w-full md:w-2/3 space-y-6">
            <x-card>
                <!-- Deskripsi -->
                <div class="mb-8">
                    <h4 class="text-lg font-bold text-text-dark mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-align-left text-primary"></i> Deskripsi Pekerjaan
                    </h4>
                    <div class="prose prose-sm max-w-none text-text-dark leading-relaxed">
                        <p>{{ $job['description'] ?? 'Tidak ada deskripsi yang tersedia.' }}</p>
                    </div>
                </div>

                <!-- Persyaratan -->
                <div class="mb-8">
                    <h4 class="text-lg font-bold text-text-dark mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-primary"></i> Persyaratan
                    </h4>
                    <ul class="space-y-3 text-sm text-text-dark font-medium">
                        @if(isset($job['requirements']) && is_array($job['requirements']))
                            @foreach($job['requirements'] as $req)
                                <li class="flex items-start gap-3 bg-surface p-2.5 rounded-md border border-border-color">
                                    <i class="fa-solid fa-check text-white bg-primary rounded-full p-1 text-[10px] mt-0.5"></i>
                                    <span class="leading-relaxed">{{ $req }}</span>
                                </li>
                            @endforeach
                        @else
                            <li class="flex items-start gap-3 bg-surface p-2.5 rounded-md border border-border-color">
                                <i class="fa-solid fa-check text-white bg-primary rounded-full p-1 text-[10px] mt-0.5"></i>
                                <span class="leading-relaxed">Berkomunikasi dengan baik dan ramah</span>
                            </li>
                            <li class="flex items-start gap-3 bg-surface p-2.5 rounded-md border border-border-color">
                                <i class="fa-solid fa-check text-white bg-primary rounded-full p-1 text-[10px] mt-0.5"></i>
                                <span class="leading-relaxed">Tepat waktu dan bertanggung jawab atas pekerjaan</span>
                            </li>
                            <li class="flex items-start gap-3 bg-surface p-2.5 rounded-md border border-border-color">
                                <i class="fa-solid fa-check text-white bg-primary rounded-full p-1 text-[10px] mt-0.5"></i>
                                <span class="leading-relaxed">Berpakaian rapi dan sopan selama jam kerja</span>
                            </li>
                            <li class="flex items-start gap-3 bg-surface p-2.5 rounded-md border border-border-color">
                                <i class="fa-solid fa-check text-white bg-primary rounded-full p-1 text-[10px] mt-0.5"></i>
                                <span class="leading-relaxed">Berpengalaman di bidang terkait lebih disukai</span>
                            </li>
                        @endif
                    </ul>
                </div>

                <!-- Detail Lainnya / Timeline -->
                <div>
                    <h4 class="text-lg font-bold text-text-dark mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-calendar-days text-primary"></i> Timeline Lowongan
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 bg-surface p-5 rounded-lg border border-border-color">
                        <div>
                            <p class="text-xs text-text-gray font-semibold mb-1 uppercase">ID Lowongan</p>
                            <p class="font-bold text-text-dark text-base">#{{ str_pad($job['id'] ?? '1', 5, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-text-gray font-semibold mb-1 uppercase">Tanggal Dibuat</p>
                            <p class="font-bold text-text-dark text-base">{{ \Carbon\Carbon::parse($job['created_at'] ?? now())->format('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-text-gray font-semibold mb-1 uppercase">Batas Lamaran</p>
                            <p class="font-bold text-text-dark text-base text-danger">
                                @if(isset($job['deadline']))
                                    {{ \Carbon\Carbon::parse($job['deadline'])->format('d F Y') }}
                                @else
                                    {{ \Carbon\Carbon::parse($job['created_at'] ?? now())->addDays(14)->format('d F Y') }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </x-card>

            <!-- Ulasan & Penilaian Card -->
            <x-card>
                <div class="flex items-center justify-between border-b border-border-color pb-4 mb-5">
                    <h4 class="text-lg font-bold text-text-dark flex items-center gap-2">
                        <i class="fa-solid fa-star text-warning"></i> Penilaian & Ulasan Pekerja
                    </h4>
                    <span class="text-sm text-text-gray font-medium">{{ rand(10, 30) }} Ulasan</span>
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-6 mb-6">
                    <div class="text-center w-full sm:w-auto">
                        <p class="text-5xl font-bold text-text-dark">4.8</p>
                        <div class="flex text-warning text-sm mt-2 justify-center">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star-half-stroke"></i>
                        </div>
                        <p class="text-xs text-text-gray mt-1">Sangat Baik</p>
                    </div>
                    <div class="flex-1 w-full space-y-2 text-sm text-text-gray sm:border-l border-border-color sm:pl-6">
                        <div class="flex items-center gap-3"><span class="w-3 font-medium">5</span> <i class="fa-solid fa-star text-warning text-[10px]"></i> <div class="h-2 w-full bg-surface border border-border-color rounded-full overflow-hidden"><div class="h-full bg-warning w-[75%] rounded-full"></div></div></div>
                        <div class="flex items-center gap-3"><span class="w-3 font-medium">4</span> <i class="fa-solid fa-star text-warning text-[10px]"></i> <div class="h-2 w-full bg-surface border border-border-color rounded-full overflow-hidden"><div class="h-full bg-warning w-[20%] rounded-full"></div></div></div>
                        <div class="flex items-center gap-3"><span class="w-3 font-medium">3</span> <i class="fa-solid fa-star text-warning text-[10px]"></i> <div class="h-2 w-full bg-surface border border-border-color rounded-full overflow-hidden"><div class="h-full bg-warning w-[5%] rounded-full"></div></div></div>
                        <div class="flex items-center gap-3"><span class="w-3 font-medium">2</span> <i class="fa-solid fa-star text-warning text-[10px]"></i> <div class="h-2 w-full bg-surface border border-border-color rounded-full overflow-hidden"><div class="h-full bg-warning w-0 rounded-full"></div></div></div>
                        <div class="flex items-center gap-3"><span class="w-3 font-medium">1</span> <i class="fa-solid fa-star text-warning text-[10px]"></i> <div class="h-2 w-full bg-surface border border-border-color rounded-full overflow-hidden"><div class="h-full bg-warning w-0 rounded-full"></div></div></div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="bg-surface p-4 rounded-lg border border-border-color">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=fff&color=1E3A8A&bold=true" class="w-9 h-9 rounded-full border border-border-color shadow-sm" alt="User">
                                <div>
                                    <p class="text-sm font-bold text-text-dark leading-none">Budi Santoso</p>
                                    <p class="text-xs text-text-gray mt-1">Mahasiswa Universitas Sriwijaya</p>
                                </div>
                            </div>
                            <div class="flex text-warning text-xs">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                            </div>
                        </div>
                        <p class="text-sm text-text-dark leading-relaxed">Pengalaman luar biasa! Bosnya sangat pengertian dan jam kerjanya fleksibel, sangat cocok untuk mahasiswa yang sedang berkuliah.</p>
                        <p class="text-xs text-text-gray mt-3 font-medium">2 Hari yang lalu</p>
                    </div>

                    <div class="bg-surface p-4 rounded-lg border border-border-color">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name=Siti+Aminah&background=fff&color=1E3A8A&bold=true" class="w-9 h-9 rounded-full border border-border-color shadow-sm" alt="User">
                                <div>
                                    <p class="text-sm font-bold text-text-dark leading-none">Siti Aminah</p>
                                    <p class="text-xs text-text-gray mt-1">Mahasiswa Politeknik Negeri Sriwijaya</p>
                                </div>
                            </div>
                            <div class="flex text-warning text-xs">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                            </div>
                        </div>
                        <p class="text-sm text-text-dark leading-relaxed">Semuanya oke, gaji dibayar sesuai kesepakatan dan tidak pernah terlambat. Lingkungan kerjanya juga cukup nyaman dan tim suportif.</p>
                        <p class="text-xs text-text-gray mt-3 font-medium">1 Minggu yang lalu</p>
                    </div>
                </div>
                
                <button class="w-full mt-5 py-2.5 bg-white border border-border-color rounded-md text-sm font-semibold text-text-dark hover:bg-surface transition-colors shadow-sm">Lihat Semua Ulasan</button>
            </x-card>
        </div>
    </div>
</div>

<!-- Modal Nonaktif -->
<x-confirm-modal id="modal-nonaktif" title="Nonaktifkan Lowongan" message="Apakah Anda yakin ingin menonaktifkan lowongan ini?" confirmText="Nonaktifkan" />

@push('scripts')
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }
    function confirmAction(id) {
        closeModal(id);
        if (id === 'modal-nonaktif') showToast('Lowongan berhasil dinonaktifkan', 'warning');
    }
</script>
@endpush
@endsection
