<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PenyediaController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LowonganController;

Route::get('/', [PublicController::class, 'landing']);
Route::get('/lowongan', [PublicController::class, 'lowonganList']);
Route::get('/lowongan/{id}', [PublicController::class, 'lowonganDetail']);
Route::get('/login', [PublicController::class, 'login'])->name('login');
Route::get('/register', [PublicController::class, 'registerRole'])->name('register');
Route::get('/register/mahasiswa', [PublicController::class, 'registerMahasiswa'])->name('register.mahasiswa');
Route::get('/register/penyedia', [PublicController::class, 'registerPenyedia'])->name('register.penyedia');
Route::get('/forgot-password', [PublicController::class, 'forgotPassword']);
Route::get('/reset-password', [PublicController::class, 'resetPassword']);

// ==========================================
// RUTE KHUSUS ADMIN (Digembok wajib login & role admin)
// ==========================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/verifikasi-akun', [AdminController::class, 'verifikasiAkun']);
    Route::get('/verifikasi-lowongan', [AdminController::class, 'verifikasiLowongan']);
    Route::get('/users', [AdminController::class, 'users']);
    Route::get('/users/create', [AdminController::class, 'createUser']);
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

// ==========================================
// RUTE KHUSUS MAHASISWA (Digembok wajib login & role mahasiswa)
// ==========================================
Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->group(function () {
    Route::put('/profil', [ProfilController::class, 'updateMahasiswa'])->name('mahasiswa.profil.update');
    Route::get('/dashboard', [MahasiswaController::class, 'dashboard']);
    Route::get('/jobs', [MahasiswaController::class, 'jobs']);
    Route::get('/jobs/{id}', [MahasiswaController::class, 'jobDetail']);
    Route::get('/favorites', [MahasiswaController::class, 'favorites']);
    Route::get('/applications', [MahasiswaController::class, 'applications']);
    Route::get('/applications/{id}', [MahasiswaController::class, 'applicationDetail']);
    Route::get('/reviews', [MahasiswaController::class, 'reviews']);
    Route::get('/profile', [MahasiswaController::class, 'profile']);
});

// ==========================================
// RUTE KHUSUS PENYEDIA (Digembok wajib login & role penyedia)
// ==========================================
Route::middleware(['auth', 'role:penyedia'])->prefix('penyedia')->group(function () {
    Route::put('/profil', [ProfilController::class, 'updatePenyedia'])->name('penyedia.profil.update');
    Route::get('/lowongan/{id}/pelamar', [LowonganController::class, 'daftarPelamar'])->name('penyedia.lowongan.pelamar');
    Route::put('/lamaran/{lamaran_id}/status', [LowonganController::class, 'ubahStatusLamaran'])->name('penyedia.lamaran.status');
    Route::get('/dashboard', [PenyediaController::class, 'dashboard']);
    Route::get('/profil-usaha', [PenyediaController::class, 'profilUsaha']);
    Route::get('/jobs', [PenyediaController::class, 'jobs']);
    Route::get('/jobs/create', [PenyediaController::class, 'jobCreate']);
    Route::post('/jobs', [PenyediaController::class, 'jobStore'])->name('penyedia.jobs.store');
    Route::get('/jobs/{id}', [PenyediaController::class, 'jobDetail']);
    Route::get('/jobs/{id}/edit', [PenyediaController::class, 'jobEdit']);
    Route::get('/applications', [PenyediaController::class, 'applications']);
    Route::get('/applications/{id}', [PenyediaController::class, 'applicationDetail']);
    Route::get('/reviews', [PenyediaController::class, 'reviews']);
    Route::get('/profile', [PenyediaController::class, 'profile']);
});

Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
