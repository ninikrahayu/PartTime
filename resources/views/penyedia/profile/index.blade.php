@extends('layouts.penyedia')

@section('title', 'Profil Akun Penyedia - Partimeku')
@section('page_title', 'Profil Akun')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-medium text-primary">Akun Penyedia</p>
            <h2 class="mt-1 text-2xl font-semibold text-text-dark">Profil Akun</h2>
            <p class="mt-1 text-sm text-text-gray">Kelola data penanggung jawab dan keamanan akun penyedia.</p>
        </div>
        <button type="button" onclick="openModal('provider-logout-modal')" class="inline-flex items-center justify-center rounded-md border border-danger bg-white px-4 py-2 text-sm font-medium text-danger hover:bg-danger/10">
            <i class="fa-solid fa-right-from-bracket mr-2"></i>Logout
        </button>
    </div>

    <div class="grid gap-6 lg:grid-cols-[320px_1fr]">
        <x-card>
            <div class="flex flex-col items-center text-center">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user['name'] ?? 'Penyedia') }}&background=1E3A8A&color=fff" alt="{{ $user['name'] ?? 'Penyedia' }}" class="h-24 w-24 rounded-full border border-border-color object-cover">
                <h3 class="mt-4 text-lg font-semibold text-text-dark">{{ $user['name'] ?? 'Penyedia' }}</h3>
                <p class="mt-1 text-sm text-text-gray">{{ $user['email'] ?? '-' }}</p>
                <div class="mt-4 flex flex-wrap justify-center gap-2">
                    <x-status-badge :status="$user['account_status'] ?? 'aktif'" />
                    <x-status-badge :status="$user['verification_status'] ?? 'menunggu_verifikasi'" />
                </div>
            </div>
        </x-card>

        <div class="space-y-6">
            <x-profile-section-card title="Data Penanggung Jawab" description="Edit nama, email, username, dan nomor telepon akun penyedia.">
                <form data-provider-profile-form class="grid gap-4 sm:grid-cols-2">
                    <label class="block text-sm font-medium text-text-dark">
                        Nama penanggung jawab
                        <x-input name="name" type="text" class="mt-2" :value="$user['name'] ?? ''" />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Email
                        <x-input name="email" type="email" class="mt-2" :value="$user['email'] ?? ''" />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Username
                        <x-input name="username" type="text" class="mt-2" :value="$user['username'] ?? ''" />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Nomor telepon
                        <x-input name="phone" type="tel" class="mt-2" :value="$user['phone'] ?? ''" />
                    </label>
                    <div class="sm:col-span-2">
                        <button type="submit" class="inline-flex items-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-blue-900">
                            <i class="fa-solid fa-floppy-disk mr-2"></i>Simpan Profil
                        </button>
                    </div>
                </form>
            </x-profile-section-card>

            <x-profile-section-card title="Ubah Password" description="Form dummy untuk mengganti password akun penyedia.">
                <form data-provider-profile-form class="grid gap-4 sm:grid-cols-2">
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

<x-modal id="provider-logout-modal" title="Konfirmasi Logout">
    <div class="space-y-4">
        <p class="text-sm text-text-gray">Keluar dari dashboard penyedia dan kembali ke halaman login?</p>
        <div class="flex justify-end gap-2">
            <button type="button" onclick="closeModal('provider-logout-modal')" class="rounded-md border border-border-color bg-white px-4 py-2 text-sm font-medium text-text-dark hover:bg-surface">Batal</button>
            <a href="{{ url('/login') }}" class="rounded-md bg-danger px-4 py-2 text-sm font-medium text-white hover:bg-red-700">Logout</a>
        </div>
    </div>
</x-modal>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('[data-provider-profile-form]').forEach((form) => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            showToast('Data akun penyedia berhasil disimpan.', 'success');
        });
    });
</script>
@endpush
