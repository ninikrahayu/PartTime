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

    @if(session('success'))
        <div class="rounded-md bg-green-50 p-4 border border-green-200">
            <p class="text-sm font-medium text-green-800"><i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}</p>
        </div>
    @endif

    <x-card>
        <form method="GET" action="{{ route('penyedia.jobs.index') }}" class="grid gap-3 lg:grid-cols-[1fr_220px_220px_auto]">
            <label class="block text-sm font-medium text-text-dark">
                Search lowongan
                <x-input name="search" type="search" class="mt-2" placeholder="Cari judul, lokasi, atau jadwal" value="{{ request('search') }}" />
            </label>
            <label class="block text-sm font-medium text-text-dark">
                Filter status
                <x-select name="status" class="mt-2">
                    <option value="">Semua status</option>
                    @foreach($jobStatuses as $status)
                        <option value="{{ $status['value'] }}" {{ request('status') == $status['value'] ? 'selected' : '' }}>{{ $status['label'] }}</option>
                    @endforeach
                </x-select>
            </label>
            <label class="block text-sm font-medium text-text-dark">
                Filter kategori
                <x-select name="kategori" class="mt-2">
                    <option value="">Semua kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->name }}" {{ request('kategori') == $category->name ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </x-select>
            </label>
            <div class="flex items-end">
                <x-button type="submit" class="w-full h-[42px]">Filter</x-button>
            </div>
        </form>
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
                    <td class="font-medium text-text-dark">{{ $job->judul }}</td>
                    <td><x-badge color="secondary">{{ $job->category ?? 'Umum' }}</x-badge></td>
                    <td>{{ $job->lokasi }}</td>
                    <td>
                        @if($job->gaji)
                            Rp {{ number_format($job->gaji, 0, ',', '.') }}
                            <div class="text-xs text-text-gray">{{ $job->salary_type ?? $job->shift }}</div>
                        @else
                            <span class="text-text-gray text-sm">-</span>
                        @endif
                    </td>
                    <td>{{ $job->quota ?? '-' }}</td>
                    <td>{{ $job->lamarans_count }}</td>
                    <td><x-status-badge :status="$job->status" /></td>
                    <td>{{ $job->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="flex justify-end gap-2">
                            <a href="{{ url('/penyedia/jobs/'.$job->id) }}" class="text-text-gray hover:text-primary" title="Detail">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ url('/penyedia/jobs/'.$job->id.'/edit') }}" class="text-text-gray hover:text-info" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <button type="button" onclick="openModal('close-job-{{ $job->id }}')" class="text-text-gray hover:text-warning" title="Tutup">
                                <i class="fa-solid fa-lock"></i>
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
            <div class="p-4 border-t border-border-color">
                {{ $jobs->links() }}
            </div>
        </div>
    </x-card>
</div>

@foreach($jobs as $job)
    <x-confirm-modal
        id="close-job-{{ $job->id }}"
        title="Tutup Lowongan"
        message="Tutup lowongan {{ $job->judul }}? Lowongan tidak akan menerima pelamar baru."
        confirmText="Tutup Lowongan"
        type="primary"
    />
@endforeach
@endsection
