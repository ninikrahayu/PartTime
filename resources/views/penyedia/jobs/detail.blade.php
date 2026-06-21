@extends('layouts.penyedia')

@section('title', 'Detail Lowongan - Penyedia Partimeku')
@section('page_title', 'Detail Lowongan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-sm font-medium text-primary">Detail Lowongan</p>
            <h2 class="mt-1 text-2xl font-semibold text-text-dark">{{ $job->judul }}</h2>
            <p class="mt-1 text-sm text-text-gray">{{ $job->penyedia->name ?? '' }} - {{ $job->category ?? 'Umum' }}</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ url('/penyedia/jobs/'.$job->id.'/edit') }}" class="inline-flex items-center rounded-md border border-border-color bg-white px-4 py-2 text-sm font-medium text-text-dark hover:bg-surface">
                <i class="fa-solid fa-pen-to-square mr-2 text-primary"></i>Edit Lowongan
            </a>
            <button type="button" onclick="openModal('close-job')" class="inline-flex items-center rounded-md border border-warning bg-white px-4 py-2 text-sm font-medium text-warning hover:bg-warning/10">
                <i class="fa-solid fa-lock mr-2"></i>Tutup
            </button>
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-dashboard-summary-card label="Jumlah Pelamar" :value="$applicationStats['total']" icon="fa-file-signature" />
        <x-dashboard-summary-card label="Pelamar Diterima" :value="$applicationStats['accepted']" icon="fa-user-check" />
        <x-dashboard-summary-card label="Pelamar Ditolak" :value="$applicationStats['rejected']" icon="fa-user-xmark" />
        <x-dashboard-summary-card label="Diproses" :value="$applicationStats['processed']" icon="fa-spinner" />
    </div>

    <div class="grid gap-6 xl:grid-cols-[1fr_360px]">
        <x-card>
            <x-slot:header>
                <div class="flex items-start justify-between gap-4">
                    <h3 class="text-base font-semibold text-text-dark">Informasi Lowongan</h3>
                    <x-status-badge :status="$job->status" />
                </div>
            </x-slot:header>

            <div class="space-y-5">
                <div class="grid gap-4 text-sm sm:grid-cols-2">
                    <div><span class="text-text-gray">Lokasi</span><p class="font-medium text-text-dark">{{ $job->lokasi }}</p></div>
                    <div><span class="text-text-gray">Jadwal</span><p class="font-medium text-text-dark">{{ $job->shift }}</p></div>
                    <div><span class="text-text-gray">Gaji</span><p class="font-medium text-text-dark">Rp {{ number_format($job->gaji ?? 0, 0, ',', '.') }} / {{ $job->salary_type ?? '-' }}</p></div>
                    <div><span class="text-text-gray">Kuota</span><p class="font-medium text-text-dark">{{ $job->quota ?? '-' }} orang</p></div>
                    <div><span class="text-text-gray">Tanggal Mulai</span><p class="font-medium text-text-dark">{{ $job->start_date ? \Carbon\Carbon::parse($job->start_date)->format('d M Y') : '-' }}</p></div>
                    <div><span class="text-text-gray">Tanggal Akhir</span><p class="font-medium text-text-dark">{{ $job->end_date ? \Carbon\Carbon::parse($job->end_date)->format('d M Y') : '-' }}</p></div>
                    <div><span class="text-text-gray">Batas Lamaran</span><p class="font-medium text-text-dark">{{ $job->deadline ? \Carbon\Carbon::parse($job->deadline)->format('d M Y') : '-' }}</p></div>
                    <div><span class="text-text-gray">Tanggal Dibuat</span><p class="font-medium text-text-dark">{{ $job->created_at->format('d M Y') }}</p></div>
                </div>

                <div>
                    <h4 class="text-sm font-semibold text-text-dark">Deskripsi Pekerjaan</h4>
                    <p class="mt-2 text-sm leading-6 text-text-gray">{{ $job->deskripsi }}</p>
                </div>

                @if($job->kriteria)
                <div>
                    <h4 class="text-sm font-semibold text-text-dark">Syarat / Kriteria</h4>
                    <p class="mt-2 text-sm leading-6 text-text-gray whitespace-pre-line">{{ $job->kriteria }}</p>
                </div>
                @endif
            </div>
        </x-card>

        <x-card>
            <x-slot:header>
                <div class="flex items-center justify-between gap-3">
                    <h3 class="text-base font-semibold text-text-dark">Pelamar Terbaru</h3>
                    <a href="{{ url('/penyedia/lowongan/'.$job->id.'/pelamar') }}" class="text-sm font-medium text-primary">Lihat semua</a>
                </div>
            </x-slot:header>

            <div class="space-y-3">
                @forelse($latestApplications as $application)
                    <div class="rounded-md border border-border-color p-3">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-medium text-text-dark">{{ $application->pelamar->name ?? '-' }}</p>
                                <p class="mt-1 text-xs text-text-gray">{{ $application->created_at->diffForHumans() }}</p>
                            </div>
                            <x-status-badge :status="$application->status" />
                        </div>
                    </div>
                @empty
                    <x-empty-state title="Belum ada pelamar" description="Pelamar terbaru akan tampil di sini." />
                @endforelse
            </div>
        </x-card>
    </div>
</div>

<x-confirm-modal id="close-job" title="Tutup Lowongan" message="Tutup lowongan ini agar tidak menerima pelamar baru?" confirmText="Tutup Lowongan" type="primary" />
@endsection
