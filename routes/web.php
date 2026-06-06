<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PenyediaController;

// Public Routes
Route::get('/', [PublicController::class, 'landing']);
Route::get('/lowongan', [PublicController::class, 'lowonganList']);
Route::get('/lowongan/{id}', [PublicController::class, 'lowonganDetail']);
Route::get('/register', [PublicController::class, 'registerRole']);
Route::get('/register/mahasiswa', [PublicController::class, 'registerMahasiswa']);
Route::get('/register/penyedia', [PublicController::class, 'registerPenyedia']);
Route::get('/login', [PublicController::class, 'login']);
Route::get('/forgot-password', [PublicController::class, 'forgotPassword']);
Route::get('/reset-password', [PublicController::class, 'resetPassword']);

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/verifikasi-akun', [AdminController::class, 'verifikasiAkun']);
    Route::get('/verifikasi-lowongan', [AdminController::class, 'verifikasiLowongan']);
    Route::get('/users', [AdminController::class, 'users']);
    Route::get('/users/{id}', [AdminController::class, 'showUser']);
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser']);
    Route::get('/categories', [AdminController::class, 'categories']);
    Route::get('/categories/{id}/edit', [AdminController::class, 'editCategory']);
    Route::get('/jobs', [AdminController::class, 'jobs']);
    Route::get('/jobs/{id}', [AdminController::class, 'showJob']);
    Route::get('/applications', [AdminController::class, 'applications']);
    Route::get('/applications/{id}', [AdminController::class, 'showApplication']);
    Route::get('/reports', [AdminController::class, 'reports']);
    Route::get('/profile', [AdminController::class, 'profile']);
});

// Mahasiswa Routes
Route::prefix('mahasiswa')->group(function () {
    Route::get('/dashboard', [MahasiswaController::class, 'dashboard']);
    Route::get('/jobs', [MahasiswaController::class, 'jobs']);
    Route::get('/jobs/{id}', [MahasiswaController::class, 'jobDetail']);
    Route::get('/favorites', [MahasiswaController::class, 'favorites']);
    Route::get('/applications', [MahasiswaController::class, 'applications']);
    Route::get('/applications/{id}', [MahasiswaController::class, 'applicationDetail']);
    Route::get('/reviews', [MahasiswaController::class, 'reviews']);
    Route::get('/profile', [MahasiswaController::class, 'profile']);
});

// Penyedia Routes
Route::prefix('penyedia')->group(function () {
    Route::get('/dashboard', [PenyediaController::class, 'dashboard']);
    Route::get('/profil-usaha', [PenyediaController::class, 'profilUsaha']);
    Route::get('/jobs', [PenyediaController::class, 'jobs']);
    Route::get('/jobs/create', [PenyediaController::class, 'jobCreate']);
    Route::get('/jobs/{id}', [PenyediaController::class, 'jobDetail']);
    Route::get('/jobs/{id}/edit', [PenyediaController::class, 'jobEdit']);
    Route::get('/applications', [PenyediaController::class, 'applications']);
    Route::get('/applications/{id}', [PenyediaController::class, 'applicationDetail']);
    Route::get('/reviews', [PenyediaController::class, 'reviews']);
    Route::get('/profile', [PenyediaController::class, 'profile']);
});

Route::middleware(['auth'])->prefix('mahasiswa')->group(function () {
    Route::put('/profil', [ProfilController::class, 'updateMahasiswa'])->name('mahasiswa.profil.update');
    Route::get('/lowongan', [MahasiswaController::class, 'cariLowongan'])->name('mahasiswa.lowongan.index');
    Route::post('/lowongan/{lowongan_id}/lamar', [MahasiswaController::class, 'lamarPekerjaan'])->name('mahasiswa.lowongan.lamar');
    Route::get('/lamaran-saya', [MahasiswaController::class, 'statusLamaran'])->name('mahasiswa.lamaran.status');
});