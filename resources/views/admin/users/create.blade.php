@extends('layouts.admin')
@section('title', 'Tambah Pengguna - Admin Partimeku')
@section('page_title', 'Tambah Pengguna')

@section('content')
<div class="space-y-6 max-w-4xl">
    <div class="flex items-center gap-3">
        <a href="{{ url('/admin/users') }}" class="text-text-gray hover:text-primary transition-colors">
            <i class="fa-solid fa-arrow-left text-xl"></i>
        </a>
        <h2 class="text-2xl font-bold text-text-dark">Tambah Pengguna</h2>
    </div>

    @if($errors->any())
        <div class="mb-4 rounded-md bg-red-50 p-4 border border-red-200">
            <p class="text-sm font-medium text-red-800"><i class="fa-solid fa-triangle-exclamation mr-2"></i>Terjadi kesalahan:</p>
            <ul class="list-disc pl-5 mt-1 text-sm text-red-700">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
        @csrf
        <x-card>
            <h4 class="text-lg font-semibold text-text-dark border-b border-border-color pb-2 mb-4">Informasi Akun Dasar</h4>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <label class="block text-sm font-medium text-text-dark">
                    Nama Lengkap
                    <x-input name="name" type="text" class="mt-2" placeholder="Masukkan nama lengkap" required />
                </label>
                <label class="block text-sm font-medium text-text-dark">
                    Email
                    <x-input name="email" type="email" class="mt-2" placeholder="contoh@email.com" required />
                </label>
                <label class="block text-sm font-medium text-text-dark">
                    No. Telepon
                    <x-input name="phone" type="text" class="mt-2" placeholder="0812xxxx" />
                </label>
                <label class="block text-sm font-medium text-text-dark">
                    Role
                    <x-select name="role" class="mt-2" required>
                        <option value="" disabled selected>Pilih Role</option>
                        <option value="mahasiswa">Mahasiswa</option>
                        <option value="penyedia">Penyedia</option>
                        <option value="admin">Admin</option>
                    </x-select>
                </label>
                <label class="block text-sm font-medium text-text-dark">
                    Password
                    <x-input name="password" type="password" class="mt-2" placeholder="Masukkan password" required />
                </label>
                <label class="block text-sm font-medium text-text-dark">
                    Konfirmasi Password
                    <x-input name="password_confirmation" type="password" class="mt-2" placeholder="Ulangi password" required />
                </label>
            </div>
        </x-card>

        <div class="flex justify-end gap-3">
            <a href="{{ url('/admin/users') }}" class="rounded-md border border-border-color bg-white px-5 py-2.5 text-sm font-medium text-text-dark hover:bg-surface transition-colors">Batal</a>
            <button type="submit" class="rounded-md bg-primary px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-900 transition-colors">
                <i class="fa-solid fa-plus mr-2"></i> Tambah Pengguna
            </button>
        </div>
    </form>
</div>
@endsection
