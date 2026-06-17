@extends('layouts.admin')
@section('title', 'Manajemen Lowongan - Admin Partimeku')
@section('page_title', 'Manajemen Lowongan')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="rounded-md bg-green-50 p-4 border border-green-200">
            <p class="text-sm font-medium text-green-800"><i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}</p>
        </div>
    @endif
    <!-- Action Bar -->
    <form method="GET" action="{{ route('admin.jobs.index') }}" class="flex flex-col sm:flex-row justify-between gap-4">
        <div class="flex flex-col sm:flex-row gap-4 flex-1 items-center">
            <x-search-input name="search" value="{{ request('search') }}" placeholder="Cari judul lowongan..." class="w-full sm:w-64" />
            <x-select name="category" class="w-full sm:w-40" onchange="this.form.submit()">
                <option value="">Kategori</option>
                <option value="Barista" {{ request('category') == 'Barista' ? 'selected' : '' }}>Barista</option>
                <option value="Kasir" {{ request('category') == 'Kasir' ? 'selected' : '' }}>Kasir</option>
                <option value="Waiter" {{ request('category') == 'Waiter' ? 'selected' : '' }}>Waiter</option>
                <option value="Admin" {{ request('category') == 'Admin' ? 'selected' : '' }}>Admin</option>
            </x-select>
            <x-select name="status" class="w-full sm:w-40" onchange="this.form.submit()">
                <option value="">Status</option>
                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="menunggu_review" {{ request('status') == 'menunggu_review' ? 'selected' : '' }}>Menunggu Review</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </x-select>

            @if(request()->hasAny(['search', 'category', 'status']) && (request('search') != '' || request('category') != '' || request('status') != ''))
                <a href="{{ route('admin.jobs.index') }}" class="text-sm text-danger hover:underline whitespace-nowrap">
                    <i class="fa-solid fa-xmark mr-1"></i> Reset Filter
                </a>
            @endif
        </div>
        <div class="flex gap-2">
            <button type="submit" class="hidden">Search</button>
            <a href="{{ route('admin.jobs.export.xls') }}" class="inline-flex items-center rounded-md bg-success border border-transparent px-4 py-2 text-sm font-medium text-white shadow-md hover:bg-green-700 focus:ring-2 focus:ring-success/50 transition-all">
                <i class="fa-solid fa-file-excel mr-2"></i> Export XLS
            </a>
            <a href="{{ route('admin.jobs.export.pdf') }}" class="inline-flex items-center rounded-md bg-danger border border-transparent px-4 py-2 text-sm font-medium text-white shadow-md hover:bg-red-700 focus:ring-2 focus:ring-danger/50 transition-all">
                <i class="fa-solid fa-file-pdf mr-2"></i> Export PDF
            </a>
        </div>
    </form>
    
    <div class="text-sm text-text-gray">
        Menampilkan {{ $jobs->firstItem() ?? 0 }} - {{ $jobs->lastItem() ?? 0 }} dari {{ $jobs->total() }} data
    </div>

    <!-- Table -->
    <x-card class="p-0 border-none shadow-sm overflow-hidden">
        <x-table>
            <x-slot name="thead">
                <tr>
                    <th scope="col" class="px-6 py-3">Lowongan</th>
                    <th scope="col" class="px-6 py-3">Penyedia</th>
                    <th scope="col" class="px-6 py-3">Kategori</th>
                    <th scope="col" class="px-6 py-3">Gaji</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </x-slot>
            @foreach($jobs as $job)
            <tr class="bg-white border-b border-border-color hover:bg-surface">
                <td class="px-6 py-4">
                    <div class="font-medium text-text-dark line-clamp-1 max-w-[200px]" title="{{ $job['title'] }}">{{ $job['title'] }}</div>
                    <div class="text-xs text-text-gray">{{ $job['location'] }}</div>
                </td>
                <td class="px-6 py-4 text-sm text-text-gray">
                    {{ $job['provider_name'] }}
                </td>
                <td class="px-6 py-4">
                    <x-badge color="info">{{ $job['category'] }}</x-badge>
                </td>
                <td class="px-6 py-4 text-sm text-text-gray">
                    Rp {{ number_format($job['salary'], 0, ',', '.') }}
                </td>
                <td class="px-6 py-4">
                    <x-status-badge :status="$job['status']" />
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex justify-end gap-2">
                        <a href="{{ url('/admin/jobs/'.$job['id']) }}" class="text-text-gray hover:text-primary transition-colors" title="Detail">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <button onclick="openStatusModal({{ $job['id'] }}, '{{ $job['status'] }}')" class="text-text-gray hover:text-info transition-colors" title="Ubah Status">
                            <i class="fa-solid fa-rotate"></i>
                        </button>
                        <form method="POST" action="{{ route('admin.jobs.destroy', $job['id']) }}" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus lowongan ini permanen?')" class="text-text-gray hover:text-danger transition-colors" title="Hapus">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </x-table>
        <div class="p-4 border-t border-border-color">
            {{ $jobs->appends(request()->query())->links() }}
        </div>
    </x-card>
</div>

<!-- Modal Ubah Status -->
<x-modal id="modal-status" title="Ubah Status Lowongan">
    <form id="status-form" action="" method="POST">
        @csrf @method('PUT')
        <div class="space-y-4">
            <p class="text-sm text-text-gray">Pilih status terbaru untuk lowongan ini.</p>
            <x-select id="edit-status" name="status">
                <option value="aktif">Aktif (Approved)</option>
                <option value="menunggu_review">Menunggu Review</option>
                <option value="ditolak">Ditolak</option>
                <option value="selesai">Selesai / Ditutup</option>
                <option value="nonaktif">Nonaktif</option>
            </x-select>
        </div>
        <div class="mt-5 flex justify-end gap-2">
            <button type="button" class="inline-flex justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-text-dark shadow-sm ring-1 ring-inset ring-border-color hover:bg-surface" onclick="closeModal('modal-status')">Batal</button>
            <x-button type="submit">Simpan</x-button>
        </div>
    </form>
</x-modal>

@push('scripts')
<script>
    function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
    function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
    function openStatusModal(id, status) {
        document.getElementById('status-form').action = `/admin/jobs/${id}/status`;
        document.getElementById('edit-status').value = status;
        openModal('modal-status');
    }
</script>
@endpush
@endsection
