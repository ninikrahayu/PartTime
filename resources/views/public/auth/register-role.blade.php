@extends('layouts.public')

@section('title', 'Daftar Akun - Partimeku')

@section('content')
<section class="bg-surface py-12 sm:py-16">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <h1 class="text-3xl font-semibold text-text-dark sm:text-4xl">Pilih Jenis Akun</h1>
            <p class="mt-3 text-base text-text-gray">Daftar sesuai kebutuhan kamu di Partimeku.</p>
        </div>

        <div class="mt-10 grid gap-6 md:grid-cols-2">
            <a href="{{ url('/register/mahasiswa') }}" class="rounded-md border border-border-color bg-white p-6 shadow-sm transition-colors hover:border-primary hover:text-primary">
                <div class="flex h-12 w-12 items-center justify-center rounded-md bg-primary/10 text-primary">
                    <i class="fa-solid fa-user-graduate text-xl"></i>
                </div>
                <h2 class="mt-5 text-xl font-semibold text-text-dark">Daftar sebagai Mahasiswa</h2>
                <p class="mt-2 text-sm leading-6 text-text-gray">Cari lowongan part time, simpan favorit, ajukan lamaran, dan bangun reputasi kerja.</p>
                <span class="mt-6 inline-flex items-center text-sm font-medium text-primary">
                    Lanjut daftar
                    <i class="fa-solid fa-arrow-right ml-2"></i>
                </span>
            </a>

            <a href="{{ url('/register/penyedia') }}" class="rounded-md border border-border-color bg-white p-6 shadow-sm transition-colors hover:border-primary hover:text-primary">
                <div class="flex h-12 w-12 items-center justify-center rounded-md bg-secondary/20 text-text-dark">
                    <i class="fa-solid fa-building text-xl"></i>
                </div>
                <h2 class="mt-5 text-xl font-semibold text-text-dark">Daftar sebagai Penyedia</h2>
                <p class="mt-2 text-sm leading-6 text-text-gray">Pasang lowongan, kelola pelamar, dan temukan mahasiswa yang sesuai kebutuhan kerja.</p>
                <span class="mt-6 inline-flex items-center text-sm font-medium text-primary">
                    Lanjut daftar
                    <i class="fa-solid fa-arrow-right ml-2"></i>
                </span>
            </a>
        </div>
    </div>
</section>
@endsection
