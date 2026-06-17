@extends('layouts.penyedia')

@section('title', 'Tambah Lowongan - Penyedia Partimeku')
@section('page_title', 'Tambah Lowongan')

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <div>
        <p class="text-sm font-medium text-primary">Manajemen Lowongan</p>
        <h2 class="mt-1 text-2xl font-semibold text-text-dark">Tambah Lowongan</h2>
        <p class="mt-1 text-sm text-text-gray">Lowongan baru akan langsung aktif dan tampil ke mahasiswa.</p>
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
        <form action="{{ route('penyedia.lowongan.store') }}" method="POST" class="space-y-8">
            @csrf
            <div>
                <h3 class="text-base font-semibold text-text-dark">Informasi Pekerjaan</h3>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <label class="block text-sm font-medium text-text-dark">
                        Nama pekerjaan
                        <x-input name="judul" type="text" class="mt-2" placeholder="Contoh: Barista Part Time Sore" value="{{ old('judul') }}" required />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Kategori pekerjaan
                        <x-select name="category" class="mt-2">
                            <option value="">Pilih kategori</option>
                            <option value="F&B (Cafe/Resto)" {{ old('category') == 'F&B (Cafe/Resto)' ? 'selected' : '' }}>F&B (Cafe/Resto)</option>
                            <option value="Retail (Toko/Minimarket)" {{ old('category') == 'Retail (Toko/Minimarket)' ? 'selected' : '' }}>Retail (Toko/Minimarket)</option>
                            <option value="IT / Freelance" {{ old('category') == 'IT / Freelance' ? 'selected' : '' }}>IT / Freelance</option>
                            <option value="Event / Usher" {{ old('category') == 'Event / Usher' ? 'selected' : '' }}>Event / Usher</option>
                            <option value="Administrasi" {{ old('category') == 'Administrasi' ? 'selected' : '' }}>Administrasi</option>
                            <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </x-select>
                    </label>
                    <label class="block text-sm font-medium text-text-dark sm:col-span-2">
                        Deskripsi pekerjaan
                        <x-textarea name="deskripsi" rows="5" class="mt-2" placeholder="Jelaskan tanggung jawab pekerjaan" required>{{ old('deskripsi') }}</x-textarea>
                    </label>
                    <label class="block text-sm font-medium text-text-dark sm:col-span-2">
                        Syarat / Kriteria pekerjaan
                        <x-textarea name="kriteria" rows="4" class="mt-2" placeholder="Tulis syarat per baris">{{ old('kriteria') }}</x-textarea>
                    </label>
                </div>
            </div>

            <div>
                <h3 class="text-base font-semibold text-text-dark">Lokasi, Gaji, dan Jadwal</h3>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <label class="block text-sm font-medium text-text-dark">
                        Lokasi
                        <x-input name="lokasi" type="text" class="mt-2" placeholder="Alamat atau area kerja" value="{{ old('lokasi') }}" required />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Gaji / upah
                        <x-input name="gaji" type="number" class="mt-2" placeholder="50000" value="{{ old('gaji') }}" />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Tipe gaji
                        <x-select name="salary_type" class="mt-2">
                            <option value="">Pilih tipe gaji</option>
                            <option value="Per Jam" {{ old('salary_type') == 'Per Jam' ? 'selected' : '' }}>Per Jam</option>
                            <option value="Per Hari" {{ old('salary_type') == 'Per Hari' ? 'selected' : '' }}>Per Hari</option>
                            <option value="Per Bulan" {{ old('salary_type') == 'Per Bulan' ? 'selected' : '' }}>Per Bulan</option>
                            <option value="Project Based" {{ old('salary_type') == 'Project Based' ? 'selected' : '' }}>Project Based</option>
                        </x-select>
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Jadwal / Shift kerja
                        <x-input name="shift" type="text" class="mt-2" placeholder="Sabtu - Minggu, 09.00 - 17.00" value="{{ old('shift') }}" required />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Tanggal mulai kerja
                        <x-input name="start_date" type="date" class="mt-2" value="{{ old('start_date') }}" />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Tanggal akhir kerja
                        <x-input name="end_date" type="date" class="mt-2" value="{{ old('end_date') }}" />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Kuota
                        <x-input name="quota" type="number" class="mt-2" placeholder="2" value="{{ old('quota') }}" />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Batas akhir lamaran
                        <x-input name="deadline" type="date" class="mt-2" value="{{ old('deadline') }}" />
                    </label>
                    <label class="block text-sm font-medium text-text-dark sm:col-span-2">
                        Kontak tambahan (opsional)
                        <x-input name="contact" type="text" class="mt-2" placeholder="Nomor WhatsApp atau email opsional" value="{{ old('contact') }}" />
                    </label>
                </div>
            </div>

            <div class="rounded-md border border-warning/20 bg-warning/5 p-4 text-sm text-warning">
                Setelah disubmit, lowongan akan langsung aktif dan tampil ke mahasiswa.
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-border-color pt-6 sm:flex-row sm:justify-between">
                <a href="{{ url('/penyedia/jobs') }}" class="inline-flex justify-center rounded-md border border-border-color bg-white px-4 py-2 text-sm font-medium text-text-dark hover:bg-surface">Batal</a>
                <button type="submit" class="inline-flex justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-blue-900">Kirim Lowongan</button>
            </div>
        </form>
    </x-card>
</div>
@endsection
