@extends('layouts.admin')

@section('title', 'Laporan - Admin Partimeku')
@section('page_title', 'Laporan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-sm font-medium text-primary">Laporan Admin</p>
            <h2 class="mt-1 text-2xl font-semibold text-text-dark">Ringkasan Data Platform</h2>
            <p class="mt-1 text-sm text-text-gray">Pantau mahasiswa, penyedia, lowongan, lamaran, verifikasi, dan review dari dummy data.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <button type="button" onclick="showToast('Export PDF berhasil diproses.', 'success')" class="inline-flex items-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-blue-900">
                <i class="fa-solid fa-file-pdf mr-2"></i>Export PDF
            </button>
            <button type="button" onclick="showToast('Export Excel berhasil diproses.', 'success')" class="inline-flex items-center rounded-md border border-border-color bg-white px-4 py-2 text-sm font-medium text-text-dark hover:bg-surface">
                <i class="fa-solid fa-file-excel mr-2 text-success"></i>Export Excel
            </button>
            <button type="button" onclick="showToast('Perintah print dummy diproses.', 'info')" class="inline-flex items-center rounded-md border border-border-color bg-white px-4 py-2 text-sm font-medium text-text-dark hover:bg-surface">
                <i class="fa-solid fa-print mr-2 text-primary"></i>Print
            </button>
        </div>
    </div>

    <x-card>
        <div class="grid gap-3 md:grid-cols-2 xl:grid-cols-4">
            <label class="block text-sm font-medium text-text-dark">
                Tanggal mulai
                <x-input type="date" class="mt-2" value="2026-05-01" />
            </label>
            <label class="block text-sm font-medium text-text-dark">
                Tanggal akhir
                <x-input type="date" class="mt-2" value="2026-05-31" />
            </label>
            <label class="block text-sm font-medium text-text-dark">
                Role
                <x-select class="mt-2">
                    <option>Semua role</option>
                    <option>Admin</option>
                    <option>Mahasiswa</option>
                    <option>Penyedia</option>
                </x-select>
            </label>
            <label class="block text-sm font-medium text-text-dark">
                Status
                <x-select class="mt-2">
                    <option>Semua status</option>
                    @foreach(($statusOptions['verification'] ?? []) as $status)
                        <option>{{ $status['label'] }}</option>
                    @endforeach
                    @foreach(($statusOptions['job'] ?? []) as $status)
                        <option>{{ $status['label'] }}</option>
                    @endforeach
                    @foreach(($statusOptions['application'] ?? []) as $status)
                        <option>{{ $status['label'] }}</option>
                    @endforeach
                </x-select>
            </label>
            <label class="block text-sm font-medium text-text-dark md:col-span-2 xl:col-span-1">
                Kategori
                <x-select class="mt-2">
                    <option>Semua kategori</option>
                    @foreach($categories as $category)
                        <option>{{ $category['name'] }}</option>
                    @endforeach
                </x-select>
            </label>
            <div class="flex items-end md:col-span-2 xl:col-span-3">
                <button type="button" onclick="showToast('Filter laporan berhasil diterapkan.', 'success')" class="inline-flex w-full items-center justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-blue-900 sm:w-auto">
                    <i class="fa-solid fa-filter mr-2"></i>Terapkan Filter
                </button>
            </div>
        </div>
    </x-card>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-dashboard-summary-card label="Data Mahasiswa" :value="$summary['students']" icon="fa-user-graduate" />
        <x-dashboard-summary-card label="Data Penyedia" :value="$summary['providers']" icon="fa-building" />
        <x-dashboard-summary-card label="Data Lowongan" :value="$summary['jobs']" icon="fa-briefcase" />
        <x-dashboard-summary-card label="Data Lamaran" :value="$summary['applications']" icon="fa-file-signature" />
        <x-dashboard-summary-card label="Verifikasi Pending" :value="$summary['pending_verifications']" icon="fa-user-check" />
        <x-dashboard-summary-card label="Lowongan Aktif" :value="$summary['active_jobs']" icon="fa-circle-check" />
        <x-dashboard-summary-card label="Lowongan Selesai" :value="$summary['completed_jobs']" icon="fa-flag-checkered" />
        <x-dashboard-summary-card label="Total Review" :value="$summary['reviews']" icon="fa-star" />
    </div>

    <div class="grid gap-6 xl:grid-cols-2">
        <x-card>
            <x-slot:header>
                <h3 class="text-base font-semibold text-text-dark">Laporan Verifikasi Akun</h3>
            </x-slot:header>
            <x-table>
                <x-slot:thead>
                    <tr>
                        <th>Tipe</th>
                        <th>Menunggu</th>
                        <th>Terverifikasi</th>
                        <th>Ditolak</th>
                    </tr>
                </x-slot:thead>
                @foreach(($reports['verification_summary'] ?? []) as $row)
                    <tr>
                        <td class="font-medium text-text-dark">{{ $row['type'] }}</td>
                        <td>{{ $row['menunggu_verifikasi'] }}</td>
                        <td>{{ $row['terverifikasi'] }}</td>
                        <td>{{ $row['ditolak'] }}</td>
                    </tr>
                @endforeach
            </x-table>
        </x-card>

        <x-card>
            <x-slot:header>
                <h3 class="text-base font-semibold text-text-dark">Laporan Status Lowongan</h3>
            </x-slot:header>
            <x-table>
                <x-slot:thead>
                    <tr>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </x-slot:thead>
                @foreach(($reports['job_summary'] ?? []) as $row)
                    <tr>
                        <td><x-status-badge :status="$row['status']" /></td>
                        <td>{{ $row['total'] }}</td>
                    </tr>
                @endforeach
            </x-table>
        </x-card>

        <x-card>
            <x-slot:header>
                <h3 class="text-base font-semibold text-text-dark">Laporan Status Lamaran</h3>
            </x-slot:header>
            <x-table>
                <x-slot:thead>
                    <tr>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </x-slot:thead>
                @foreach(($reports['application_summary'] ?? []) as $row)
                    <tr>
                        <td><x-status-badge :status="$row['status']" /></td>
                        <td>{{ $row['total'] }}</td>
                    </tr>
                @endforeach
            </x-table>
        </x-card>

        <x-card>
            <x-slot:header>
                <h3 class="text-base font-semibold text-text-dark">Laporan Review</h3>
            </x-slot:header>
            <x-table>
                <x-slot:thead>
                    <tr>
                        <th>Jenis Review</th>
                        <th>Total</th>
                        <th>Rating Rata-rata</th>
                    </tr>
                </x-slot:thead>
                @foreach(($reports['review_summary'] ?? []) as $row)
                    <tr>
                        <td class="font-medium text-text-dark">{{ $row['type'] }}</td>
                        <td>{{ $row['total'] }}</td>
                        <td>
                            <span class="inline-flex items-center gap-1 text-text-dark">
                                <i class="fa-solid fa-star text-secondary"></i>{{ $row['average_rating'] }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </x-table>
        </x-card>
    </div>

    <x-card>
        <x-slot:header>
            <h3 class="text-base font-semibold text-text-dark">Data Lowongan Aktif dan Selesai</h3>
        </x-slot:header>
        <x-table>
            <x-slot:thead>
                <tr>
                    <th>Lowongan</th>
                    <th>Penyedia</th>
                    <th>Kategori</th>
                    <th>Pelamar</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                </tr>
            </x-slot:thead>
            @foreach($jobs->whereIn('status', ['aktif', 'selesai'])->take(8) as $job)
                <tr>
                    <td class="font-medium text-text-dark">{{ $job['title'] }}</td>
                    <td>{{ $job['provider_name'] }}</td>
                    <td>{{ $job['category'] }}</td>
                    <td>{{ $job['applicants_count'] }}</td>
                    <td><x-status-badge :status="$job['status']" /></td>
                    <td>{{ $job['created_at'] }}</td>
                </tr>
            @endforeach
        </x-table>
    </x-card>
</div>
@endsection
