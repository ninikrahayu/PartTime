@extends('layouts.admin')
@section('title', 'Detail Pengguna - Admin Partimeku')
@section('page_title', 'Detail Pengguna')

@section('content')
<div class="space-y-6 max-w-4xl">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ url('/admin/users') }}" class="text-text-gray hover:text-primary transition-colors">
                <i class="fa-solid fa-arrow-left text-xl"></i>
            </a>
            <h2 class="text-2xl font-bold text-text-dark">Detail Pengguna</h2>
        </div>
        <div class="flex gap-2">
            <a href="{{ url('/admin/users/'.$user['id'].'/edit') }}" class="inline-flex items-center rounded-md bg-white border border-border-color px-4 py-2 text-sm font-medium text-text-dark hover:bg-surface">
                <i class="fa-solid fa-pen-to-square mr-2"></i> Edit
            </a>
        </div>
    </div>

    <x-card>
        <div class="flex flex-col md:flex-row gap-6 items-start">
            <div class="w-full md:w-1/3 flex flex-col items-center p-6 border border-border-color rounded-lg bg-surface">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user['name']) }}&background=random&color=fff&size=128" alt="{{ $user['name'] }}" class="w-32 h-32 rounded-full mb-4 shadow-sm">
                <h3 class="text-xl font-bold text-text-dark text-center">{{ $user['name'] }}</h3>
                <p class="text-text-gray text-sm mb-3">{{ $user['email'] }}</p>
                
                <div class="flex flex-wrap justify-center gap-2 mt-2">
                    <x-badge color="primary">{{ ucfirst($user['role']) }}</x-badge>
                    <x-status-badge :status="$user['account_status']" />
                </div>
            </div>

            <div class="w-full md:w-2/3 space-y-6">
                <!-- Data Akun -->
                <div>
                    <h4 class="text-lg font-semibold text-text-dark border-b border-border-color pb-2 mb-4">Informasi Akun</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-text-gray">ID Pengguna</p>
                            <p class="font-medium text-text-dark">{{ $user['id'] }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-text-gray">No. Telepon</p>
                            <p class="font-medium text-text-dark">{{ $user['phone'] ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-text-gray">Tanggal Daftar</p>
                            <p class="font-medium text-text-dark">{{ \Carbon\Carbon::parse($user['created_at'])->format('d F Y, H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-text-gray">Status Verifikasi</p>
                            <div class="mt-1"><x-status-badge :status="$user['verification_status']" /></div>
                        </div>
                    </div>
                </div>

                <!-- Profil Khusus Role -->
                @if($profile)
                    <div>
                        <h4 class="text-lg font-semibold text-text-dark border-b border-border-color pb-2 mb-4">
                            {{ $user['role'] === 'mahasiswa' ? 'Profil Mahasiswa' : 'Profil Penyedia' }}
                        </h4>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @if($user['role'] === 'mahasiswa')
                                <div><p class="text-sm text-text-gray">Kampus</p><p class="font-medium text-text-dark">{{ $profile['campus'] ?? '-' }}</p></div>
                                <div><p class="text-sm text-text-gray">Jurusan</p><p class="font-medium text-text-dark">{{ $profile['major'] ?? '-' }}</p></div>
                                <div><p class="text-sm text-text-gray">Semester</p><p class="font-medium text-text-dark">{{ $profile['semester'] ?? '-' }}</p></div>
                                <div><p class="text-sm text-text-gray">File KTM</p><p class="font-medium text-primary hover:underline cursor-pointer"><i class="fa-solid fa-file-pdf mr-1"></i>{{ $profile['ktm_file'] ?? '-' }}</p></div>
                            @elseif($user['role'] === 'penyedia')
                                <div><p class="text-sm text-text-gray">Nama Usaha / Instansi</p><p class="font-medium text-text-dark">{{ $profile['company_name'] ?? '-' }}</p></div>
                                <div><p class="text-sm text-text-gray">Jenis Usaha</p><p class="font-medium text-text-dark">{{ $profile['company_type'] ?? '-' }}</p></div>
                                <div class="sm:col-span-2"><p class="text-sm text-text-gray">Alamat</p><p class="font-medium text-text-dark">{{ $profile['address'] ?? '-' }}</p></div>
                                <div><p class="text-sm text-text-gray">Dokumen Legalitas</p><p class="font-medium text-primary hover:underline cursor-pointer"><i class="fa-solid fa-file-pdf mr-1"></i>{{ $profile['verification_document'] ?? '-' }}</p></div>
                            @endif
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </x-card>
</div>
@endsection
