@extends('layouts.penyedia')
@section('title', 'Profil Usaha - Penyedia Partimeku')
@section('page_title', 'Profil Usaha')

@section('content')
<div class="space-y-6">

    @if($user['verification_status'] === 'ditolak')
        <div class="bg-danger/10 border-l-4 border-danger p-4 rounded-md flex items-start gap-3">
            <i class="fa-solid fa-circle-xmark text-danger mt-0.5"></i>
            <div>
                <h3 class="text-sm font-bold text-danger">Verifikasi Dokumen Ditolak</h3>
                <p class="text-sm text-danger mt-1">Alasan Penolakan: Dokumen NIB yang diunggah tidak terbaca dengan jelas (blur). Silakan unggah ulang dokumen yang lebih jelas.</p>
            </div>
        </div>
    @elseif($user['verification_status'] === 'menunggu_verifikasi')
        <div class="bg-warning/10 border-l-4 border-warning p-4 rounded-md flex items-start gap-3">
            <i class="fa-solid fa-clock text-warning mt-0.5"></i>
            <div>
                <h3 class="text-sm font-bold text-warning">Menunggu Verifikasi Admin</h3>
                <p class="text-sm text-warning mt-1">Profil usaha Anda sedang ditinjau. Beberapa fitur mungkin dibatasi hingga proses verifikasi selesai.</p>
            </div>
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-6">
        
        <!-- Left Side: Basic Info & Logo -->
        <div class="w-full lg:w-1/3 flex-shrink-0 space-y-6">
            <x-card class="shadow-sm border-border-color">
                <div class="flex flex-col items-center">
                    <div class="relative mb-4 group cursor-pointer" onclick="document.getElementById('logo-upload').click()">
                        <img src="{{ asset('images/dummy/default-logo.png') }}" alt="{{ $provider['company_name'] ?? 'Perusahaan' }}" class="w-32 h-32 rounded-full object-cover border-4 border-surface shadow-sm" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($provider['company_name'] ?? 'Penyedia') }}&background=1E3A8A&color=fff&size=128'">
                        <div class="absolute inset-0 bg-black/50 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class="fa-solid fa-camera text-white text-xl"></i>
                        </div>
                        <input type="file" id="logo-upload" class="hidden" accept="image/*" onchange="showToast('Logo berhasil diubah (Dummy)', 'success')">
                    </div>
                    
                    <h2 class="text-lg font-bold text-text-dark text-center">{{ $provider['company_name'] ?? '' }}</h2>
                    <p class="text-sm text-text-gray">{{ $provider['company_type'] ?? '' }}</p>
                    
                    <div class="mt-3 flex items-center justify-center">
                        <x-status-badge :status="$user['verification_status']" />
                    </div>
                    
                    <div class="mt-6 w-full space-y-3">
                        <div class="flex items-center gap-3 text-sm text-text-gray">
                            <i class="fa-solid fa-phone w-5 text-center text-primary"></i>
                            <span>{{ $provider['business_phone'] ?? '' }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-text-gray">
                            <i class="fa-solid fa-envelope w-5 text-center text-primary"></i>
                            <span>{{ $user['email'] }}</span>
                        </div>
                        <div class="flex items-start gap-3 text-sm text-text-gray">
                            <i class="fa-solid fa-location-dot w-5 text-center text-primary mt-1"></i>
                            <span>{{ $provider['address'] }}</span>
                        </div>
                    </div>
                </div>
            </x-card>
            
            <x-card class="shadow-sm border-border-color">
                <h3 class="font-bold text-text-dark mb-4 text-sm uppercase tracking-wider">Dokumen Verifikasi</h3>
                
                @if($user['verification_status'] === 'terverifikasi' || $user['verification_status'] === 'menunggu_verifikasi')
                    <div class="flex items-center justify-between p-3 border border-border-color rounded-md bg-surface">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-file-pdf text-danger text-2xl"></i>
                            <div>
                                <p class="text-sm font-medium text-text-dark line-clamp-1">{{ $provider['verification_document'] }}</p>
                                <p class="text-xs text-text-gray">2.4 MB</p>
                            </div>
                        </div>
                        <button class="text-primary hover:text-blue-900" title="Lihat"><i class="fa-solid fa-eye"></i></button>
                    </div>
                @else
                    <!-- Jika ditolak atau belum ada dokumen -->
                    <x-file-upload name="verification_doc" label="Unggah Ulang NIB / Surat Izin" accept=".pdf,.jpg,.png" />
                    <div class="mt-3 text-right">
                        <x-button class="text-sm py-1.5" onclick="showToast('Dokumen berhasil diunggah dan sedang direview ulang', 'success')">Kirim Dokumen</x-button>
                    </div>
                @endif
            </x-card>
        </div>

        <!-- Right Side: Edit Form -->
        <div class="flex-1">
            <x-card class="shadow-sm border-border-color">
                <x-slot name="header">
                    <h3 class="font-bold text-text-dark">Informasi Usaha</h3>
                </x-slot>
                
                <form onsubmit="event.preventDefault(); showToast('Profil berhasil diperbarui (Dummy)', 'success');" class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-text-dark mb-1">Nama Usaha / Instansi <span class="text-danger">*</span></label>
                            <x-input type="text" value="{{ $provider['company_name'] }}" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-dark mb-1">Jenis Usaha <span class="text-danger">*</span></label>
                            <x-select required>
                                <option value="F&B" {{ $provider['company_type'] == 'F&B' ? 'selected' : '' }}>F&B (Kafe, Restoran)</option>
                                <option value="Retail" {{ $provider['company_type'] == 'Retail' ? 'selected' : '' }}>Retail (Toko, Minimarket)</option>
                                <option value="Jasa" {{ $provider['company_type'] == 'Jasa' ? 'selected' : '' }}>Jasa</option>
                                <option value="Pendidikan" {{ $provider['company_type'] == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                                <option value="Lainnya" {{ $provider['company_type'] == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </x-select>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-text-dark mb-1">Nomor Telepon / WA <span class="text-danger">*</span></label>
                            <x-input type="tel" value="{{ $provider['business_phone'] }}" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-dark mb-1">Email <span class="text-danger">*</span></label>
                            <x-input type="email" value="{{ $user['email'] }}" required disabled title="Email tidak dapat diubah" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-dark mb-1">Alamat Lengkap <span class="text-danger">*</span></label>
                        <x-textarea rows="2" required>{{ $provider['address'] }}</x-textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-dark mb-1">Deskripsi Usaha</label>
                        <x-textarea rows="4">{{ $provider['description'] }}</x-textarea>
                        <p class="text-xs text-text-gray mt-1">Jelaskan secara singkat tentang usaha Anda agar calon pekerja lebih mengenal tempat kerjanya.</p>
                    </div>

                    <div class="pt-4 border-t border-border-color flex justify-end gap-3">
                        <x-button type="button" class="bg-white !text-text-dark border-border-color hover:bg-surface border shadow-sm">Batal</x-button>
                        <x-button type="submit">Simpan Perubahan</x-button>
                    </div>
                </form>
            </x-card>
        </div>

    </div>
</div>

<div id="toast-container" class="fixed bottom-4 right-4 z-[200] flex flex-col gap-2"></div>
<template id="toast-template">
    <div class="toast-item flex items-center w-full max-w-xs p-4 text-text-dark bg-white rounded-md shadow-lg border border-border-color transition-all duration-300 transform translate-x-full opacity-0">
        <div class="toast-icon inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg"></div>
        <div class="toast-message ml-3 text-sm font-medium"></div>
        <button type="button" class="toast-close ml-auto -mx-1.5 -my-1.5 bg-white text-text-gray hover:text-text-dark rounded-md p-1.5 inline-flex items-center justify-center h-8 w-8"><i class="fa-solid fa-xmark"></i></button>
    </div>
</template>
@endsection
