@extends('layouts.admin')

@section('title', 'Dashboard Admin - Partimeku')
@section('page_title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-medium text-primary">Ringkasan Platform</p>
            <h2 class="mt-1 text-2xl font-semibold text-text-dark">Overview Platform</h2>
            <p class="mt-1 text-sm text-text-gray">Pantau statistik pengguna, verifikasi, lowongan, dan status lamaran secara real-time.</p>
        </div>
        <a href="{{ url('/admin/reports') }}" class="inline-flex items-center justify-center rounded-md border border-border-color bg-white px-4 py-2 text-sm font-medium text-text-dark hover:bg-surface">
            <i class="fa-solid fa-chart-pie mr-2 text-primary"></i>
            Lihat Laporan
        </a>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach($summaryCards as $card)
            <x-dashboard-summary-card
                :label="$card['label']"
                :value="$card['value']"
                :icon="$card['icon']"
                :trend="$card['trend'] ?? null"
            />
        @endforeach
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach($additionalStats as $stat)
            <div class="rounded-md border border-border-color bg-white p-4 shadow-sm">
                <p class="text-sm text-text-gray">{{ $stat['label'] }}</p>
                <p class="mt-2 text-2xl font-semibold text-text-dark">{{ $stat['value'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid gap-6 xl:grid-cols-2">
        <x-chart-card 
            id="chart-lowongan" 
            title="Tren Lowongan" 
            subtitle="Grafik penambahan lowongan selama 6 bulan terakhir"
            chart-id="adminJobsChart"
        />
        <x-chart-card 
            id="chart-pelamar" 
            title="Tren Pelamar" 
            subtitle="Grafik statistik pelamar selama 6 bulan terakhir"
            chart-id="adminApplicantsChart"
        />
    </div>

    <div class="grid gap-6 xl:grid-cols-3">
        <x-card>
            <x-slot:header>
                <div class="flex items-center justify-between gap-3">
                    <h3 class="text-base font-semibold text-text-dark">Lamaran Terbaru</h3>
                    <a href="{{ url('/admin/applications') }}" class="text-sm font-medium text-primary">Lihat semua</a>
                </div>
            </x-slot:header>

            <div class="space-y-3">
                @forelse($recentApplications as $application)
                    <div class="rounded-md border border-border-color p-3">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-medium text-text-dark">{{ $application['student_name'] }}</p>
                                <p class="mt-1 truncate text-xs text-text-gray">{{ $application['job_title'] }}</p>
                            </div>
                            <x-status-badge :status="$application['status']" class="shrink-0" />
                        </div>
                        <p class="mt-2 text-xs text-text-gray">{{ $application['applied_at'] }}</p>
                    </div>
                @empty
                    <x-empty-state title="Belum ada lamaran" description="Lamaran terbaru akan tampil di sini." />
                @endforelse
            </div>
        </x-card>

        <x-card>
            <x-slot:header>
                <div class="flex items-center justify-between gap-3">
                    <h3 class="text-base font-semibold text-text-dark">Akun Menunggu Verifikasi</h3>
                    <a href="{{ url('/admin/verifikasi-akun') }}" class="text-sm font-medium text-primary">Tinjau</a>
                </div>
            </x-slot:header>

            <div class="space-y-3">
                @forelse($pendingAccounts as $account)
                    <div class="rounded-md border border-border-color p-3">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-medium text-text-dark">{{ $account['name'] }}</p>
                                <p class="mt-1 text-xs capitalize text-text-gray">{{ $account['role'] }} - {{ $account['created_at'] }}</p>
                            </div>
                            <x-status-badge :status="$account['verification_status']" class="shrink-0" />
                        </div>
                    </div>
                @empty
                    <x-empty-state title="Tidak ada akun pending" description="Semua akun sudah ditinjau." />
                @endforelse
            </div>
        </x-card>

        <x-card>
            <x-slot:header>
                <div class="flex items-center justify-between gap-3">
                    <h3 class="text-base font-semibold text-text-dark">Lowongan Menunggu Review</h3>
                    <a href="{{ url('/admin/verifikasi-lowongan') }}" class="text-sm font-medium text-primary">Review</a>
                </div>
            </x-slot:header>

            <div class="space-y-3">
                @forelse($pendingJobs as $job)
                    <div class="rounded-md border border-border-color p-3">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-medium text-text-dark">{{ $job['title'] }}</p>
                                <p class="mt-1 truncate text-xs text-text-gray">{{ $job['provider_name'] }} - {{ $job['category'] }}</p>
                            </div>
                            <x-status-badge :status="$job['status']" class="shrink-0" />
                        </div>
                        <p class="mt-2 text-xs text-text-gray">Dibuat {{ $job['created_at'] }}</p>
                    </div>
                @empty
                    <x-empty-state title="Tidak ada lowongan pending" description="Semua lowongan sudah ditinjau." />
                @endforelse
            </div>
        </x-card>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chartColor = '#1E3A8A';
        const borderColor = '#E5E7EB';
        const textColor = '#6B7280';

        function createLineChart(canvasId, labels, data, label) {
            const canvas = document.getElementById(canvasId);

            if (!canvas || typeof Chart === 'undefined') {
                return;
            }

            new Chart(canvas, {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                        label,
                        data,
                        borderColor: chartColor,
                        backgroundColor: 'rgba(30, 58, 138, 0.08)',
                        borderWidth: 2,
                        pointBackgroundColor: chartColor,
                        pointRadius: 3,
                        tension: 0.35,
                        fill: true,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                    scales: {
                        x: {
                            grid: {
                                color: borderColor,
                            },
                            ticks: {
                                color: textColor,
                            },
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: borderColor,
                            },
                            ticks: {
                                color: textColor,
                                precision: 0,
                            },
                        },
                    },
                },
            });
        }

        createLineChart(
            'adminJobsChart',
            @json($charts['jobs_per_month']['labels']),
            @json($charts['jobs_per_month']['data']),
            'Lowongan'
        );

        createLineChart(
            'adminApplicantsChart',
            @json($charts['applicants_per_month']['labels']),
            @json($charts['applicants_per_month']['data']),
            'Pelamar'
        );
    });
</script>
@endpush
