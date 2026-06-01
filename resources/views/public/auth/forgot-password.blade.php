@extends('layouts.public')

@section('title', 'Lupa Password - Partimeku')

@section('content')
<section class="bg-surface py-12 sm:py-16">
    <div class="mx-auto max-w-md px-4 sm:px-6 lg:px-8">
        <div class="rounded-md border border-border-color bg-white p-5 shadow-sm sm:p-6">
            <h1 class="text-2xl font-semibold text-text-dark">Lupa Password</h1>
            <p class="mt-2 text-sm text-text-gray">Masukkan email akun. Link reset ditampilkan sebagai simulasi frontend.</p>

            <form data-dummy-submit data-success-message="Instruksi reset password berhasil dikirim." class="mt-6 space-y-4">
                <label class="block text-sm font-medium text-text-dark">Email<x-input name="email" type="email" class="mt-2" placeholder="nama@email.com" required /></label>
                <button type="submit" class="inline-flex w-full justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">Kirim Instruksi</button>
            </form>

            <a href="{{ url('/login') }}" class="mt-5 inline-flex text-sm font-medium text-primary">
                <i class="fa-solid fa-arrow-left mr-2 mt-0.5"></i>
                Kembali ke login
            </a>
        </div>
    </div>
</section>
@endsection
