<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // 1. Memperbaiki Key 'label' pada Summary Cards
        $summaryCards = [
            ['label' => 'Total Pengguna', 'value' => \App\Models\User::count(), 'icon' => 'fa-users', 'trend' => '+5%'],
            ['label' => 'Menunggu Verifikasi', 'value' => \App\Models\User::where('status', 'pending')->count(), 'icon' => 'fa-user-clock', 'trend' => 'Cek sekarang'],
            ['label' => 'Lowongan Aktif', 'value' => \App\Models\Lowongan::where('status', 'active')->count(), 'icon' => 'fa-briefcase'],
            ['label' => 'Total Lamaran', 'value' => 0, 'icon' => 'fa-file-lines'],
        ];

        // 2. Menyiapkan Additional Stats
        $additionalStats = [
            ['label' => 'UMKM Terdaftar', 'value' => \App\Models\User::where('role', 'penyedia')->count()],
            ['label' => 'Mahasiswa Aktif', 'value' => \App\Models\User::where('role', 'mahasiswa')->count()],
            ['label' => 'Lowongan Ditolak', 'value' => \App\Models\Lowongan::where('status', 'rejected')->count()],
            ['label' => 'Pekerjaan Selesai', 'value' => 0],
        ];

        // 3. Menyiapkan Data Grafik (Kosong sementara agar tidak error)
        $charts = [
            'jobs_per_month' => ['labels' => ['Jan', 'Feb', 'Mar'], 'data' => [0, 0, 0]],
            'applicants_per_month' => ['labels' => ['Jan', 'Feb', 'Mar'], 'data' => [0, 0, 0]]
        ];

        // 4. Menyiapkan List Data Bawah
        $recentApplications = []; // Tabel lamaran belum siap, kita kosongkan dulu

        // Menarik UMKM yang menunggu verifikasi
        $pendingAccounts = \App\Models\User::where('status', 'pending')->latest()->take(5)->get()->map(function($u) {
            return [
                'name' => $u->name,
                'role' => $u->role,
                'created_at' => $u->created_at->diffForHumans(),
                'verification_status' => $u->status
            ];
        });

        // Menarik Lowongan yang menunggu verifikasi Admin
        $pendingJobs = \App\Models\Lowongan::with('penyedia')->where('status', 'pending')->latest()->take(5)->get()->map(function($j) {
            return [
                'title' => $j->title,
                'provider_name' => $j->penyedia ? $j->penyedia->name : 'Tanpa Nama',
                'category' => 'Kategori Baru',
                'status' => $j->status,
                'created_at' => $j->created_at->diffForHumans()
            ];
        });

        return view('admin.dashboard', compact(
            'user', 'summaryCards', 'additionalStats', 'charts', 
            'recentApplications', 'pendingAccounts', 'pendingJobs'
        ));
    }

    // Biarkan fungsi lain return view sementara
    public function verifikasiAkun() { return view('admin.verifikasi.akun'); }
    public function verifikasiLowongan() { return view('admin.verifikasi.lowongan'); }
    public function users() { return view('admin.users.index'); }
    public function profile() { 
        $user = Auth::user();
        return view('admin.profile.index', compact('user')); 
    }
}