@extends('layouts.public')

@section('title', 'Daftar Mahasiswa - Partimeku')

@section('content')
<section class="bg-surface py-10 sm:py-14">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <div class="rounded-md border border-border-color bg-white shadow-sm">
            <div class="border-b border-border-color px-5 py-5 sm:px-6">
                <p class="text-sm font-medium text-primary">Akun Mahasiswa</p>
                <h1 class="mt-1 text-2xl font-semibold text-text-dark">Daftar sebagai Mahasiswa</h1>
                <p class="mt-2 text-sm text-text-gray">Lengkapi data akun, data kampus, dan upload KTM untuk proses verifikasi.</p>
            </div>

            <form data-dummy-submit data-success-message="Pendaftaran mahasiswa berhasil dikirim. Status akun Menunggu Verifikasi." class="space-y-8 p-5 sm:p-6">
                <div>
                    <h2 class="text-base font-semibold text-text-dark">Data Akun</h2>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <label class="block text-sm font-medium text-text-dark">Nama lengkap<x-input name="name" type="text" class="mt-2" placeholder="Nama lengkap" required /></label>
                        <label class="block text-sm font-medium text-text-dark">Email<x-input name="email" type="email" class="mt-2" placeholder="nama@email.com" required /></label>
                        <label class="block text-sm font-medium text-text-dark">Username<x-input name="username" type="text" class="mt-2" placeholder="username" required /></label>
                        <label class="block text-sm font-medium text-text-dark">Nomor telepon<x-input name="phone" type="tel" class="mt-2" placeholder="08xxxxxxxxxx" required /></label>
                        <label class="block text-sm font-medium text-text-dark">Password<x-input name="password" type="password" class="mt-2" placeholder="Minimal 8 karakter" required /></label>
                        <label class="block text-sm font-medium text-text-dark">Konfirmasi password<x-input name="password_confirmation" type="password" class="mt-2" placeholder="Ulangi password" required /></label>
                    </div>
                </div>

                <div>
                    <h2 class="text-base font-semibold text-text-dark">Data Mahasiswa</h2>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <label class="block text-sm font-medium text-text-dark">Nama kampus<x-input name="campus" type="text" class="mt-2" placeholder="Nama kampus" required /></label>
                        <label class="block text-sm font-medium text-text-dark">Jurusan<x-input name="major" type="text" class="mt-2" placeholder="Jurusan" required /></label>
                        <label class="block text-sm font-medium text-text-dark">Semester<x-select name="semester" class="mt-2" required><option value="">Pilih semester</option>@for($i = 1; $i <= 14; $i++)<option value="{{ $i }}">{{ $i }}</option>@endfor</x-select></label>
                        <label class="block text-sm font-medium text-text-dark sm:col-span-2">Alamat<x-textarea name="address" rows="4" class="mt-2" placeholder="Alamat domisili" required></x-textarea></label>
                    </div>
                </div>

                <x-upload-document-card name="ktm" title="Upload KTM" description="KTM digunakan untuk verifikasi akun mahasiswa." formats="JPG, PNG, PDF" maxSize="2MB" accept=".jpg,.jpeg,.png,.pdf" />

                <div class="flex flex-col-reverse gap-3 border-t border-border-color pt-6 sm:flex-row sm:justify-between">
                    <a href="{{ url('/register') }}" class="inline-flex justify-center rounded-md border border-border-color bg-white px-4 py-2 text-sm font-medium text-text-dark hover:bg-surface">Kembali</a>
                    <button type="submit" class="inline-flex justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">Daftar Mahasiswa</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
