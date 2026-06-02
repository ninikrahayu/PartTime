<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DummyData;

class AdminController extends Controller
{
    public function dashboard()
    {
        $summaryCards = DummyData::get('dashboard.admin.summary_cards', []);
        $additionalStats = DummyData::get('dashboard.admin.additional_stats', []);
        $charts = [
            'jobs_per_month' => DummyData::get('charts.admin_jobs_per_month', ['labels' => [], 'data' => []]),
            'applicants_per_month' => DummyData::get('charts.admin_applicants_per_month', ['labels' => [], 'data' => []]),
        ];

        $pendingAccounts = DummyData::getCollection('users', 'verification_status', 'menunggu_verifikasi')->take(5);
        $pendingJobs = DummyData::getCollection('jobs', 'status', 'menunggu_review')->take(5);
        $recentApplications = collect(DummyData::get('applications', []))->sortByDesc('applied_at')->take(5);

        return view('admin.dashboard', compact(
            'summaryCards',
            'additionalStats',
            'charts',
            'pendingAccounts',
            'pendingJobs',
            'recentApplications'
        ));
    }

    public function verifikasiAkun()
    {
        $users = DummyData::getCollection('users')
            ->whereIn('role', ['mahasiswa', 'penyedia'])
            ->values();
        $studentProfiles = DummyData::getCollection('student_profiles')->keyBy('user_id');
        $providerProfiles = DummyData::getCollection('provider_profiles')->keyBy('user_id');
        $verificationStatuses = DummyData::get('status_options.verification', []);

        $students = $users->where('role', 'mahasiswa')->values();
        $providers = $users->where('role', 'penyedia')->values();

        return view('admin.verifikasi.akun', compact(
            'students',
            'providers',
            'studentProfiles',
            'providerProfiles',
            'verificationStatuses'
        ));
    }

    public function verifikasiLowongan()
    {
        $pendingJobs = DummyData::getCollection('jobs', 'status', 'menunggu_review');
        $categories = DummyData::getCollection('categories');
        $jobStatuses = DummyData::get('status_options.job', []);

        return view('admin.verifikasi.lowongan', compact('pendingJobs', 'categories', 'jobStatuses'));
    }

    public function users()
    {
        $users = DummyData::get('users', []);
        return view('admin.users.index', compact('users'));
    }

    public function showUser($id)
    {
        $user = DummyData::findById('users', $id);
        if (!$user) abort(404);
        
        $profile = null;
        if ($user['role'] === 'mahasiswa') {
            $profile = DummyData::getCollection('student_profiles')->firstWhere('user_id', $id);
        } elseif ($user['role'] === 'penyedia') {
            $profile = DummyData::getCollection('provider_profiles')->firstWhere('user_id', $id);
        }

        return view('admin.users.show', compact('user', 'profile'));
    }

    public function editUser($id)
    {
        $user = DummyData::findById('users', $id);
        if (!$user) abort(404);
        
        $profile = null;
        if ($user['role'] === 'mahasiswa') {
            $profile = DummyData::getCollection('student_profiles')->firstWhere('user_id', $id);
        } elseif ($user['role'] === 'penyedia') {
            $profile = DummyData::getCollection('provider_profiles')->firstWhere('user_id', $id);
        }

        return view('admin.users.edit', compact('user', 'profile'));
    }

    public function categories()
    {
        $categories = DummyData::get('categories', []);
        return view('admin.categories.index', compact('categories'));
    }

    public function editCategory($id)
    {
        $category = DummyData::findById('categories', $id);
        if (!$category) abort(404);
        
        return view('admin.categories.edit', compact('category'));
    }

    public function jobs()
    {
        $jobs = DummyData::get('jobs', []);
        return view('admin.jobs.index', compact('jobs'));
    }

    public function showJob($id)
    {
        $job = DummyData::findById('jobs', $id);
        if (!$job) abort(404);
        
        return view('admin.jobs.show', compact('job'));
    }

    public function applications()
    {
        $applications = DummyData::get('applications', []);
        return view('admin.applications.index', compact('applications'));
    }

    public function showApplication($id)
    {
        $application = DummyData::findById('applications', $id);
        if (!$application) abort(404);
        
        // Coba cari data user / profile pelamar agar datanya lengkap (dummy fallback)
        $studentProfile = DummyData::getCollection('student_profiles')->firstWhere('user_id', $application['student_id'] ?? 0);
        $user = DummyData::findById('users', $application['student_id'] ?? 0);
        
        return view('admin.applications.show', compact('application', 'studentProfile', 'user'));
    }

    public function reports()
    {
        $users = DummyData::getCollection('users');
        $jobs = DummyData::getCollection('jobs');
        $applications = DummyData::getCollection('applications');
        $reviews = DummyData::getCollection('reviews');
        $categories = DummyData::getCollection('categories');
        $reports = DummyData::get('reports', []);
        $statusOptions = DummyData::get('status_options', []);

        $summary = [
            'students' => $users->where('role', 'mahasiswa')->count(),
            'providers' => $users->where('role', 'penyedia')->count(),
            'jobs' => $jobs->count(),
            'applications' => $applications->count(),
            'active_jobs' => $jobs->where('status', 'aktif')->count(),
            'completed_jobs' => $jobs->where('status', 'selesai')->count(),
            'reviews' => $reviews->count(),
            'pending_verifications' => $users->where('verification_status', 'menunggu_verifikasi')->count(),
        ];

        return view('admin.reports.index', compact(
            'users',
            'jobs',
            'applications',
            'reviews',
            'categories',
            'reports',
            'statusOptions',
            'summary'
        ));
    }

    public function profile()
    {
        $admin = DummyData::findById('users', 'usr-admin-001');
        return view('admin.profile.index', compact('admin'));
    }
}
