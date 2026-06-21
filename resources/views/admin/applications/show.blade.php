@extends('layouts.admin')
@section('title', 'Detail Lamaran - Admin Partimeku')
@section('page_title', 'Detail Lamaran')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">

    @if(session('success'))
        <div class="rounded-md bg-green-50 p-4 border border-green-200 mb-6">
            <p class="text-sm font-medium text-green-800"><i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}</p>
        </div>
    @endif

    <!-- Header Halaman -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div class="flex items-center gap-3">
        <a href="{{ url('/admin/applications') }}" class="w-9 h-9 flex items-center justify-center rounded-full bg-white border border-border-color text-text-dark hover:bg-surface transition-colors shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
        </a>

        <h2 class="text-2xl font-bold text-text-dark">Detail Lamaran</h2>
    </div>

    <div class="flex flex-wrap gap-2">
        <button onclick="openModal('modal-status')" class="inline-flex items-center rounded bg-white border border-border-color px-4 py-2 text-sm font-bold text-text-dark hover:bg-surface transition-colors shadow-sm">
            <i class="fa-solid fa-rotate mr-2"></i>
            Ubah Status
        </button>
    </div>
</div>

    <!-- ROW 1: PROFIL PELAMAR + DETAIL PEKERJAAN -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- KOLOM KIRI: PROFIL + DATA DIRI -->
    <x-card>
        <!-- Profil Singkat -->
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
            <div class="w-24 h-24 rounded-full bg-primary/10 text-primary flex items-center justify-center text-3xl font-bold shrink-0 shadow-sm border border-border-color">
                {{ strtoupper(substr($application['student_name'] ?? 'R', 0, 1)) }}{{ strtoupper(substr(explode(' ', $application['student_name'] ?? 'P')[1] ?? '', 0, 1)) }}
            </div>

            <div class="flex-1 text-center sm:text-left">
                <h3 class="text-2xl font-bold text-text-dark">
                    {{ $application['student_name'] ?? 'Raka Pratama' }}
                </h3>

                <p class="text-sm text-text-gray mt-1">
                    {{ $studentProfile['campus'] ?? 'Universitas Sriwijaya' }}
                </p>

                <div class="flex items-center justify-center sm:justify-start gap-2 mt-3">
                    @if($ratingData['total'] > 0)
                    <div class="flex text-warning text-sm">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($ratingData['average']))
                                <i class="fa-solid fa-star"></i>
                            @elseif($i == ceil($ratingData['average']) && $ratingData['average'] - floor($ratingData['average']) > 0)
                                <i class="fa-solid fa-star-half-stroke"></i>
                            @else
                                <i class="fa-regular fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="text-sm font-bold text-text-dark">{{ $ratingData['average'] }}</span>
                    <span class="text-sm text-text-gray">({{ $ratingData['total'] }} review)</span>
                    @else
                    <span class="text-sm text-text-gray">Belum ada review</span>
                    @endif
                </div>

                @php
                    $status = $application['status'] ?? 'diproses';
                    $statusClasses = 'bg-success/10 text-success';

                    if ($status == 'menunggu') {
                        $statusClasses = 'bg-warning/10 text-warning';
                    }

                    if ($status == 'ditolak') {
                        $statusClasses = 'bg-danger/10 text-danger';
                    }
                @endphp

                <div class="mt-4 flex flex-col sm:flex-row sm:items-center gap-3">
                    <span class="inline-flex justify-center {{ $statusClasses }} px-4 py-1 rounded text-xs font-bold capitalize w-fit mx-auto sm:mx-0">
                        {{ $status == 'menunggu' ? 'Menunggu' : ($status == 'ditolak' ? 'Ditolak' : 'Diproses') }}
                    </span>

                    <span class="text-sm text-text-gray font-medium">
                        <i class="fa-regular fa-calendar mr-2"></i>
                        {{ \Carbon\Carbon::parse($application['applied_at'] ?? now())->format('d M Y') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Data diri -->
     <div class="mt-5 border-t border-border-color pt-5">
    <h4 class="font-bold text-text-dark flex items-center gap-2 mb-5">
        <i class="fa-solid fa-user text-primary"></i>
        Data Diri Pelamar
    </h4>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-2 text-sm">

        <!-- Nama Lengkap -->
        <div class="flex items-start gap-4 mb-2">
            <div class="w-10 h-10 rounded-lg bg-surface flex items-center justify-center text-text-gray shrink-0 text-base">
                <i class="fa-regular fa-user"></i>
            </div>
            <div class="min-w-0">
                <p class="text-text-gray text-sm mb-1">Nama Lengkap</p>
                <p class="font-bold text-text-dark text-sm leading-tight">
                    {{ $application['student_name'] ?? 'Raka Pratama' }}
                </p>
            </div>
        </div>
 
        <!-- Jurusan -->
        <div class="flex items-start gap-4 mb-2">
            <div class="w-10 h-10 rounded-lg bg-surface flex items-center justify-center text-text-gray shrink-0 text-base">
                <i class="fa-solid fa-book"></i>
            </div>
            <div class="min-w-0">
                <p class="text-text-gray text-sm mb-1">Jurusan</p>
                <p class="font-bold text-text-dark text-sm leading-tight">
                    {{ $studentProfile['major'] ?? 'Sistem Informasi' }}
                </p>
            </div>
        </div>

        <!-- Email -->
        <div class="flex items-start gap-4 mb-2">
            <div class="w-10 h-10 rounded-lg bg-surface flex items-center justify-center text-text-gray shrink-0 text-base">
                <i class="fa-regular fa-envelope"></i>
            </div>
            <div class="min-w-0">
                <p class="text-text-gray text-sm mb-1">Email</p>
                <p class="font-bold text-text-dark text-sm leading-tight break-all">
                    {{ $user['email'] ?? 'raka@student.test' }}
                </p>
            </div>
        </div>

        <!-- Semester -->
        <div class="flex items-start gap-4 mb-2">
            <div class="w-10 h-10 rounded-lg bg-surface flex items-center justify-center text-text-gray shrink-0 text-base">
                <i class="fa-solid fa-layer-group"></i>
            </div>
            <div class="min-w-0">
                <p class="text-text-gray text-sm mb-1">Semester</p>
                <p class="font-bold text-text-dark text-sm leading-tight">
                    Semester {{ $studentProfile['semester'] ?? '6' }}
                </p>
            </div>
        </div>

        <!-- Nomor Telepon -->
        <div class="flex items-start gap-4 mb-2">
            <div class="w-10 h-10 rounded-lg bg-surface flex items-center justify-center text-text-gray shrink-0 text-base">
                <i class="fa-solid fa-phone"></i>
            </div>
            <div class="min-w-0">
                <p class="text-text-gray text-sm mb-1">No. Telepon</p>
                <p class="font-bold text-text-dark text-sm leading-tight">
                    {{ $user['phone'] ?? '081234567801' }}
                </p>
            </div>
        </div>

        <!-- IPK -->
        <div class="flex items-start gap-4 mb-2">
            <div class="w-10 h-10 rounded-lg bg-surface flex items-center justify-center text-text-gray shrink-0 text-base">
                <i class="fa-solid fa-award"></i>
            </div>
            <div class="min-w-0">
                <p class="text-text-gray text-sm mb-1">IPK</p>
                <p class="font-bold text-text-dark text-sm leading-tight">
                    {{ $studentProfile['gpa'] ?? '3.75' }} / 4.00
                </p>
            </div>
        </div>

        <!-- Asal Kampus -->
        <div class="flex items-start gap-4 mb-2 md:col-span-2">
            <div class="w-10 h-10 rounded-lg bg-surface flex items-center justify-center text-text-gray shrink-0 text-base">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div class="min-w-0">
                <p class="text-text-gray text-sm mb-1">Asal Kampus</p>
                <p class="font-bold text-text-dark text-sm leading-tight">
                    {{ $studentProfile['campus'] ?? 'Universitas Sriwijaya' }}
                </p>
            </div>
        </div>
    </div>
</div>
    </x-card>

    <!-- KOLOM KANAN: DETAIL PEKERJAAN -->
    <x-card class="h-full">
        <h4 class="font-bold text-text-dark flex items-center gap-2 mb-6 border-b border-border-color pb-2">
            <i class="fa-solid fa-briefcase text-primary"></i> Detail Pekerjaan
        </h4>
        
        <div class="space-y-0 text-sm">
            <div class="flex justify-between items-center border-b border-border-color py-4 first:pt-0">
                <span class="text-text-gray">Posisi</span>
                <span class="font-bold text-primary text-right">{{ $application['job_title'] ?? 'Barista Part Time Sore' }}</span>
            </div>
            <div class="flex justify-between items-center border-b border-border-color py-4">
                <span class="text-text-gray">Penyedia</span>
                <span class="font-bold text-text-dark text-right">{{ $application['provider_name'] ?? 'Kopi Sari Nusantara' }}</span>
            </div>
            <div class="flex justify-between items-center border-b border-border-color py-4">
                <span class="text-text-gray">Lokasi</span>
                <span class="font-bold text-text-dark text-right"><i class="fa-solid fa-location-dot text-text-gray mr-1"></i> Palembang, Sumatera Selatan</span>
            </div>
            <div class="flex justify-between items-center border-b border-border-color py-4">
                <span class="text-text-gray">Tipe Pekerjaan</span>
                <span class="font-bold text-text-dark text-right">Part Time</span>
            </div>
            <div class="flex justify-between items-center border-b border-border-color py-4">
                <span class="text-text-gray">ID Lowongan</span>
                <span class="font-bold text-text-dark text-right">#JOB-{{ str_pad($application['id'] ?? '2', 3, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="flex justify-between items-center py-4 pb-0">
                <span class="text-text-gray">Tanggal Dibuat</span>
                <span class="font-bold text-text-dark text-right">15 May 2026</span>
            </div>
        </div>
    </x-card>
</div>

<!-- ROW 2: DOKUMEN PENDUKUNG FULL WIDTH -->
<x-card>
    <h4 class="font-bold text-text-dark flex items-center gap-2 mb-5 border-b border-border-color pb-3">
        <i class="fa-solid fa-file-lines text-primary"></i>
        Dokumen Pendukung
    </h4>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- KTM -->
        <div class="border border-border-color rounded-lg p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-info/10 text-info rounded-md flex items-center justify-center text-2xl shrink-0 border border-info/20">
                    <i class="fa-solid fa-id-card-clip"></i>
                </div>

                <div>
                    <h5 class="font-bold text-sm text-text-dark">Kartu Tanda Mahasiswa (KTM)</h5>
                    <p class="text-xs text-text-gray mt-1">Format: JPG/PNG • 250 KB</p>
                </div>
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button onclick="openModal('modal-preview-ktm')" class="flex-1 sm:flex-none px-4 py-2 bg-white border border-border-color rounded text-xs font-bold text-text-dark hover:bg-surface transition-colors">
                    <i class="fa-solid fa-eye mr-1.5"></i>
                    Preview
                </button>

                @if(!empty($studentProfile['ktm_path']))
                @php $ktmExt = pathinfo($studentProfile['ktm_path'], PATHINFO_EXTENSION); @endphp
                <a href="{{ Storage::url($studentProfile['ktm_path']) }}" download="KTM_{{ $application['student_name'] ?? 'Pelamar' }}.{{ $ktmExt }}" class="flex-1 sm:flex-none px-4 py-2 bg-primary rounded text-xs font-bold text-white hover:brightness-90 transition-all text-center">
                    <i class="fa-solid fa-download mr-1.5"></i>
                    Unduh
                </a>
                @else
                <button disabled class="flex-1 sm:flex-none px-4 py-2 bg-gray-300 rounded text-xs font-bold text-white cursor-not-allowed">
                    <i class="fa-solid fa-download mr-1.5"></i>
                    Unduh
                </button>
                @endif
            </div>
        </div>

        <!-- CV -->
        <div class="border border-border-color rounded-lg p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-danger/10 text-danger rounded-md flex items-center justify-center text-[10px] font-black shrink-0 border border-danger/20 flex-col leading-none pt-1">
                    <i class="fa-solid fa-file-pdf text-xl mb-0.5"></i>
                    PDF
                </div>

                <div>
                    <h5 class="font-bold text-sm text-text-dark">Curriculum Vitae (CV)</h5>
                    <p class="text-xs text-text-gray mt-1">Format: PDF</p>
                </div>
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button onclick="openModal('modal-preview-cv')" class="flex-1 sm:flex-none px-4 py-2 bg-white border border-border-color rounded text-xs font-bold text-text-dark hover:bg-surface transition-colors">
                    <i class="fa-solid fa-eye mr-1.5"></i>
                    Preview
                </button>

                @if(!empty($studentProfile['cv_path']))
                @php $cvExt = pathinfo($studentProfile['cv_path'], PATHINFO_EXTENSION); @endphp
                <a href="{{ Storage::url($studentProfile['cv_path']) }}" download="CV_{{ $application['student_name'] ?? 'Pelamar' }}.{{ $cvExt }}" class="flex-1 sm:flex-none px-4 py-2 bg-primary rounded text-xs font-bold text-white hover:brightness-90 transition-all text-center">
                    <i class="fa-solid fa-download mr-1.5"></i>
                    Unduh
                </a>
                @else
                <button disabled class="flex-1 sm:flex-none px-4 py-2 bg-gray-300 rounded text-xs font-bold text-white cursor-not-allowed">
                    <i class="fa-solid fa-download mr-1.5"></i>
                    Unduh
                </button>
                @endif
            </div>
        </div>
    </div>
</x-card>

<!-- ROW 3: RATING & REVIEW FULL WIDTH -->
<x-card>
    <h4 class="font-bold text-text-dark flex items-center gap-2 mb-6 border-b border-border-color pb-3">
        <i class="fa-solid fa-star text-primary"></i>
        Rating & Review
    </h4>

    <div class="flex flex-col lg:flex-row gap-8">
        @if($ratingData['total'] > 0)
        <!-- Rating Total -->
        <div class="flex flex-col items-center justify-center text-center lg:px-8 lg:border-r border-border-color shrink-0">
            <h2 class="text-6xl font-bold text-text-dark">{{ $ratingData['average'] }}</h2>

            <div class="flex text-warning text-lg mt-3 gap-1">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= floor($ratingData['average']))
                        <i class="fa-solid fa-star"></i>
                    @elseif($i == ceil($ratingData['average']) && $ratingData['average'] - floor($ratingData['average']) > 0)
                        <i class="fa-solid fa-star-half-stroke"></i>
                    @else
                        <i class="fa-regular fa-star"></i>
                    @endif
                @endfor
            </div>

            <p class="text-sm text-text-gray mt-2 font-medium">
                Berdasarkan {{ $ratingData['total'] }} review
            </p>
        </div>

        <!-- Progress Rating -->
        <div class="w-full lg:w-1/3 flex flex-col justify-center space-y-3 lg:border-r border-border-color lg:pr-8 shrink-0">
            @for($i = 5; $i >= 1; $i--)
                @php
                    $count = $ratingData['counts'][$i];
                    $percent = $ratingData['total'] > 0 ? round(($count / $ratingData['total']) * 100) : 0;
                @endphp
                <div class="flex items-center gap-3 text-xs text-text-gray font-medium">
                    <span class="w-5">{{ $i }} <i class="fa-solid fa-star text-warning text-[10px]"></i></span>
                    <div class="flex-1 h-2 bg-surface rounded-full overflow-hidden">
                        <div class="h-full bg-warning rounded-full" style="width: {{ $percent }}%"></div>
                    </div>
                    <span class="w-14 text-right">{{ $count }} ({{ $percent }}%)</span>
                </div>
            @endfor
        </div>

        <!-- Review -->
        <div class="flex-1 space-y-4">
            @foreach($ratingData['reviews']->take(3) as $review)
            <div class="border border-border-color rounded-lg p-5">
                <div class="flex justify-between items-start">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm shrink-0 border border-primary/20">
                            {{ substr(strtoupper($review->reviewer->name ?? 'U'), 0, 2) }}
                        </div>

                        <div>
                            <h5 class="font-bold text-sm text-text-dark">{{ $review->reviewer->name ?? 'Pengguna' }}</h5>
                            <p class="text-xs text-text-gray mt-0.5">{{ ucfirst($review->reviewer->role ?? '') }}</p>

                            <div class="flex items-center gap-2 mt-1">
                                <div class="flex text-warning text-[10px]">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fa-solid fa-star"></i>
                                        @else
                                            <i class="fa-regular fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-xs font-bold text-text-dark">{{ number_format($review->rating, 1) }}</span>
                            </div>
                        </div>
                    </div>

                    <span class="text-[11px] text-text-gray font-medium">
                        {{ \Carbon\Carbon::parse($review->created_at)->format('d M Y') }}
                    </span>
                </div>

                <p class="text-sm text-text-gray mt-4 leading-relaxed font-medium">
                    {{ $review->comment }}
                </p>
            </div>
            @endforeach
        </div>
        @else
        <div class="w-full text-center py-8 text-text-gray">
            <i class="fa-regular fa-star text-4xl mb-3"></i>
            <p>Belum ada ulasan untuk pelamar ini.</p>
        </div>
        @endif
    </div>
</x-card>

<!-- Modal Ubah Status Lamaran -->
<x-modal id="modal-status" title="Ubah Status Lamaran">
    <form method="POST" action="{{ route('admin.applications.status', $application['id'] ?? 1) }}">
        @csrf @method('PUT')
        <div class="space-y-4">
            <p class="text-sm text-text-gray">Anda dapat memperbarui status lamaran ini. Biasanya status diatur oleh penyedia pekerjaan, tapi admin berhak melakukan intervensi.</p>
            <x-select name="status">
                <option value="pending" {{ ($application['status'] ?? '') == 'pending' ? 'selected' : '' }}>Menunggu (Pending)</option>
                <option value="diproses" {{ ($application['status'] ?? '') == 'diproses' ? 'selected' : '' }}>Diproses (In Review)</option>
                <option value="diterima" {{ ($application['status'] ?? '') == 'diterima' ? 'selected' : '' }}>Diterima (Approved)</option>
                <option value="ditolak" {{ ($application['status'] ?? '') == 'ditolak' ? 'selected' : '' }}>Ditolak (Rejected)</option>
            </x-select>
        </div>
        <div class="mt-5 flex justify-end gap-2">
            <button type="button" class="inline-flex justify-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-text-dark shadow-sm ring-1 ring-inset ring-border-color hover:bg-surface" onclick="closeModal('modal-status')">Batal</button>
            <x-button type="submit">Simpan Perubahan</x-button>
        </div>
    </form>
</x-modal>

<!-- Modal Preview KTM -->
<x-modal id="modal-preview-ktm" title="Preview Kartu Tanda Mahasiswa">
    <div class="flex justify-center items-center bg-gray-100 rounded-lg p-4 overflow-hidden min-h-48">
        @if(!empty($studentProfile['ktm_path']))
            @php $ktmUrl = Storage::url($studentProfile['ktm_path']); @endphp
            @if(Str::endsWith(strtolower($studentProfile['ktm_path']), ['.jpg', '.jpeg', '.png']))
                <img src="{{ $ktmUrl }}" alt="KTM" class="max-h-80 max-w-full object-contain rounded">
            @else
                <iframe src="{{ $ktmUrl }}" class="w-full h-80 rounded" frameborder="0"></iframe>
            @endif
        @else
            <div class="text-center text-text-gray">
                <i class="fa-solid fa-image text-5xl mb-3 text-gray-400"></i>
                <p>KTM belum diunggah</p>
            </div>
        @endif
    </div>
    @if(!empty($studentProfile['ktm_path']))
    <div class="mt-3 flex justify-end">
        <a href="{{ Storage::url($studentProfile['ktm_path']) }}" download class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white text-sm rounded font-bold hover:brightness-90">
            <i class="fa-solid fa-download"></i> Unduh KTM
        </a>
    </div>
    @endif
    <x-slot name="footer">
        <button type="button" class="inline-flex justify-center rounded-md bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm hover:brightness-90 transition-all" onclick="closeModal('modal-preview-ktm')">Tutup</button>
    </x-slot>
</x-modal>

<!-- Modal Preview CV -->
<x-modal id="modal-preview-cv" title="Preview Curriculum Vitae">
    <div class="flex justify-center items-center bg-gray-100 rounded-lg p-4 overflow-hidden min-h-64">
        @if(!empty($studentProfile['cv_path']))
            <iframe src="{{ Storage::url($studentProfile['cv_path']) }}" class="w-full h-96 rounded" frameborder="0"></iframe>
        @else
            <div class="text-center text-text-gray">
                <i class="fa-solid fa-file-pdf text-5xl mb-3 text-danger/50"></i>
                <p>CV belum diunggah</p>
            </div>
        @endif
    </div>
    @if(!empty($studentProfile['cv_path']))
    <div class="mt-3 flex justify-end">
        <a href="{{ Storage::url($studentProfile['cv_path']) }}" download class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white text-sm rounded font-bold hover:brightness-90">
            <i class="fa-solid fa-download"></i> Unduh CV
        </a>
    </div>
    @endif
    <x-slot name="footer">
        <button type="button" class="inline-flex justify-center rounded-md bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm hover:brightness-90 transition-all" onclick="closeModal('modal-preview-cv')">Tutup</button>
    </x-slot>
</x-modal>

@push('scripts')
<script>
    function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
    function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
</script>
@endpush
@endsection
