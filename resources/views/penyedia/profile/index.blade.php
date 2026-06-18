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
                <img src="{{ $provider->logo_path ? Storage::url($provider->logo_path) : asset('images/dummy/default-logo.png') }}" alt="{{ $provider->business_name ?? $user->name }}" class="h-24 w-24 rounded-full border border-border-color object-cover" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($provider->business_name ?? $user->name) }}&background=1E3A8A&color=fff&size=128'">
                <h3 class="mt-4 text-lg font-semibold text-text-dark">{{ $provider->business_name ?? $user->name }}</h3>
                <p class="mt-1 text-sm text-text-gray">{{ $user->email }}</p>
                <div class="mt-4 flex flex-wrap justify-center gap-2">
                    <x-status-badge :status="$user->is_active ? 'aktif' : 'nonaktif'" />
                    <x-status-badge :status="$user->status" />
                </div>
            </div>
        </x-card>

        <div class="space-y-6">
            <x-profile-section-card title="Data Penanggung Jawab" description="Edit nama, email, username, dan nomor telepon akun penyedia.">
                <form action="{{ route('penyedia.profil.update') }}" method="POST" enctype="multipart/form-data" class="grid gap-4 sm:grid-cols-2">
                    @csrf @method('PUT')
                    <label class="block text-sm font-medium text-text-dark">
                        Nama penanggung jawab
                        <x-input name="name" type="text" class="mt-2" :value="$user->name" required />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Username
                        <x-input name="username" type="text" class="mt-2" :value="$user->username" required />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Nomor telepon pribadi
                        <x-input name="no_hp" type="tel" class="mt-2" :value="$user->no_hp" required />
                    </label>
                    <div class="sm:col-span-2 border-t border-border-color mt-4 pt-4">
                        <h4 class="text-sm font-semibold text-text-dark mb-4">Informasi Usaha</h4>
                    </div>
                    <label class="block text-sm font-medium text-text-dark">
                        Nama Usaha / Instansi
                        <x-input name="business_name" type="text" class="mt-2" :value="$provider->business_name" required />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Jenis Usaha
                        <x-select name="business_type" class="mt-2" required>
                            <option value="F&B" {{ $provider->business_type == 'F&B' ? 'selected' : '' }}>F&B (Kafe, Restoran)</option>
                            <option value="Retail" {{ $provider->business_type == 'Retail' ? 'selected' : '' }}>Retail (Toko, Minimarket)</option>
                            <option value="Jasa" {{ $provider->business_type == 'Jasa' ? 'selected' : '' }}>Jasa</option>
                            <option value="Pendidikan" {{ $provider->business_type == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                            <option value="Lainnya" {{ $provider->business_type == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </x-select>
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Nomor Telepon Bisnis
                        <x-input name="business_phone" type="tel" class="mt-2" :value="$provider->business_phone" required />
                    </label>
                    <label class="block text-sm font-medium text-text-dark sm:col-span-2">
                        Alamat Lengkap Usaha
                        <x-textarea name="business_address" rows="2" class="mt-2" required>{{ $provider->business_address }}</x-textarea>
                    </label>
                    <label class="block text-sm font-medium text-text-dark sm:col-span-2">
                        Deskripsi Usaha
                        <x-textarea name="description" rows="3" class="mt-2">{{ $provider->description }}</x-textarea>
                    </label>
                    <div class="sm:col-span-2 border-t border-border-color mt-4 pt-4">
                        <h4 class="text-sm font-semibold text-text-dark mb-4">Dokumen Bisnis</h4>
                    </div>
                    <label class="block text-sm font-medium text-text-dark">
                        Logo Usaha (Opsional)
                        <input type="file" name="logo_path" class="mt-2 block w-full text-sm text-text-gray file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20" accept="image/*" />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Dokumen Verifikasi (NIB/SIUP - PDF)
                        <input type="file" name="document_path" class="mt-2 block w-full text-sm text-text-gray file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20" accept=".pdf" />
                        @if($provider->document_path)
                            <p class="mt-2 text-xs text-info"><i class="fa-solid fa-file-pdf mr-1"></i> Telah diunggah: <a href="{{ Storage::url($provider->document_path) }}" target="_blank" class="underline font-medium">Lihat Dokumen</a></p>
                        @endif
                    </label>
                    <div class="sm:col-span-2 mt-4 text-right">
                        <button type="submit" class="inline-flex items-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-blue-900">
                            <i class="fa-solid fa-floppy-disk mr-2"></i>Simpan Perubahan
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
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="rounded-md bg-danger px-4 py-2 text-sm font-medium text-white hover:bg-red-700">Logout</button>
            </form>
        </div>
    </div>
</x-modal>
@endsection

@push('scripts')
@endpush
