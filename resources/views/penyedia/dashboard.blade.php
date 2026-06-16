@extends('layouts.penyedia')
@section('title', 'Dashboard Penyedia - Partimeku')
@section('page_title', 'Dashboard')

@section('content')

@if($user->status === 'pending')
<div class="bg-warning/10 border-l-4 border-warning p-4 rounded-md mb-6 flex items-start gap-3">
    <i class="fa-solid fa-triangle-exclamation text-warning mt-0.5"></i>
    <div>
        <h3 class="text-sm font-bold text-text-dark">Akun Anda sedang dalam proses verifikasi</h3>
        <p class="text-xs text-text-gray mt-1">Anda sudah dapat melengkapi profil usaha, namun lowongan yang Anda buat tidak akan tayang ke publik sebelum akun diverifikasi oleh Admin. Proses ini memakan waktu maksimal 2x24 jam.</p>
    </div>
</div>
@endif

<div class="space-y-6">

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-card>
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-full bg-success/10 text-success flex items-center justify-center text-xl shrink-0 mr-4">
                    <i class="fa-solid fa-briefcase"></i>
                </div>
                <div>
                    <p class="text-xs font-medium text-text-gray uppercase tracking-wider">Lowongan Aktif</p>
                    <p class="text-2xl font-bold text-text-dark">{{ $stats['jobs_aktif'] }}</p>
                </div>
            </div>
        </x-card>
        
        <x-card>
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-full bg-warning/10 text-warning flex items-center justify-center text-xl shrink-0 mr-4">
                    <i class="fa-solid fa-hourglass-half"></i>
                </div>
                <div>
                    <p class="text-xs font-medium text-text-gray uppercase tracking-wider">Menunggu Review</p>
                    <p class="text-2xl font-bold text-text-dark">{{ $stats['jobs_menunggu'] }}</p>
                </div>
            </div>
        </x-card>

        <x-card>
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-full bg-primary/10 text-primary flex items-center justify-center text-xl shrink-0 mr-4">
                    <i class="fa-solid fa-file-lines"></i>
                </div>
                <div>
                    <p class="text-xs font-medium text-text-gray uppercase tracking-wider">Lamaran Masuk</p>
                    <p class="text-2xl font-bold text-text-dark">{{ $stats['lamaran_masuk'] }}</p>
                </div>
            </div>
        </x-card>

        <x-card>
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-full bg-info/10 text-info flex items-center justify-center text-xl shrink-0 mr-4">
                    <i class="fa-solid fa-user-check"></i>
                </div>
                <div>
                    <p class="text-xs font-medium text-text-gray uppercase tracking-wider">Pelamar Diterima</p>
                    <p class="text-2xl font-bold text-text-dark">{{ $stats['lamaran_diterima'] }}</p>
                </div>
            </div>
        </x-card>
    </div>


    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Lowongan Terbaru -->
        <x-card class="p-0 shadow-sm overflow-hidden flex flex-col h-full border-border-color">
            <x-slot name="header">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold text-text-dark">Lowongan Terbaru Anda</h3>
                    <a href="{{ url('/penyedia/jobs') }}" class="text-sm text-primary font-medium hover:underline">Lihat Semua</a>
                </div>
            </x-slot>
            <div class="p-0">
                <x-table class="!border-0">
                    <x-slot name="thead">
                        <tr>
                            <th class="px-4 py-3 bg-surface border-y border-border-color">Lowongan</th>
                            <th class="px-4 py-3 bg-surface border-y border-border-color text-center">Status</th>
                        </tr>
                    </x-slot>
                    @forelse($recent_jobs as $job)
                        <tr class="border-b border-border-color last:border-0 hover:bg-surface">
                            <td class="px-4 py-3">
                                <div class="font-medium text-sm text-text-dark line-clamp-1"><a href="{{ url('/penyedia/jobs/'.$job['id']) }}" class="hover:text-primary">{{ $job['title'] }}</a></div>
                                <div class="text-xs text-text-gray">{{ \Carbon\Carbon::parse($job['created_at'])->diffForHumans() }}</div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <x-status-badge :status="$job['status']" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-4 py-6 text-center text-sm text-text-gray">Belum ada lowongan.</td>
                        </tr>
                    @endforelse
                </x-table>
            </div>
        </x-card>

        <!-- Lamaran Terbaru -->
        <x-card class="p-0 shadow-sm overflow-hidden flex flex-col h-full border-border-color">
            <x-slot name="header">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold text-text-dark">Lamaran Masuk Terbaru</h3>
                    <a href="{{ url('/penyedia/applications') }}" class="text-sm text-primary font-medium hover:underline">Lihat Semua</a>
                </div>
            </x-slot>
            <div class="p-0">
                <x-table class="!border-0">
                    <x-slot name="thead">
                        <tr>
                            <th class="px-4 py-3 bg-surface border-y border-border-color">Pelamar</th>
                            <th class="px-4 py-3 bg-surface border-y border-border-color">Lowongan</th>
                            <th class="px-4 py-3 bg-surface border-y border-border-color text-center">Status</th>
                        </tr>
                    </x-slot>
                    @forelse($recent_applications as $app)
                        <tr class="border-b border-border-color last:border-0 hover:bg-surface">
                            <td class="px-4 py-3">
                                <div class="font-medium text-sm text-text-dark">{{ $app['student_name'] }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-xs text-text-gray line-clamp-1">{{ $app['job_title'] }}</div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <x-status-badge :status="$app['status']" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-sm text-text-gray">Belum ada lamaran masuk.</td>
                        </tr>
                    @endforelse
                </x-table>
            </div>
        </x-card>

    </div>

    <!-- Chart Placeholder -->
    <x-card class="p-0 border-border-color shadow-sm">
        <x-slot name="header">
            <h3 class="font-bold text-text-dark">Statistik Lamaran (6 Bulan Terakhir)</h3>
        </x-slot>
        <div class="p-6">
            <div class="flex items-end justify-between h-48 gap-2">
                <!-- Bar Dummy -->
                @foreach([12, 19, 15, 25, 22, 30] as $idx => $height)
                    <div class="flex flex-col items-center flex-1 group">
                        <div class="w-full bg-primary/20 rounded-t-md relative flex items-end justify-center group-hover:bg-primary/30 transition-colors" style="height: 100%;">
                            <div class="w-full bg-primary rounded-t-md transition-all duration-500" style="height: {{ $height * 3 }}%;"></div>
                            <span class="absolute -top-6 text-xs font-bold text-text-dark opacity-0 group-hover:opacity-100 transition-opacity">{{ $height }}</span>
                        </div>
                        <span class="text-xs text-text-gray mt-2">{{ \Carbon\Carbon::now()->subMonths(5 - $idx)->format('M') }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </x-card>

</div>
@endsection
