@extends('layouts.admin')
@section('title', 'Manajemen Pengguna - Admin Partimeku')
@section('page_title', 'Manajemen Pengguna')

@section('content')
<div class="space-y-6">
    <!-- Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between gap-4">
        <div class="flex flex-col sm:flex-row gap-4 flex-1">
            <x-search-input placeholder="Cari nama atau email..." class="w-full sm:w-64" />
            <x-select class="w-full sm:w-48">
                <option value="">Semua Role</option>
                <option value="mahasiswa">Mahasiswa</option>
                <option value="penyedia">Penyedia</option>
            </x-select>
            <x-select class="w-full sm:w-48">
                <option value="">Semua Status</option>
                <option value="terverifikasi">Terverifikasi</option>
                <option value="menunggu_verifikasi">Menunggu</option>
                <option value="ditolak">Ditolak</option>
            </x-select>
        </div>
        <div>
            <x-button onclick="showToast('Form tambah pengguna dummy', 'info')">
                <i class="fa-solid fa-plus mr-2"></i> Tambah
            </x-button>
        </div>
    </div>

    <!-- Table -->
    <x-card class="p-0 border-none shadow-sm overflow-hidden">
        <x-table>
            <x-slot name="thead">
                <tr>
                    <th scope="col" class="px-6 py-3">Pengguna</th>
                    <th scope="col" class="px-6 py-3">Role</th>
                    <th scope="col" class="px-6 py-3">Tgl Daftar</th>
                    <th scope="col" class="px-6 py-3">Akun</th>
                    <th scope="col" class="px-6 py-3">Verifikasi</th>
                    <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </x-slot>
            @foreach($users as $user)
            <tr class="bg-white border-b border-border-color hover:bg-surface">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user['name']) }}&background=random&color=fff" alt="" class="w-8 h-8 rounded-full">
                        <div>
                            <div class="font-medium text-text-dark">{{ $user['name'] }}</div>
                            <div class="text-xs text-text-gray">{{ $user['email'] }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="capitalize text-sm">{{ $user['role'] }}</span>
                </td>
                <td class="px-6 py-4 text-sm text-text-gray">
                    {{ \Carbon\Carbon::parse($user['created_at'])->format('d M Y') }}
                </td>
                <td class="px-6 py-4">
                    <x-status-badge :status="$user['account_status']" />
                </td>
                <td class="px-6 py-4">
                    <x-status-badge :status="$user['verification_status']" />
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex justify-end gap-2">
                        <button onclick="showToast('Buka detail {{ $user['name'] }}', 'info')" class="text-text-gray hover:text-primary transition-colors" title="Detail">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button onclick="showToast('Edit {{ $user['name'] }}', 'info')" class="text-text-gray hover:text-warning transition-colors" title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        @if($user['account_status'] === 'aktif')
                            <button onclick="showToast('Nonaktifkan {{ $user['name'] }}', 'warning')" class="text-text-gray hover:text-warning transition-colors" title="Nonaktifkan">
                                <i class="fa-solid fa-ban"></i>
                            </button>
                        @else
                            <button onclick="showToast('Aktifkan {{ $user['name'] }}', 'success')" class="text-text-gray hover:text-success transition-colors" title="Aktifkan">
                                <i class="fa-solid fa-check"></i>
                            </button>
                        @endif
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

<!-- Modal Delete -->
<x-confirm-modal id="modal-delete" title="Hapus Pengguna" message="Apakah Anda yakin ingin menghapus pengguna ini? Semua data terkait juga akan terhapus." confirmText="Hapus" />

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
