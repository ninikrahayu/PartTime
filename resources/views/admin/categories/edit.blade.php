@extends('layouts.admin')
@section('title', 'Edit Kategori - Admin Partimeku')
@section('page_title', 'Edit Kategori')

@section('content')
<div class="space-y-6 max-w-2xl">
    <div class="flex items-center gap-3">
        <a href="{{ url('/admin/categories') }}" class="text-text-gray hover:text-primary transition-colors">
            <i class="fa-solid fa-arrow-left text-xl"></i>
        </a>
        <h2 class="text-2xl font-bold text-text-dark">Edit Kategori</h2>
    </div>

    <form data-dummy-submit data-success-message="Kategori berhasil diperbarui." data-redirect-url="{{ url('/admin/categories') }}" class="space-y-6">
        <x-card>
            <div class="space-y-4">
                <label class="block text-sm font-medium text-text-dark">
                    ID Kategori
                    <x-input type="text" class="mt-2 bg-surface" value="{{ $category['id'] }}" disabled />
                </label>
                
                <label class="block text-sm font-medium text-text-dark">
                    Nama Kategori
                    <x-input name="name" type="text" class="mt-2" value="{{ $category['name'] }}" required />
                </label>
                
                <label class="block text-sm font-medium text-text-dark">
                    Status
                    <x-select name="status" class="mt-2">
                        <option value="aktif" selected>Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </x-select>
                </label>
            </div>
        </x-card>

        <div class="flex justify-end gap-3">
            <a href="{{ url('/admin/categories') }}" class="rounded-md border border-border-color bg-white px-5 py-2.5 text-sm font-medium text-text-dark hover:bg-surface transition-colors">Batal</a>
            <button type="submit" class="rounded-md bg-primary px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-900 transition-colors">
                <i class="fa-solid fa-save mr-2"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
