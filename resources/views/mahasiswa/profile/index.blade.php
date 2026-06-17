@extends('layouts.mahasiswa')
@section('title', 'Profil Saya - Mahasiswa Partimeku')
@section('page_title', 'Profil Saya')

@section('content')
<div class="max-w-4xl mx-auto space-y-4 md:space-y-6 pb-20 md:pb-6">

    @if(session('success'))
        <div class="rounded-md bg-green-50 p-4 border border-green-200">
            <p class="text-sm font-medium text-green-800"><i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}</p>
        </div>
    @endif
    @if($errors->any())
        <div class="rounded-md bg-red-50 p-4 border border-red-200">
            <p class="text-sm font-medium text-red-800">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </p>
        </div>
    @endif

    @if($user->status === 'pending')
        <div class="bg-warning/10 border-l-4 border-warning p-4 rounded-md flex items-start gap-3">
            <i class="fa-solid fa-clock text-warning mt-0.5"></i>
            <div>
                <h3 class="text-sm font-bold text-warning">Menunggu Verifikasi KTM</h3>
                <p class="text-sm text-warning mt-1">Akun Anda sedang ditinjau. Anda tidak dapat melamar pekerjaan sebelum proses verifikasi selesai.</p>
            </div>
        </div>
    @endif
    <form action="{{ route('mahasiswa.profil.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Kolom Kiri: Foto, Status, & CV -->
            <div class="md:col-span-1 space-y-6">
                
                <x-card class="shadow-sm border-border-color text-center p-6">
                <div class="relative w-32 h-32 mx-auto mb-4 group cursor-pointer" onclick="document.getElementById('avatar-upload').click()">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user['name']) }}&background=1E3A8A&color=fff&size=128" alt="{{ $user['name'] }}" class="w-full h-full rounded-full object-cover border-4 border-surface shadow-sm">
                    <div class="absolute inset-0 bg-black/50 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <i class="fa-solid fa-camera text-white text-xl"></i>
                    </div>
                    <input type="file" id="avatar-upload" class="hidden" accept="image/*" onchange="showToast('Foto profil diubah (Dummy)', 'success')">
                </div>
                
                <h2 class="text-lg font-bold text-text-dark mb-1">{{ $user->name }}</h2>
                <p class="text-sm text-text-gray mb-3">{{ $user->profile->universitas ?? 'Universitas Belum Diatur' }}</p>
                
                <div class="flex justify-center mb-4">
                    <x-status-badge :status="$user->status" />
                </div>
                
                <div class="border-t border-border-color pt-4 mt-2 space-y-3 text-left">
                    <div class="flex items-center gap-3 text-sm">
                        <i class="fa-solid fa-envelope w-5 text-center text-primary"></i>
                        <span class="text-text-dark truncate">{{ $user->email }}</span>
                    </div>
                </div>
            </x-card>

        </div>

        <!-- Kolom Kanan: Form Data Diri -->
        <div class="md:col-span-2 space-y-6">
            <x-card class="shadow-sm border-border-color p-0">
                <x-slot name="header">
                    <h3 class="font-bold text-text-dark">Data Pribadi & Akademik</h3>
                </x-slot>
                
                <div class="p-5 md:p-6 space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-text-dark mb-1">Nama Lengkap Sesuai KTP <span class="text-danger">*</span></label>
                            <x-input type="text" name="name" value="{{ $user->name }}" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-dark mb-1">Nomor Telepon / WA <span class="text-danger">*</span></label>
                            <x-input type="tel" name="no_hp" value="{{ $user->no_hp ?? '' }}" required />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-text-dark mb-1">Universitas / Kampus <span class="text-danger">*</span></label>
                            <x-input type="text" name="universitas" value="{{ $user->profile->universitas ?? '' }}" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-dark mb-1">Jurusan / Program Studi <span class="text-danger">*</span></label>
                            <x-input type="text" name="jurusan" value="{{ $user->profile->jurusan ?? '' }}" required />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-text-dark mb-1">IPK Terakhir <span class="text-danger">*</span></label>
                            <x-input type="number" name="ipk" step="0.01" min="0" max="4" value="{{ $user->profile->ipk ?? '' }}" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-dark mb-1">Semester Saat Ini <span class="text-danger">*</span></label>
                            <x-select name="semester" required>
                                <option value="">Pilih Semester</option>
                                @for($i=1; $i<=8; $i++)
                                    <option value="{{ $i }}" {{ ($user->profile->semester ?? '') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                                @endfor
                                <option value="9" {{ ($user->profile->semester ?? '') == 9 ? 'selected' : '' }}>Semester 9+</option>
                            </x-select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-dark mb-1">CV / Berkas (PDF) <span class="text-danger">*</span></label>
                            @if(!empty($user->profile->ktm_path))
                                <div class="flex items-center gap-2 mb-2">
                                    <a href="{{ Storage::url($user->profile->ktm_path) }}" target="_blank" class="text-xs font-semibold text-primary hover:underline bg-primary/10 px-2 py-1 rounded">Lihat Berkas Saat Ini</a>
                                </div>
                                <input type="file" name="cv_file" accept=".pdf" class="w-full text-xs text-text-gray file:mr-2 file:py-1 file:px-2 file:rounded-md file:border-0 file:font-semibold file:bg-surface file:text-text-dark hover:file:bg-border-color" />
                            @else
                                <input type="file" name="cv_file" accept=".pdf" required class="w-full text-sm text-text-gray file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20" />
                            @endif
                            <p class="text-xs text-text-gray mt-1">Maksimal 5MB.</p>
                        </div>
                    </div>

                    <div class="pt-5 border-t border-border-color flex justify-end">
                        <x-button type="submit" class="w-full md:w-auto justify-center"><i class="fa-solid fa-save mr-2"></i> Simpan Perubahan</x-button>
                    </div>
                </div>
            </x-card>
        </div>

    </div>
    </form>
</div>

<div id="toast-container" class="fixed bottom-20 md:bottom-4 right-4 z-[200] flex flex-col gap-2"></div>
<template id="toast-template">
    <div class="toast-item flex items-center w-full max-w-xs p-4 text-text-dark bg-white rounded-md shadow-lg border border-border-color transition-all duration-300 transform translate-x-full opacity-0">
        <div class="toast-icon inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg"></div>
        <div class="toast-message ml-3 text-sm font-medium"></div>
        <button type="button" class="toast-close ml-auto -mx-1.5 -my-1.5 bg-white text-text-gray hover:text-text-dark rounded-md p-1.5 inline-flex items-center justify-center h-8 w-8"><i class="fa-solid fa-xmark"></i></button>
    </div>
</template>
@endsection
