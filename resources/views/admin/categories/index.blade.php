@extends('layouts.admin')
@section('title', 'Manajemen Kategori - Admin Partimeku')
@section('page_title', 'Manajemen Kategori')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="rounded-md bg-green-50 p-4 border border-green-200">
            <p class="text-sm font-medium text-green-800"><i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}</p>
        </div>
    @endif
    <!-- Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between gap-4">
        <form method="GET" action="{{ route('admin.categories.index') }}" class="flex-1 flex gap-2 items-center">
            <x-search-input name="search" value="{{ request('search') }}" placeholder="Cari kategori..." class="w-full sm:w-64" />
            <button type="submit" class="hidden">Cari</button>
            @if(request('search'))
                <a href="{{ route('admin.categories.index') }}" class="text-sm text-danger hover:underline whitespace-nowrap"><i class="fa-solid fa-xmark mr-1"></i>Reset</a>
            @endif
        </form>
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
                    <i class="fa-solid fa-tags text-primary/60 mr-2"></i> {{ $category->name }}
                </td>
                <td class="px-6 py-4 text-center text-sm">
                    {{ \App\Models\Lowongan::where('category', $category->name)->count() }}
                </td>
                <td class="px-6 py-4 text-center">
                    <x-status-badge :status="$category->status" />
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex justify-end gap-2">
                        <button onclick="openEditModal({{ $category->id }}, '{{ $category->name }}', '{{ $category->status }}')" class="text-text-gray hover:text-warning transition-colors" title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <form method="POST" action="{{ route('admin.categories.destroy', $category->id) }}" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus kategori ini permanen?')" class="text-text-gray hover:text-danger transition-colors" title="Hapus">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </x-table>
        <div class="p-4 border-t border-border-color">
            {{ $categories->links() }}
        </div>
    </x-card>
</div>

<!-- Modal Add -->
<x-modal id="modal-add" title="Tambah Kategori">
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-text-dark mb-1">Nama Kategori</label>
                <x-input name="name" type="text" placeholder="Masukkan nama kategori" required />
            </div>
            <div>
                <label class="block text-sm font-medium text-text-dark mb-1">Status</label>
                <x-select name="status">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </x-select>
            </div>
        </div>
        <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
            <x-button type="submit" class="w-full justify-center sm:col-start-2">Simpan</x-button>
            <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-text-dark shadow-sm ring-1 ring-inset ring-border-color hover:bg-surface sm:col-start-1 sm:mt-0" onclick="closeModal('modal-add')">Batal</button>
        </div>
    </form>
</x-modal>

<!-- Modal Edit -->
<x-modal id="modal-edit" title="Edit Kategori">
    <form id="edit-form" action="" method="POST">
        @csrf @method('PUT')
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-text-dark mb-1">Nama Kategori</label>
                <x-input id="edit-name" name="name" type="text" required />
            </div>
            <div>
                <label class="block text-sm font-medium text-text-dark mb-1">Status</label>
                <x-select id="edit-status" name="status">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </x-select>
            </div>
        </div>
        <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
            <x-button type="submit" class="w-full justify-center sm:col-start-2">Simpan Perubahan</x-button>
            <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-text-dark shadow-sm ring-1 ring-inset ring-border-color hover:bg-surface sm:col-start-1 sm:mt-0" onclick="closeModal('modal-edit')">Batal</button>
        </div>
    </form>
</x-modal>

@push('scripts')
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }
    function openEditModal(id, name, status) {
        document.getElementById('edit-form').action = `/admin/categories/${id}`;
        document.getElementById('edit-name').value = name;
        document.getElementById('edit-status').value = status;
        openModal('modal-edit');
    }
</script>
@endpush
@endsection
