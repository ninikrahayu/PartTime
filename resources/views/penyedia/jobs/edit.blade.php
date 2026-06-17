@extends('layouts.penyedia')

@section('title', 'Edit Lowongan - Penyedia Partimeku')
@section('page_title', 'Edit Lowongan')

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-sm font-medium text-primary">Manajemen Lowongan</p>
            <h2 class="mt-1 text-2xl font-semibold text-text-dark">Edit Lowongan</h2>
            <p class="mt-1 text-sm text-text-gray">{{ $job->judul }}</p>
        </div>
        <x-status-badge :status="$job->status" />
    </div>

    @if(session('success'))
        <div class="rounded-md bg-green-50 p-4 border border-green-200">
            <p class="text-sm font-medium text-green-800"><i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}</p>
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-md bg-red-50 p-4 border border-red-200">
            <p class="text-sm font-bold text-red-800 mb-2"><i class="fa-solid fa-triangle-exclamation mr-2"></i>Ada kesalahan:</p>
            <ul class="list-disc pl-5 text-sm font-medium text-red-800 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <x-card>
        <form action="{{ route('penyedia.lowongan.update', $job->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            <div>
                <h3 class="text-base font-semibold text-text-dark">Informasi Pekerjaan</h3>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <label class="block text-sm font-medium text-text-dark">
                        Nama pekerjaan
                        <x-input name="judul" type="text" class="mt-2" :value="old('judul', $job->judul)" required />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Kategori pekerjaan
                        <x-select name="category" class="mt-2">
                            <option value="">Pilih kategori</option>
                            @foreach(['F&B (Cafe/Resto)', 'Retail (Toko/Minimarket)', 'IT / Freelance', 'Event / Usher', 'Administrasi', 'Lainnya'] as $cat)
                                <option value="{{ $cat }}" @selected(old('category', $job->category) === $cat)>{{ $cat }}</option>
                            @endforeach
                        </x-select>
                    </label>
                    <label class="block text-sm font-medium text-text-dark sm:col-span-2">
                        Deskripsi pekerjaan
                        <x-textarea name="deskripsi" rows="5" class="mt-2" required>{{ old('deskripsi', $job->deskripsi) }}</x-textarea>
                    </label>
                    <label class="block text-sm font-medium text-text-dark sm:col-span-2">
                        Syarat / Kriteria pekerjaan
                        <x-textarea name="kriteria" rows="4" class="mt-2">{{ old('kriteria', $job->kriteria) }}</x-textarea>
                    </label>
                </div>
            </div>

            <div>
                <h3 class="text-base font-semibold text-text-dark">Lokasi, Gaji, dan Jadwal</h3>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <label class="block text-sm font-medium text-text-dark">
                        Lokasi
                        <x-input name="lokasi" type="text" class="mt-2" :value="old('lokasi', $job->lokasi)" required />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Gaji / upah
                        <x-input name="gaji" type="number" class="mt-2" :value="old('gaji', $job->gaji)" />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Tipe gaji
                        <x-select name="salary_type" class="mt-2">
                            <option value="">Pilih tipe gaji</option>
                            @foreach(['Per Jam', 'Per Hari', 'Per Bulan', 'Project Based'] as $type)
                                <option value="{{ $type }}" @selected(old('salary_type', $job->salary_type) === $type)>{{ $type }}</option>
                            @endforeach
                        </x-select>
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Jadwal / Shift kerja
                        <x-input name="shift" type="text" class="mt-2" :value="old('shift', $job->shift)" required />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Tanggal mulai kerja
                        <x-input name="start_date" type="date" class="mt-2" :value="old('start_date', $job->start_date)" />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Tanggal akhir kerja
                        <x-input name="end_date" type="date" class="mt-2" :value="old('end_date', $job->end_date)" />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Kuota
                        <x-input name="quota" type="number" class="mt-2" :value="old('quota', $job->quota)" />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Batas akhir lamaran
                        <x-input name="deadline" type="date" class="mt-2" :value="old('deadline', $job->deadline)" />
                    </label>
                    <label class="block text-sm font-medium text-text-dark sm:col-span-2">
                        Kontak tambahan (opsional)
                        <x-input name="contact" type="text" class="mt-2" placeholder="Nomor WhatsApp atau email opsional" :value="old('contact', $job->contact)" />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Status Lowongan
                        <x-select name="status" class="mt-2" required>
                            <option value="aktif" @selected(old('status', $job->status) === 'aktif')>Aktif</option>
                            <option value="closed" @selected(old('status', $job->status) === 'closed')>Ditutup</option>
                        </x-select>
                    </label>
                </div>
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-border-color pt-6 sm:flex-row sm:justify-between">
                <a href="{{ url('/penyedia/jobs/'.$job->id) }}" class="inline-flex justify-center rounded-md border border-border-color bg-white px-4 py-2 text-sm font-medium text-text-dark hover:bg-surface">Batal</a>
                <button type="submit" class="inline-flex justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-blue-900">Simpan Perubahan</button>
            </div>
        </form>
    </x-card>
</div>
@endsection
