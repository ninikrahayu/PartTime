@extends('layouts.admin')

@section('title', 'Profil Admin - Partimeku')
@section('page_title', 'Profil Admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-medium text-primary">Akun Admin</p>
            <h2 class="mt-1 text-2xl font-semibold text-text-dark">Profil Admin</h2>
            <p class="mt-1 text-sm text-text-gray">Kelola informasi akun administrator Partimeku secara frontend dummy.</p>
        </div>
        <button type="button" onclick="openModal('admin-logout-modal')" class="inline-flex items-center justify-center rounded-md border border-danger bg-white px-4 py-2 text-sm font-medium text-danger hover:bg-danger/10">
            <i class="fa-solid fa-right-from-bracket mr-2"></i>Logout
        </button>
    </div>

    <div class="grid gap-6 lg:grid-cols-[320px_1fr]">
        <x-card>
            <div class="flex flex-col items-center text-center">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($admin['name'] ?? 'Admin') }}&background=1E3A8A&color=fff" alt="{{ $admin['name'] ?? 'Admin' }}" class="h-24 w-24 rounded-full border border-border-color object-cover">
                <h3 class="mt-4 text-lg font-semibold text-text-dark">{{ $admin['name'] ?? 'Admin Utama' }}</h3>
                <p class="mt-1 text-sm text-text-gray">{{ $admin['email'] ?? 'admin@parttime.test' }}</p>
                <div class="mt-4 flex flex-wrap justify-center gap-2">
                    <x-status-badge :status="$admin['account_status'] ?? 'aktif'" />
                    <x-status-badge :status="$admin['verification_status'] ?? 'terverifikasi'" />
                </div>
            </div>
        </x-card>

        <div class="space-y-6">
            <x-profile-section-card title="Data Profil" description="Edit nama, email, dan username admin.">
                <form data-admin-form class="grid gap-4 sm:grid-cols-2">
                    <label class="block text-sm font-medium text-text-dark">
                        Nama
                        <x-input name="name" type="text" class="mt-2" :value="$admin['name'] ?? 'Admin Utama'" />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Email
                        <x-input name="email" type="email" class="mt-2" :value="$admin['email'] ?? 'admin@parttime.test'" />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Username
                        <x-input name="username" type="text" class="mt-2" :value="$admin['username'] ?? 'admin'" />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Nomor telepon
                        <x-input name="phone" type="tel" class="mt-2" :value="$admin['phone'] ?? ''" />
                    </label>
                    <div class="sm:col-span-2">
                        <button type="submit" class="inline-flex items-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-blue-900">
                            <i class="fa-solid fa-floppy-disk mr-2"></i>Simpan Profil
                        </button>
                    </div>
                </form>
            </x-profile-section-card>

            <x-profile-section-card title="Ubah Password" description="Form dummy untuk mengganti password admin.">
                <form data-admin-form class="grid gap-4 sm:grid-cols-2">
                    <label class="block text-sm font-medium text-text-dark">
                        Password lama
                        <x-input name="current_password" type="password" class="mt-2" placeholder="Password lama" />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Password baru
                        <x-input name="password" type="password" class="mt-2" placeholder="Password baru" />
                    </label>
                    <label class="block text-sm font-medium text-text-dark sm:col-span-2">
                        Konfirmasi password baru
                        <x-input name="password_confirmation" type="password" class="mt-2" placeholder="Ulangi password baru" />
                    </label>
                    <div class="sm:col-span-2">
                        <button type="submit" class="inline-flex items-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-blue-900">
                            <i class="fa-solid fa-key mr-2"></i>Ubah Password
                        </button>
                    </div>
                </form>
            </x-profile-section-card>
        </div>
    </div>
</div>

<x-modal id="admin-logout-modal" title="Konfirmasi Logout">
    <div class="space-y-4">
        <p class="text-sm text-text-gray">Keluar dari dashboard admin dan kembali ke halaman login?</p>
        <div class="flex justify-end gap-2">
            <button type="button" onclick="closeModal('admin-logout-modal')" class="rounded-md border border-border-color bg-white px-4 py-2 text-sm font-medium text-text-dark hover:bg-surface">Batal</button>
            <a href="{{ url('/admin/login') }}" class="rounded-md bg-danger px-4 py-2 text-sm font-medium text-white hover:bg-red-700">Logout</a>
        </div>
    </div>
</x-modal>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('[data-admin-form]').forEach((form) => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            showToast('Data admin berhasil disimpan.', 'success');
        });
    });
</script>
@endpush
