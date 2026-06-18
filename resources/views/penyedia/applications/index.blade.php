@extends('layouts.penyedia')
@section('title', 'Lamaran Masuk - Penyedia Partimeku')
@section('page_title', 'Lamaran Masuk')

@section('content')
<div class="space-y-6">
    <!-- Action Bar -->
    <form action="{{ route('penyedia.applications.index') }}" method="GET" class="flex flex-col sm:flex-row justify-between gap-4">
        <div class="flex flex-col sm:flex-row gap-4 flex-1">
            <x-input name="search" value="{{ request('search') }}" placeholder="Cari nama mahasiswa atau judul..." class="w-full sm:w-64" />
            <x-select name="status" class="w-full sm:w-40" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </x-select>
            <x-button type="submit" class="bg-primary hover:bg-blue-900 text-white"><i class="fa-solid fa-search mr-2"></i>Cari</x-button>
        </div>
    </form>

    @if(session('success'))
        <div class="rounded-md bg-green-50 p-4 border border-green-200">
            <p class="text-sm font-medium text-green-800"><i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}</p>
        </div>
    @endif

    <!-- Table -->
    <x-card class="p-0 border-none shadow-sm overflow-hidden">
        <x-table>
            <x-slot name="thead">
                <tr>
                    <th scope="col" class="px-6 py-3">Pelamar</th>
                    <th scope="col" class="px-6 py-3">Lowongan</th>
                    <th scope="col" class="px-6 py-3">Tgl Lamar</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </x-slot>
            @forelse($applications as $app)
            <tr class="bg-white border-b border-border-color hover:bg-surface">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($app->pelamar->name ?? 'User') }}&background=random&color=fff" class="w-8 h-8 rounded-full">
                        <div>
                            <div class="font-medium text-text-dark">{{ $app->pelamar->name ?? '-' }}</div>
                            <div class="text-xs text-text-gray">Mahasiswa</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="font-medium text-text-dark text-sm line-clamp-1 max-w-[200px]" title="{{ $app->lowongan->judul ?? '' }}">
                        {{ $app->lowongan->judul ?? '-' }}
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-text-gray">
                    {{ $app->created_at->format('d M Y') }}
                </td>
                <td class="px-6 py-4">
                    <x-status-badge :status="$app->status" />
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex justify-end gap-2">
                        <a href="{{ url('/penyedia/applications/'.$app->id) }}" class="text-text-gray hover:text-primary transition-colors p-1" title="Detail Lamaran">
                            <i class="fa-solid fa-file-invoice"></i>
                        </a>
                        <button onclick="openStatusModal({{ $app->id }}, '{{ $app->status }}')" class="text-text-gray hover:text-warning transition-colors p-1" title="Ubah Status">
                            <i class="fa-solid fa-rotate"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-10 text-center text-text-gray">
                    <i class="fa-solid fa-inbox text-4xl mb-3"></i>
                    <p>Belum ada lamaran yang masuk.</p>
                </td>
            </tr>
            @endforelse
        </x-table>
        <div class="p-4 border-t border-border-color">
            {{ $applications->links() }}
        </div>
    </x-card>
</div>

<!-- Modal Ubah Status -->
<x-modal id="modal-status" title="Update Status Lamaran">
    <form id="form-ubah-status" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-4">
            <x-select name="status">
                <option value="diproses">Tandai Sedang Diproses</option>
                <option value="diterima">Terima Pelamar</option>
                <option value="ditolak">Tolak Pelamar</option>
            </x-select>
        </div>
    </form>
    <x-slot name="footer">
        <button type="submit" form="form-ubah-status" class="inline-flex justify-center rounded-md bg-primary px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-900">Simpan</button>
        <button type="button" class="ml-2 inline-flex justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-text-dark shadow-sm ring-1 ring-inset ring-border-color hover:bg-surface" onclick="closeModal('modal-status')">Batal</button>
    </x-slot>
</x-modal>

<!-- Toast Container -->
<div id="toast-container" class="fixed bottom-4 right-4 z-[200] flex flex-col gap-2"></div>
<template id="toast-template">
    <div class="toast-item flex items-center w-full max-w-xs p-4 text-text-dark bg-white rounded-md shadow-lg border border-border-color transition-all duration-300 transform translate-x-full opacity-0">
        <div class="toast-icon inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg"></div>
        <div class="toast-message ml-3 text-sm font-medium"></div>
        <button type="button" class="toast-close ml-auto -mx-1.5 -my-1.5 bg-white text-text-gray hover:text-text-dark rounded-md p-1.5 inline-flex items-center justify-center h-8 w-8"><i class="fa-solid fa-xmark"></i></button>
    </div>
</template>

@push('scripts')
<script>
    function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
    function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

    function openStatusModal(lamaranId, currentStatus) {
        const form = document.getElementById('form-ubah-status');
        form.action = `/penyedia/lamaran/${lamaranId}/status`;
        const select = form.querySelector('select[name="status"]');
        if (select) select.value = currentStatus;
        openModal('modal-status');
    }
</script>
@endpush
@endsection
