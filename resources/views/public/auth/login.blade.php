@extends('layouts.public')

@section('title', 'Masuk - Partimeku')

@section('content')
<section class="bg-surface py-12 sm:py-16">
    <div class="mx-auto max-w-md px-4 sm:px-6 lg:px-8">
        <div class="rounded-md border border-border-color bg-white p-5 shadow-sm sm:p-6">
            <div class="text-center">
                <h1 class="text-2xl font-semibold text-text-dark">Masuk ke Partimeku</h1>
                <p class="mt-2 text-sm text-text-gray">Gunakan akun mahasiswa atau penyedia.</p>
            </div>

            <form data-dummy-submit data-success-message="Berhasil masuk ke dashboard." class="mt-6 space-y-4">
                <label class="block text-sm font-medium text-text-dark">Email / username<x-input name="login" type="text" class="mt-2" placeholder="Email atau username" required /></label>
                <label class="block text-sm font-medium text-text-dark">Password<x-input name="password" type="password" class="mt-2" placeholder="Password" required /></label>
                <div class="flex items-center justify-between gap-3 text-sm">
                    <label class="inline-flex items-center gap-2 text-text-gray"><x-checkbox name="remember" /> Ingat saya</label>
                    <a href="{{ url('/forgot-password') }}" class="font-medium text-primary">Lupa password?</a>
                </div>
                <button type="submit" class="inline-flex w-full justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">Masuk</button>
            </form>

            <div class="mt-6 border-t border-border-color pt-5 text-center text-sm text-text-gray">
                Belum punya akun?
                <a href="{{ url('/register') }}" class="font-medium text-primary">Daftar sekarang</a>
            </div>
        </div>
    </div>
</section>
@endsection
