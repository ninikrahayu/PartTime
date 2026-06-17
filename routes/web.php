<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PenyediaController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LowonganController;

// ── PUBLIC ROUTES ─────────────────────────────────────────────────────────────
Route::get('/', [PublicController::class, 'landing']);
Route::get('/lowongan', [PublicController::class, 'lowonganList']);
Route::get('/lowongan/{id}', [PublicController::class, 'lowonganDetail']);
Route::get('/login', [PublicController::class, 'login'])->name('login');
Route::get('/register', [PublicController::class, 'registerRole'])->name('register');
Route::get('/register/mahasiswa', [PublicController::class, 'registerMahasiswa'])->name('register.mahasiswa');
Route::get('/register/penyedia', [PublicController::class, 'registerPenyedia'])->name('register.penyedia');
Route::get('/forgot-password', [PublicController::class, 'forgotPassword']);
Route::get('/reset-password', [PublicController::class, 'resetPassword']);

// ── AUTH POST ROUTES ──────────────────────────────────────────────────────────
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── ADMIN ─────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Verifikasi Akun
    Route::get('/verifikasi-akun', [AdminController::class, 'pendingAccounts'])->name('verifikasi.index');
    Route::post('/verifikasi-akun/{id}/approve', [AdminController::class, 'approveAccount'])->name('verifikasi.approve');
    Route::post('/verifikasi-akun/{id}/reject', [AdminController::class, 'rejectAccount'])->name('verifikasi.reject');

    // Verifikasi Lowongan
    Route::get('/verifikasi-lowongan', [AdminController::class, 'verifikasiLowongan'])->name('verifikasi.lowongan');

    // Manajemen Pengguna
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::get('/users/{id}', [AdminController::class, 'showUser'])->name('users.show');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');

    // Kategori
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories.index');

    // Lowongan
    Route::get('/jobs', [AdminController::class, 'jobs'])->name('jobs.index');
    Route::get('/jobs/{id}', [AdminController::class, 'showJob'])->name('jobs.show');

    // Lamaran
    Route::get('/applications', [AdminController::class, 'applications'])->name('applications.index');
    Route::get('/applications/{id}', [AdminController::class, 'showApplication'])->name('applications.show');

    // Laporan & Profil
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
});

// ── MAHASISWA ─────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])->name('dashboard');
    Route::put('/profil', [ProfilController::class, 'updateMahasiswa'])->name('profil.update');

    // Lowongan
    Route::get('/jobs', [MahasiswaController::class, 'jobs'])->name('jobs.index');
    Route::get('/jobs/{id}', [MahasiswaController::class, 'jobDetail'])->name('jobs.show');
    Route::get('/lowongan', [MahasiswaController::class, 'cariLowongan'])->name('lowongan.index');
    Route::post('/lowongan/{lowongan_id}/lamar', [MahasiswaController::class, 'lamarPekerjaan'])->name('lowongan.lamar');

    // Lamaran / Applications
    Route::get('/lamaran-saya', [MahasiswaController::class, 'statusLamaran'])->name('lamaran.status');
    Route::get('/applications', [MahasiswaController::class, 'applications'])->name('applications.index');
    Route::get('/applications/{id}', [MahasiswaController::class, 'applicationDetail'])->name('applications.show');

    // Lainnya
    Route::get('/favorites', [MahasiswaController::class, 'favorites'])->name('favorites');
    Route::get('/reviews', [MahasiswaController::class, 'reviews'])->name('reviews');
    Route::get('/profile', [MahasiswaController::class, 'profile'])->name('profile');
});

// ── PENYEDIA ──────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:penyedia'])->prefix('penyedia')->name('penyedia.')->group(function () {
    Route::get('/dashboard', [PenyediaController::class, 'dashboard'])->name('dashboard');
    Route::put('/profil', [ProfilController::class, 'updatePenyedia'])->name('profil.update');
    Route::get('/profil-usaha', [PenyediaController::class, 'profilUsaha'])->name('profil.usaha');

    // Lowongan CRUD — LowonganController
    Route::get('/lowongan', [LowonganController::class, 'index'])->name('lowongan.index');
    Route::post('/lowongan', [LowonganController::class, 'store'])->name('lowongan.store');
    Route::put('/lowongan/{id}', [LowonganController::class, 'update'])->name('lowongan.update');
    Route::get('/lowongan/{id}/pelamar', [LowonganController::class, 'daftarPelamar'])->name('lowongan.pelamar');

    // Lamaran Status
    Route::put('/lamaran/{lamaran_id}/status', [LowonganController::class, 'ubahStatusLamaran'])->name('lamaran.status');

    // Jobs UI (tampilan) — PenyediaController
    // PENTING: Route dengan segment statis (/jobs/create) harus SEBELUM route parameter (/jobs/{id})
    Route::get('/jobs', [PenyediaController::class, 'jobs'])->name('jobs.index');
    Route::get('/jobs/create', [PenyediaController::class, 'jobCreate'])->name('jobs.create');
    Route::get('/jobs/{id}', [PenyediaController::class, 'jobDetail'])->name('jobs.show');
    Route::get('/jobs/{id}/edit', [PenyediaController::class, 'jobEdit'])->name('jobs.edit');

    // Lamaran UI — PenyediaController
    Route::get('/applications', [PenyediaController::class, 'applications'])->name('applications.index');
    Route::get('/applications/{id}', [PenyediaController::class, 'applicationDetail'])->name('applications.show');

    // Lainnya
    Route::get('/reviews', [PenyediaController::class, 'reviews'])->name('reviews');
    Route::get('/profile', [PenyediaController::class, 'profile'])->name('profile');
});