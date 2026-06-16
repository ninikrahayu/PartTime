@extends('layouts.penyedia')

@section('title', 'Tambah Lowongan - Penyedia Partimeku')
@section('page_title', 'Tambah Lowongan')

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <div>
        <p class="text-sm font-medium text-primary">Manajemen Lowongan</p>
        <h2 class="mt-1 text-2xl font-semibold text-text-dark">Tambah Lowongan</h2>
        <p class="mt-1 text-sm text-text-gray">Lowongan baru akan berstatus Menunggu Review sebelum tampil ke mahasiswa.</p>
    </div>

    <x-card>
        <form data-provider-job-form class="space-y-8">
            @csrf
            <div>
                <h3 class="text-base font-semibold text-text-dark">Informasi Pekerjaan</h3>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <label class="block text-sm font-medium text-text-dark">
                        Nama pekerjaan
                        <x-input name="title" type="text" class="mt-2" placeholder="Contoh: Barista Part Time Sore" required />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Kategori pekerjaan
                        <x-select name="category_id" class="mt-2" required>
                            <option value="">Pilih kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                            @endforeach
                        </x-select>
                    </label>
                    <label class="block text-sm font-medium text-text-dark sm:col-span-2">
                        Deskripsi pekerjaan
                        <x-textarea name="description" rows="5" class="mt-2" placeholder="Jelaskan tanggung jawab pekerjaan" required></x-textarea>
                    </label>
                    <label class="block text-sm font-medium text-text-dark sm:col-span-2">
                        Syarat pekerjaan
                        <x-textarea name="requirements" rows="4" class="mt-2" placeholder="Tulis syarat per baris" required></x-textarea>
                    </label>
                </div>
            </div>

            <div>
                <h3 class="text-base font-semibold text-text-dark">Lokasi, Gaji, dan Jadwal</h3>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <label class="block text-sm font-medium text-text-dark">
                        Lokasi
                        <x-input name="location" type="text" class="mt-2" placeholder="Alamat atau area kerja" required />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Gaji / upah
                        <x-input name="salary" type="number" class="mt-2" placeholder="50000" required />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Tipe gaji
                        <x-select name="salary_type" class="mt-2" required>
                            <option value="">Pilih tipe gaji</option>
                            @foreach($salaryTypes as $type)
                                <option>{{ $type }}</option>
                            @endforeach
                        </x-select>
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Jadwal kerja
                        <x-input name="schedule" type="text" class="mt-2" placeholder="Sabtu - Minggu, 09.00 - 17.00" required />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Tanggal mulai kerja
                        <x-input name="start_date" type="date" class="mt-2" required />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Tanggal akhir kerja
                        <x-input name="end_date" type="date" class="mt-2" required />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Kuota
                        <x-input name="quota" type="number" class="mt-2" placeholder="2" required />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Batas akhir lamaran
                        <x-input name="deadline" type="date" class="mt-2" required />
                    </label>
                    <label class="block text-sm font-medium text-text-dark sm:col-span-2">
                        Kontak tambahan opsional
                        <x-input name="contact" type="text" class="mt-2" placeholder="Nomor WhatsApp atau email opsional" />
                    </label>
                </div>
            </div>

            <div class="rounded-md border border-warning/20 bg-warning/5 p-4 text-sm text-warning">
                Setelah disubmit, status lowongan menjadi Menunggu Review.
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-border-color pt-6 sm:flex-row sm:justify-between">
                <a href="{{ url('/penyedia/jobs') }}" class="inline-flex justify-center rounded-md border border-border-color bg-white px-4 py-2 text-sm font-medium text-text-dark hover:bg-surface">Batal</a>
                <button type="submit" class="inline-flex justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-blue-900">Kirim Lowongan</button>
            </div>
        </form>
    </x-card>
</div>
@endsection

