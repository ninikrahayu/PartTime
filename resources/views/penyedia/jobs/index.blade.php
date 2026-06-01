@extends('layouts.penyedia')

@section('title', 'Daftar Lowongan - Penyedia Partimeku')
@section('page_title', 'Daftar Lowongan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-sm font-medium text-primary">Manajemen Lowongan</p>
            <h2 class="mt-1 text-2xl font-semibold text-text-dark">Daftar Lowongan</h2>
            <p class="mt-1 text-sm text-text-gray">Kelola lowongan yang dibuat oleh akun penyedia saat ini.</p>
        </div>
        <a href="{{ url('/penyedia/jobs/create') }}" class="inline-flex items-center justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-blue-900">
            <i class="fa-solid fa-plus mr-2"></i>Tambah Lowongan
        </a>
    </div>

    <x-card>
        <div class="grid gap-3 lg:grid-cols-[1fr_220px_220px]">
            <label class="block text-sm font-medium text-text-dark">
                Search lowongan
                <x-input type="search" class="mt-2" placeholder="Cari judul, lokasi, atau jadwal" />
            </label>
            <label class="block text-sm font-medium text-text-dark">
                Filter status
                <x-select class="mt-2">
                    <option value="">Semua status</option>
                    @foreach($jobStatuses as $status)
                        <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                    @endforeach
                </x-select>
            </label>
            <label class="block text-sm font-medium text-text-dark">
                Filter kategori
                <x-select class="mt-2">
                    <option value="">Semua kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                    @endforeach
                </x-select>
            </label>
        </div>
    </x-card>

    <x-card>
        <x-table>
            <x-slot:thead>
                <tr>
                    <th>Nama Pekerjaan</th>
                    <th>Kategori</th>
                    <th>Lokasi</th>
                    <th>Gaji / Upah</th>
                    <th>Kuota</th>
                    <th>Pelamar</th>
                    <th>Status</th>
                    <th>Tanggal Dibuat</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </x-slot:thead>
            @forelse($jobs as $job)
                <tr>
                    <td class="font-medium text-text-dark">{{ $job['title'] }}</td>
                    <td><x-badge color="secondary">{{ $job['category'] }}</x-badge></td>
                    <td>{{ $job['location'] }}</td>
                    <td>
                        Rp {{ number_format($job['salary'], 0, ',', '.') }}
                        <div class="text-xs text-text-gray">{{ $job['salary_type'] }}</div>
                    </td>
                    <td>{{ $job['quota'] }}</td>
                    <td>{{ $job['applicants_count'] }}</td>
                    <td><x-status-badge :status="$job['status']" /></td>
                    <td>{{ $job['created_at'] }}</td>
                    <td>
                        <div class="flex justify-end gap-2">
                            <a href="{{ url('/penyedia/jobs/'.$job['id']) }}" class="text-text-gray hover:text-primary" title="Detail">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ url('/penyedia/jobs/'.$job['id'].'/edit') }}" class="text-text-gray hover:text-info" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <button type="button" onclick="openModal('close-job-{{ $job['id'] }}')" class="text-text-gray hover:text-warning" title="Tutup">
                                <i class="fa-solid fa-lock"></i>
                            </button>
                            <button type="button" onclick="openModal('delete-job-{{ $job['id'] }}')" class="text-text-gray hover:text-danger" title="Hapus">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">
                        <x-empty-state title="Belum ada lowongan" description="Lowongan yang dibuat akan tampil di sini." />
                    </td>
                </tr>
            @endforelse
        </x-table>
        <div class="mt-4">
            <x-pagination />
        </div>
    </x-card>
</div>

@foreach($jobs as $job)
    <x-confirm-modal
        id="close-job-{{ $job['id'] }}"
        title="Tutup Lowongan"
        message="Tutup lowongan {{ $job['title'] }}? Lowongan tidak akan menerima pelamar baru."
        confirmText="Tutup Lowongan"
        type="primary"
    />
    <x-confirm-modal
        id="delete-job-{{ $job['id'] }}"
        title="Hapus Lowongan"
        message="Hapus lowongan {{ $job['title'] }} dari daftar dummy?"
        confirmText="Hapus"
        type="danger"
    />
@endforeach
@endsection
