@extends('layouts.admin')
@section('title', 'Manajemen Kategori - Admin Partimeku')
@section('page_title', 'Manajemen Kategori')

@section('content')
<div class="space-y-6">
    <!-- Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between gap-4">
        <div class="flex-1">
            <x-search-input placeholder="Cari kategori..." class="w-full sm:w-64" />
        </div>
        <div>
            <x-button onclick="openModal('modal-add')">
                <i class="fa-solid fa-plus mr-2"></i> Tambah Kategori
            </x-button>
        </div>
    </div>

    <!-- Table -->
    <x-card class="p-0 border-none shadow-sm overflow-hidden">
        <x-table>
            <x-slot name="thead">
                <tr>
                    <th scope="col" class="px-6 py-3">Nama Kategori</th>
                    <th scope="col" class="px-6 py-3 text-center">Jumlah Lowongan</th>
                    <th scope="col" class="px-6 py-3 text-center">Status</th>
                    <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </x-slot>
            @foreach($categories as $category)
            <tr class="bg-white border-b border-border-color hover:bg-surface">
                <td class="px-6 py-4 font-medium text-text-dark">
                    <i class="fa-solid fa-tags text-primary/60 mr-2"></i> {{ $category['name'] }}
                </td>
                <td class="px-6 py-4 text-center text-sm">
                    {{ $category['jobs_count'] ?? rand(5, 50) }}
                </td>
                <td class="px-6 py-4 text-center">
                    <x-status-badge status="aktif" />
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex justify-end gap-2">
                        <button onclick="showToast('Edit {{ $category['name'] }}', 'info')" class="text-text-gray hover:text-warning transition-colors" title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button onclick="showToast('Nonaktifkan {{ $category['name'] }}', 'warning')" class="text-text-gray hover:text-warning transition-colors" title="Nonaktifkan">
                            <i class="fa-solid fa-power-off"></i>
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

<!-- Modal Add -->
<x-modal id="modal-add" title="Tambah Kategori">
    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-text-dark mb-1">Nama Kategori</label>
            <x-input type="text" placeholder="Masukkan nama kategori" />
        </div>
        <div>
            <label class="block text-sm font-medium text-text-dark mb-1">Status</label>
            <x-select>
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
            </x-select>
        </div>
    </div>
    <x-slot name="footer">
        <x-button onclick="closeModal('modal-add'); showToast('Kategori ditambahkan', 'success')">Simpan</x-button>
        <button type="button" class="ml-2 inline-flex justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-text-dark shadow-sm ring-1 ring-inset ring-border-color hover:bg-surface" onclick="closeModal('modal-add')">Batal</button>
    </x-slot>
</x-modal>

<!-- Modal Delete -->
<x-confirm-modal id="modal-delete" title="Hapus Kategori" message="Apakah Anda yakin ingin menghapus kategori ini? Pastikan tidak ada lowongan yang terikat." confirmText="Hapus" />

@push('scripts')
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }
    function confirmAction(id) {
        closeModal(id);
        showToast('Berhasil dihapus', 'success');
    }
</script>
@endpush
@endsection
