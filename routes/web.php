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
    Route::get('/users/export/xls', [AdminController::class, 'exportUsersXls'])->name('users.export.xls');
    Route::get('/users/export/pdf', [AdminController::class, 'exportUsersPdf'])->name('users.export.pdf');
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{id}', [AdminController::class, 'showUser'])->name('users.show');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::put('/users/{id}/toggle-active', [AdminController::class, 'toggleActiveUser'])->name('users.toggle-active');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    // Kategori
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories.index');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categories/{id}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');

    // Lowongan
    Route::get('/jobs/export/xls', [AdminController::class, 'exportJobsXls'])->name('jobs.export.xls');
    Route::get('/jobs/export/pdf', [AdminController::class, 'exportJobsPdf'])->name('jobs.export.pdf');
    Route::get('/jobs', [AdminController::class, 'jobs'])->name('jobs.index');
    Route::get('/jobs/{id}', [AdminController::class, 'showJob'])->name('jobs.show');
    Route::put('/jobs/{id}/status', [AdminController::class, 'updateJobStatus'])->name('jobs.status');
    Route::delete('/jobs/{id}', [AdminController::class, 'destroyJob'])->name('jobs.destroy');

    // Lamaran
    Route::get('/applications/export/xls', [AdminController::class, 'exportApplicationsXls'])->name('applications.export.xls');
    Route::get('/applications/export/pdf', [AdminController::class, 'exportApplicationsPdf'])->name('applications.export.pdf');
    Route::get('/applications', [AdminController::class, 'applications'])->name('applications.index');
    Route::get('/applications/{id}', [AdminController::class, 'showApplication'])->name('applications.show');
    Route::put('/applications/{id}/status', [AdminController::class, 'updateApplicationStatus'])->name('applications.status');
    Route::delete('/applications/{id}', [AdminController::class, 'destroyApplication'])->name('applications.destroy');

    // Laporan & Profil
    Route::get('/reports/export/xls', [AdminController::class, 'exportReportsXls'])->name('reports.export.xls');
    Route::get('/reports/export/pdf', [AdminController::class, 'exportReportsPdf'])->name('reports.export.pdf');
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::post('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');
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