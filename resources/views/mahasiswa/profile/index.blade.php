@extends('layouts.mahasiswa')
@section('title', 'Profil Saya - Mahasiswa Partimeku')
@section('page_title', 'Profil Saya')

@section('content')
<div class="max-w-4xl mx-auto space-y-4 md:space-y-6 pb-20 md:pb-6">

    @if($user['verification_status'] === 'menunggu_verifikasi')
        <div class="bg-warning/10 border-l-4 border-warning p-4 rounded-md flex items-start gap-3">
            <i class="fa-solid fa-clock text-warning mt-0.5"></i>
            <div>
                <h3 class="text-sm font-bold text-warning">Menunggu Verifikasi KTM</h3>
                <p class="text-sm text-warning mt-1">Akun Anda sedang ditinjau. Anda tidak dapat melamar pekerjaan sebelum proses verifikasi selesai (Maksimal 2x24 jam).</p>
            </div>
        </div>
    @endif

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
                
                <h2 class="text-lg font-bold text-text-dark mb-1">{{ $user['name'] }}</h2>
                <p class="text-sm text-text-gray mb-3">{{ $profile['university'] ?? 'Universitas ITATS' }}</p>
                
                <div class="flex justify-center mb-4">
                    <x-status-badge :status="$user['verification_status']" />
                </div>
                
                <div class="border-t border-border-color pt-4 mt-2 space-y-3 text-left">
                    <div class="flex items-center gap-3 text-sm">
                        <i class="fa-solid fa-envelope w-5 text-center text-primary"></i>
                        <span class="text-text-dark truncate">{{ $user['email'] }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm">
                        <i class="fa-solid fa-phone w-5 text-center text-primary"></i>
                        <span class="text-text-dark">{{ $profile['phone'] ?? '-' }}</span>
                    </div>
                </div>
            </x-card>

            <x-card class="shadow-sm border-border-color p-5">
                <h3 class="font-bold text-text-dark text-sm uppercase tracking-wider mb-4">Curriculum Vitae (CV)</h3>
                
                @if(!empty($profile['cv_document']))
                    <div class="p-3 bg-surface border border-border-color rounded-md flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3 overflow-hidden">
                            <i class="fa-solid fa-file-pdf text-danger text-2xl shrink-0"></i>
                            <div class="truncate">
                                <p class="text-sm font-medium text-text-dark truncate">{{ $profile['cv_document'] }}</p>
                                <p class="text-xs text-text-gray">Diunggah pada {{ \Carbon\Carbon::now()->subDays(2)->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <x-button class="flex-1 justify-center bg-white border border-border-color !text-text-dark hover:bg-surface"><i class="fa-solid fa-eye"></i></x-button>
                        <x-button class="flex-1 justify-center text-sm" onclick="document.getElementById('cv-upload').click()">Perbarui CV</x-button>
                    </div>
                @else
                    <x-file-upload name="cv" label="Unggah CV Terbaru Anda (PDF)" accept=".pdf" />
                    <x-button class="w-full justify-center mt-3" onclick="showToast('CV berhasil diunggah', 'success')">Simpan CV</x-button>
                @endif
                <input type="file" id="cv-upload" class="hidden" accept=".pdf" onchange="showToast('CV berhasil diperbarui', 'success')">
            </x-card>

        </div>

        <!-- Kolom Kanan: Form Data Diri -->
        <div class="md:col-span-2 space-y-6">
            <x-card class="shadow-sm border-border-color p-0">
                <x-slot name="header">
                    <h3 class="font-bold text-text-dark">Data Pribadi & Akademik</h3>
                </x-slot>
                
                <form class="p-5 md:p-6 space-y-5" onsubmit="event.preventDefault(); showToast('Profil berhasil disimpan', 'success');">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-text-dark mb-1">Nama Lengkap Sesuai KTP <span class="text-danger">*</span></label>
                            <x-input type="text" value="{{ $user['name'] }}" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-dark mb-1">Nomor Telepon / WA <span class="text-danger">*</span></label>
                            <x-input type="tel" value="{{ $profile['phone'] ?? '' }}" required />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-text-dark mb-1">Universitas / Kampus <span class="text-danger">*</span></label>
                            <x-input type="text" value="{{ $profile['university'] ?? '' }}" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-dark mb-1">Jurusan / Program Studi <span class="text-danger">*</span></label>
                            <x-input type="text" value="{{ $profile['major'] ?? '' }}" required />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-text-dark mb-1">Semester Saat Ini <span class="text-danger">*</span></label>
                            <x-select required>
                                <option value="">Pilih Semester</option>
                                @for($i=1; $i<=8; $i++)
                                    <option value="{{ $i }}" {{ ($profile['semester'] ?? '') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                                @endfor
                                <option value="9+">Semester 9+</option>
                            </x-select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-dark mb-1">IPK Terakhir <span class="text-danger">*</span></label>
                            <x-input type="number" step="0.01" min="0" max="4" value="3.80" required />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-dark mb-1">Keahlian / Skills</label>
                        <x-textarea rows="2" placeholder="Contoh: MS Office, Bahasa Inggris Pasif, Desain Grafis Dasar">{{ implode(', ', $profile['skills'] ?? []) }}</x-textarea>
                    </div>

                    <div class="pt-5 border-t border-border-color flex justify-end">
                        <x-button type="submit" class="w-full md:w-auto justify-center"><i class="fa-solid fa-save mr-2"></i> Simpan Perubahan</x-button>
                    </div>
                </form>
            </x-card>
        </div>

    </div>
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
