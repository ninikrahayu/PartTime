@extends('layouts.admin')
@section('title', 'Manajemen Lowongan - Admin Partimeku')
@section('page_title', 'Manajemen Lowongan')

@section('content')
<div class="space-y-6">
    <!-- Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between gap-4">
        <div class="flex flex-col sm:flex-row gap-4 flex-1">
            <x-search-input placeholder="Cari judul lowongan..." class="w-full sm:w-64" />
            <x-select class="w-full sm:w-40">
                <option value="">Kategori</option>
                <option value="1">Barista</option>
                <option value="2">Kasir</option>
            </x-select>
            <x-select class="w-full sm:w-40">
                <option value="">Status</option>
                <option value="aktif">Aktif</option>
                <option value="menunggu_review">Menunggu Review</option>
                <option value="selesai">Selesai</option>
            </x-select>
        </div>
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
                        <button onclick="openModal('modal-status')" class="text-text-gray hover:text-info transition-colors" title="Ubah Status">
                            <i class="fa-solid fa-rotate"></i>
                        </button>
                        <button onclick="openModal('modal-delete')" class="text-text-gray hover:text-danger transition-colors" title="Hapus">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </x-table>
        <x-pagination />
    </x-card>
</div>

<!-- Modal Ubah Status -->
<x-modal id="modal-status" title="Ubah Status Lowongan">
    <div class="space-y-4">
        <p class="text-sm text-text-gray">Pilih status terbaru untuk lowongan ini.</p>
        <x-select>
            <option value="aktif">Aktif (Approved)</option>
            <option value="menunggu_review">Menunggu Review</option>
            <option value="ditolak">Ditolak</option>
            <option value="selesai">Selesai / Ditutup</option>
        </x-select>
    </div>
    <x-slot name="footer">
        <x-button onclick="closeModal('modal-status'); showToast('Status diperbarui', 'success')">Simpan</x-button>
        <button type="button" class="ml-2 inline-flex justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-text-dark shadow-sm ring-1 ring-inset ring-border-color hover:bg-surface" onclick="closeModal('modal-status')">Batal</button>
    </x-slot>
</x-modal>

<!-- Modal Delete -->
<x-confirm-modal id="modal-delete" title="Hapus Lowongan" message="Apakah Anda yakin ingin menghapus lowongan ini?" confirmText="Hapus" />

@push('scripts')
<script>
    function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
    function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
    function confirmAction(id) { closeModal(id); showToast('Berhasil dihapus', 'success'); }
</script>
@endpush
@endsection
