@extends('layouts.admin')

@section('title', 'Verifikasi Lowongan - Admin Partimeku')
@section('page_title', 'Verifikasi Lowongan')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="rounded-md bg-green-50 p-4 border border-green-200">
            <p class="text-sm font-medium text-green-800"><i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}</p>
        </div>
    @endif

    <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-medium text-primary">Verifikasi Lowongan</p>
            <h2 class="mt-1 text-2xl font-semibold text-text-dark">Lowongan Menunggu Review</h2>
            <p class="mt-1 text-sm text-text-gray">Tinjau data pekerjaan sebelum lowongan tampil ke mahasiswa.</p>
        </div>
        <x-badge color="warning">{{ $pendingJobs->count() }} lowongan pending</x-badge>
    </div>

    <x-card>
        <form method="GET" action="{{ route('admin.verifikasi.lowongan') }}" class="grid gap-3 md:grid-cols-[1fr_220px_auto]">
            <label class="block text-sm font-medium text-text-dark">
                Search lowongan
                <x-input name="search" value="{{ request('search') }}" class="mt-2" type="search" placeholder="Cari judul lowongan atau penyedia" />
            </label>
            <label class="block text-sm font-medium text-text-dark">
                Filter status
                <x-select name="status" class="mt-2" onchange="this.form.submit()">
                    <option value="">Semua status</option>
                    <option value="menunggu_review" {{ request('status') == 'menunggu_review' ? 'selected' : '' }}>Menunggu Review</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </x-select>
            </label>
            <div class="flex items-end gap-2">
                <button type="submit" class="rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-blue-900">
                    <i class="fa-solid fa-search mr-1"></i> Cari
                </button>
                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('admin.verifikasi.lowongan') }}" class="text-sm text-danger hover:underline whitespace-nowrap">
                        <i class="fa-solid fa-xmark mr-1"></i> Reset
                    </a>
                @endif
            </div>
        </form>
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
                            <form method="POST" action="{{ route('admin.jobs.status', $job['id']) }}" class="inline">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="aktif">
                                <button type="submit" onclick="return confirm('Approve lowongan ini?')" class="rounded-md bg-success px-3 py-1.5 text-xs font-medium text-white hover:bg-green-700">Approve</button>
                            </form>
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
                        @if(trim($requirement))
                        <li class="flex gap-2">
                            <i class="fa-solid fa-check mt-1 text-success"></i>
                            <span>{{ $requirement }}</span>
                        </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
        <x-slot:footer>
            <button type="button" onclick="openModal('job-reject-{{ $job['id'] }}'); closeModal('job-detail-{{ $job['id'] }}')" class="mt-3 inline-flex w-full justify-center rounded-md bg-danger px-4 py-2 text-sm font-medium text-white hover:bg-red-700 sm:ml-3 sm:mt-0 sm:w-auto">Reject</button>
            <form method="POST" action="{{ route('admin.jobs.status', $job['id']) }}" class="inline">
                @csrf @method('PUT')
                <input type="hidden" name="status" value="aktif">
                <button type="submit" onclick="return confirm('Approve lowongan ini?')" class="inline-flex w-full justify-center rounded-md bg-success px-4 py-2 text-sm font-medium text-white hover:bg-green-700 sm:w-auto">Approve</button>
            </form>
        </x-slot:footer>
    </x-modal>

    <x-modal id="job-reject-{{ $job['id'] }}" title="Tolak Lowongan">
        <form method="POST" action="{{ route('admin.jobs.status', $job['id']) }}">
            @csrf @method('PUT')
            <input type="hidden" name="status" value="ditolak">
            <div class="space-y-4">
                <p class="text-sm text-text-gray">Masukkan alasan penolakan untuk lowongan {{ $job['title'] }}.</p>
                <label class="block text-sm font-medium text-text-dark">Alasan reject<x-textarea name="reason" rows="4" class="mt-2" placeholder="Contoh: Deskripsi pekerjaan kurang lengkap."></x-textarea></label>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal('job-reject-{{ $job['id'] }}')" class="rounded-md border border-border-color bg-white px-4 py-2 text-sm font-medium text-text-dark hover:bg-surface">Batal</button>
                    <button type="submit" class="rounded-md bg-danger px-4 py-2 text-sm font-medium text-white hover:bg-red-700">Tolak Lowongan</button>
                </div>
            </div>
        </form>
    </x-modal>
@endforeach

@push('scripts')
<script>
    function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
    function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
</script>
@endpush
@endsection
