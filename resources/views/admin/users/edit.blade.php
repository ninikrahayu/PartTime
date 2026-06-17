@extends('layouts.admin')
@section('title', 'Edit Pengguna - Admin Partimeku')
@section('page_title', 'Edit Pengguna')

@section('content')
<div class="space-y-6 max-w-4xl">
    <div class="flex items-center gap-3">
        <a href="{{ url('/admin/users/'.$user['id']) }}" class="text-text-gray hover:text-primary transition-colors">
            <i class="fa-solid fa-arrow-left text-xl"></i>
        </a>
        <h2 class="text-2xl font-bold text-text-dark">Edit Pengguna</h2>
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

    <form method="POST" action="{{ route('admin.users.update', $user['id']) }}" class="space-y-6">
        @csrf @method('PUT')
        <x-card>
            <h4 class="text-lg font-semibold text-text-dark border-b border-border-color pb-2 mb-4">Informasi Akun Dasar</h4>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <label class="block text-sm font-medium text-text-dark">
                    Nama Lengkap
                    <x-input name="name" type="text" class="mt-2" value="{{ $user['name'] }}" required />
                </label>
                <label class="block text-sm font-medium text-text-dark">
                    Email
                    <x-input name="email" type="email" class="mt-2" value="{{ $user['email'] }}" required />
                </label>
                <label class="block text-sm font-medium text-text-dark">
                    No. Telepon
                    <x-input name="phone" type="text" class="mt-2" value="{{ $user['phone'] ?? '' }}" />
                </label>
                <label class="block text-sm font-medium text-text-dark">
                    Role
                    <x-select name="role" class="mt-2" disabled>
                        <option value="mahasiswa" {{ $user['role'] === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        <option value="penyedia" {{ $user['role'] === 'penyedia' ? 'selected' : '' }}>Penyedia</option>
                        <option value="admin" {{ $user['role'] === 'admin' ? 'selected' : '' }}>Admin</option>
                    </x-select>
                    <span class="text-xs text-text-gray mt-1 block">Role tidak dapat diubah setelah pendaftaran.</span>
                </label>
                
                <label class="block text-sm font-medium text-text-dark">
                    Status Akun (Aktif/Banned)
                    <x-select name="is_active" class="mt-2">
                        <option value="1" {{ !isset($user['is_active']) || $user['is_active'] ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ isset($user['is_active']) && !$user['is_active'] ? 'selected' : '' }}>Nonaktif / Banned</option>
                    </x-select>
                </label>
                <label class="block text-sm font-medium text-text-dark">
                    Status Verifikasi
                    <x-select name="status" class="mt-2">
                        <option value="pending" {{ $user['status'] === 'pending' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                        <option value="verified" {{ $user['status'] === 'verified' ? 'selected' : '' }}>Terverifikasi (Aktif)</option>
                        <option value="rejected" {{ $user['status'] === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </x-select>
                </label>
            </div>
        </x-card>

        @if($profile)
        <x-card>
            <h4 class="text-lg font-semibold text-text-dark border-b border-border-color pb-2 mb-4">
                {{ $user['role'] === 'mahasiswa' ? 'Profil Mahasiswa' : 'Profil Penyedia' }}
            </h4>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @if($user['role'] === 'mahasiswa')
                    <label class="block text-sm font-medium text-text-dark">
                        Kampus
                        <x-input name="campus" type="text" class="mt-2" value="{{ $profile['campus'] ?? '' }}" />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Jurusan
                        <x-input name="major" type="text" class="mt-2" value="{{ $profile['major'] ?? '' }}" />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Semester
                        <x-input name="semester" type="number" class="mt-2" value="{{ $profile['semester'] ?? '' }}" />
                    </label>
                @elseif($user['role'] === 'penyedia')
                    <label class="block text-sm font-medium text-text-dark">
                        Nama Usaha / Instansi
                        <x-input name="company_name" type="text" class="mt-2" value="{{ $profile['company_name'] ?? '' }}" />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Jenis Usaha
                        <x-input name="company_type" type="text" class="mt-2" value="{{ $profile['company_type'] ?? '' }}" />
                    </label>
                    <label class="block text-sm font-medium text-text-dark sm:col-span-2">
                        Alamat
                        <x-textarea name="address" class="mt-2" rows="3">{{ $profile['address'] ?? '' }}</x-textarea>
                    </label>
                @endif
            </div>
        </x-card>
        @endif

        <div class="flex justify-end gap-3">
            <a href="{{ url('/admin/users') }}" class="rounded-md border border-border-color bg-white px-5 py-2.5 text-sm font-medium text-text-dark hover:bg-surface transition-colors">Batal</a>
            <button type="submit" class="rounded-md bg-primary px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-900 transition-colors">
                <i class="fa-solid fa-save mr-2"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
