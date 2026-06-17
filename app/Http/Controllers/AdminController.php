<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lowongan;
use App\Models\Lamaran;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalMahasiswa  = User::where('role', 'mahasiswa')->count();
        $totalPenyedia   = User::where('role', 'penyedia')->count();
        $totalLowongan   = Lowongan::count();
        $totalLamaran    = Lamaran::count();
        $pendingAccounts = User::where('status', 'pending')->count();

        $summaryCards = [
            ['label' => 'Total Mahasiswa',   'value' => $totalMahasiswa,  'icon' => 'fa-user-graduate', 'color' => 'text-primary'],
            ['label' => 'Total Penyedia',    'value' => $totalPenyedia,   'icon' => 'fa-building',      'color' => 'text-info'],
            ['label' => 'Total Lowongan',    'value' => $totalLowongan,   'icon' => 'fa-briefcase',     'color' => 'text-success'],
            ['label' => 'Total Lamaran',     'value' => $totalLamaran,    'icon' => 'fa-file-lines',    'color' => 'text-warning'],
        ];

        $pendingAccountsList  = User::where('status', 'pending')->latest()->take(5)->get();
        $recentApplications   = Lamaran::with(['pelamar', 'lowongan.penyedia'])->latest()->take(5)->get();
        $recentLowongans      = Lowongan::with('penyedia')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'summaryCards',
            'pendingAccounts',
            'pendingAccountsList',
            'recentApplications',
            'recentLowongans'
        ));
    }

    // ── VERIFIKASI AKUN ─────────────────────────────────────────────────────────

    public function pendingAccounts()
    {
        $students  = User::where('role', 'mahasiswa')->with('profile')->latest()->get();
        $providers = User::where('role', 'penyedia')->with('profile')->latest()->get();

        $verificationStatuses = [
            ['value' => 'pending',  'label' => 'Menunggu Verifikasi'],
            ['value' => 'verified', 'label' => 'Terverifikasi'],
            ['value' => 'rejected', 'label' => 'Ditolak'],
        ];

        return view('admin.verifikasi.akun', compact('students', 'providers', 'verificationStatuses'));
    }

    public function approveAccount(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'verified']);

        return back()->with('success', "Akun {$user->name} berhasil diverifikasi.");
    }

    public function rejectAccount(Request $request, $id)
    {
        $request->validate(['reason' => 'nullable|string|max:500']);

        $user = User::findOrFail($id);
        $user->update(['status' => 'rejected']);

        return back()->with('success', "Akun {$user->name} berhasil ditolak.");
    }

    // ── VERIFIKASI LOWONGAN ──────────────────────────────────────────────────────

    public function verifikasiLowongan()
    {
        $lowongans = Lowongan::with('penyedia')->latest()->get();

        $jobStatuses = [
            ['value' => 'aktif',  'label' => 'Aktif'],
            ['value' => 'closed', 'label' => 'Ditutup'],
        ];

        return view('admin.verifikasi.lowongan', compact('lowongans', 'jobStatuses'));
    }

    // ── MANAJEMEN PENGGUNA ───────────────────────────────────────────────────────

    public function users()
    {
        $users = User::with('profile')->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function showUser($id)
    {
        $user    = User::with('profile')->findOrFail($id);
        $profile = $user->profile;
        return view('admin.users.show', compact('user', 'profile'));
    }

    public function editUser($id)
    {
        $user    = User::with('profile')->findOrFail($id);
        $profile = $user->profile;
        return view('admin.users.edit', compact('user', 'profile'));
    }

    // ── KATEGORI ─────────────────────────────────────────────────────────────────

    public function categories()
    {
        // Sistem saat ini tidak punya tabel kategori terpisah.
        // Ambil dari nilai unik kolom category di lowongans.
        $categories = Lowongan::whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->sort()
            ->values()
            ->map(fn($c, $i) => ['id' => $i + 1, 'name' => $c, 'count' => Lowongan::where('category', $c)->count()]);

        return view('admin.categories.index', compact('categories'));
    }

    // ── MANAJEMEN LOWONGAN ───────────────────────────────────────────────────────

    public function jobs()
    {
        $jobs = Lowongan::with('penyedia')->latest()->get();
        return view('admin.jobs.index', compact('jobs'));
    }

    public function showJob($id)
    {
        $job = Lowongan::with(['penyedia', 'lamarans.pelamar'])->findOrFail($id);
        return view('admin.jobs.show', compact('job'));
    }

    // ── MANAJEMEN LAMARAN ────────────────────────────────────────────────────────

    public function applications()
    {
        $applications = Lamaran::with(['pelamar', 'lowongan.penyedia'])->latest()->get();
        return view('admin.applications.index', compact('applications'));
    }

    public function showApplication($id)
    {
        $application    = Lamaran::with(['pelamar.profile', 'lowongan.penyedia'])->findOrFail($id);
        $user           = $application->pelamar;
        $studentProfile = $application->pelamar?->profile;

        return view('admin.applications.show', compact('application', 'user', 'studentProfile'));
    }

    // ── LAPORAN ──────────────────────────────────────────────────────────────────

    public function reports()
    {
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();
        $totalPenyedia  = User::where('role', 'penyedia')->count();
        $totalJobs      = Lowongan::count();
        $totalLamaran   = Lamaran::count();
        $activeJobs     = Lowongan::where('status', 'aktif')->count();
        $pendingUsers   = User::where('status', 'pending')->count();

        $summary = [
            'students'             => $totalMahasiswa,
            'providers'            => $totalPenyedia,
            'jobs'                 => $totalJobs,
            'applications'         => $totalLamaran,
            'active_jobs'          => $activeJobs,
            'pending_verifications' => $pendingUsers,
        ];

        return view('admin.reports.index', compact('summary'));
    }

    // ── PROFIL ADMIN ─────────────────────────────────────────────────────────────

    public function profile()
    {
        $admin = Auth::user();
        return view('admin.profile.index', compact('admin'));
    }
}