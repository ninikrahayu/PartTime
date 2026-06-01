@extends('layouts.admin')

@section('title', 'Verifikasi Lowongan - Admin Partimeku')
@section('page_title', 'Verifikasi Lowongan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-medium text-primary">Verifikasi Lowongan</p>
            <h2 class="mt-1 text-2xl font-semibold text-text-dark">Lowongan Menunggu Review</h2>
            <p class="mt-1 text-sm text-text-gray">Tinjau data pekerjaan sebelum lowongan tampil ke mahasiswa.</p>
        </div>
        <x-badge color="warning">{{ $pendingJobs->count() }} lowongan pending</x-badge>
    </div>

    <x-card>
        <div class="grid gap-3 lg:grid-cols-[1fr_220px_220px]">
            <label class="block text-sm font-medium text-text-dark">
                Search lowongan
                <x-input class="mt-2" type="search" placeholder="Cari judul, penyedia, atau lokasi" />
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
            <label class="block text-sm font-medium text-text-dark">
                Filter status
                <x-select class="mt-2">
                    <option value="">Semua status</option>
                    @foreach($jobStatuses as $status)
                        <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                    @endforeach
                </x-select>
            </label>
        </div>
    </x-card>

    <x-card>
        <x-table>
            <x-slot:thead>
                <tr>
                    <th>Lowongan</th>
                    <th>Penyedia</th>
                    <th>Kategori</th>
                    <th>Gaji</th>
                    <th>Kuota</th>
                    <th>Status</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </x-slot:thead>
            @forelse($pendingJobs as $job)
                <tr>
                    <td>
                        <div class="font-medium text-text-dark">{{ $job['title'] }}</div>
                        <div class="text-xs text-text-gray">{{ $job['location'] }}</div>
                    </td>
                    <td>{{ $job['provider_name'] }}</td>
                    <td>{{ $job['category'] }}</td>
                    <td>Rp {{ number_format($job['salary'], 0, ',', '.') }}<div class="text-xs text-text-gray">{{ $job['salary_type'] }}</div></td>
                    <td>{{ $job['quota'] }}</td>
                    <td><x-status-badge :status="$job['status']" /></td>
                    <td>
                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="openModal('job-detail-{{ $job['id'] }}')" class="rounded-md border border-border-color bg-white px-3 py-1.5 text-xs font-medium text-text-dark hover:bg-surface">Detail</button>
                            <button type="button" onclick="approveDummy('Lowongan berhasil disetujui.')" class="rounded-md bg-success px-3 py-1.5 text-xs font-medium text-white hover:bg-green-700">Approve</button>
                            <button type="button" onclick="openModal('job-reject-{{ $job['id'] }}')" class="rounded-md bg-danger px-3 py-1.5 text-xs font-medium text-white hover:bg-red-700">Reject</button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">
                        <x-empty-state title="Tidak ada lowongan pending" description="Lowongan yang menunggu review akan tampil di sini." />
                    </td>
                </tr>
            @endforelse
        </x-table>
    </x-card>
</div>

@foreach($pendingJobs as $job)
    <x-modal id="job-detail-{{ $job['id'] }}" title="Detail Verifikasi Lowongan">
        <div class="space-y-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-text-dark">{{ $job['title'] }}</h3>
                    <p class="mt-1 text-sm text-text-gray">{{ $job['provider_name'] }} - {{ $job['category'] }}</p>
                </div>
                <x-status-badge :status="$job['status']" class="shrink-0" />
            </div>

            <div class="grid gap-3 text-sm sm:grid-cols-2">
                <div><span class="text-text-gray">Lokasi</span><p class="font-medium text-text-dark">{{ $job['location'] }}</p></div>
                <div><span class="text-text-gray">Jadwal</span><p class="font-medium text-text-dark">{{ $job['schedule'] }}</p></div>
                <div><span class="text-text-gray">Gaji</span><p class="font-medium text-text-dark">Rp {{ number_format($job['salary'], 0, ',', '.') }} / {{ $job['salary_type'] }}</p></div>
                <div><span class="text-text-gray">Kuota</span><p class="font-medium text-text-dark">{{ $job['quota'] }} orang</p></div>
                <div><span class="text-text-gray">Mulai</span><p class="font-medium text-text-dark">{{ $job['start_date'] }}</p></div>
                <div><span class="text-text-gray">Batas Lamaran</span><p class="font-medium text-text-dark">{{ $job['deadline'] }}</p></div>
            </div>

            <div>
                <h4 class="text-sm font-semibold text-text-dark">Deskripsi Pekerjaan</h4>
                <p class="mt-2 text-sm leading-6 text-text-gray">{{ $job['description'] }}</p>
            </div>

            <div>
                <h4 class="text-sm font-semibold text-text-dark">Syarat Pekerjaan</h4>
                <ul class="mt-2 space-y-2 text-sm text-text-gray">
                    @foreach($job['requirements'] as $requirement)
                        <li class="flex gap-2">
                            <i class="fa-solid fa-check mt-1 text-success"></i>
                            <span>{{ $requirement }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <x-slot:footer>
            <button type="button" onclick="openModal('job-reject-{{ $job['id'] }}')" class="mt-3 inline-flex w-full justify-center rounded-md bg-danger px-4 py-2 text-sm font-medium text-white hover:bg-red-700 sm:ml-3 sm:mt-0 sm:w-auto">Reject</button>
            <button type="button" onclick="approveDummy('Lowongan berhasil disetujui.'); closeModal('job-detail-{{ $job['id'] }}')" class="inline-flex w-full justify-center rounded-md bg-success px-4 py-2 text-sm font-medium text-white hover:bg-green-700 sm:w-auto">Approve</button>
        </x-slot:footer>
    </x-modal>

    <x-modal id="job-reject-{{ $job['id'] }}" title="Tolak Lowongan">
        <div class="space-y-4">
            <p class="text-sm text-text-gray">Masukkan alasan penolakan untuk lowongan {{ $job['title'] }}.</p>
            <label class="block text-sm font-medium text-text-dark">Alasan reject<x-textarea rows="4" class="mt-2" placeholder="Contoh: Deskripsi pekerjaan kurang lengkap."></x-textarea></label>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal('job-reject-{{ $job['id'] }}')" class="rounded-md border border-border-color bg-white px-4 py-2 text-sm font-medium text-text-dark hover:bg-surface">Batal</button>
                <button type="button" onclick="rejectDummy('job-reject-{{ $job['id'] }}', 'Lowongan berhasil ditolak.')" class="rounded-md bg-danger px-4 py-2 text-sm font-medium text-white hover:bg-red-700">Tolak Lowongan</button>
            </div>
        </div>
    </x-modal>
@endforeach
@endsection
