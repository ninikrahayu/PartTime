<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DummyData;

class PenyediaController extends Controller
{
    // Simulasi penyedia yang sedang login
    protected $currentUserId = 'usr-provider-001';

    public function dashboard()
    {
        $user = DummyData::findById('users', $this->currentUserId);
        $provider = DummyData::getCollection('provider_profiles', 'user_id', $this->currentUserId)->first();
        
        $my_jobs = DummyData::getCollection('jobs', 'provider_id', $this->currentUserId);
        $my_applications = DummyData::getCollection('applications', 'provider_id', $this->currentUserId);
        
        $stats = [
            'jobs_aktif' => $my_jobs->where('status', 'aktif')->count(),
            'jobs_menunggu' => $my_jobs->where('status', 'menunggu_review')->count(),
            'lamaran_masuk' => $my_applications->count(),
            'lamaran_diterima' => $my_applications->where('status', 'diterima')->count(),
        ];

        $recent_applications = $my_applications->sortByDesc('applied_at')->take(5);
        $recent_jobs = $my_jobs->sortByDesc('created_at')->take(5);

        return view('penyedia.dashboard', compact('user', 'provider', 'stats', 'recent_applications', 'recent_jobs'));
    }

    public function profilUsaha()
    {
        $user = DummyData::findById('users', $this->currentUserId);
        $provider = DummyData::getCollection('provider_profiles', 'user_id', $this->currentUserId)->first();
        return view('penyedia.profil-usaha', compact('user', 'provider'));
    }

    public function jobs()
    {
        $jobs = DummyData::getCollection('jobs', 'provider_id', $this->currentUserId);
        $categories = DummyData::getCollection('categories');
        $jobStatuses = DummyData::get('status_options.job', []);

        return view('penyedia.jobs.index', compact('jobs', 'categories', 'jobStatuses'));
    }

    public function jobCreate()
    {
        $categories = DummyData::getCollection('categories');
        $salaryTypes = DummyData::get('form_options.salary_types', []);

        return view('penyedia.jobs.create', compact('categories', 'salaryTypes'));
    }

    public function jobDetail($id)
    {
        $job = DummyData::findById('jobs', $id);
        if (!$job || $job['provider_id'] !== $this->currentUserId) {
            abort(404, 'Lowongan tidak ditemukan');
        }

        $applications = DummyData::getCollection('applications', 'job_id', $id);
        $latestApplications = $applications->sortByDesc('applied_at')->take(5);
        $applicationStats = [
            'total' => $applications->count(),
            'accepted' => $applications->where('status', 'diterima')->count(),
            'rejected' => $applications->where('status', 'ditolak')->count(),
            'processed' => $applications->where('status', 'diproses')->count(),
        ];

        return view('penyedia.jobs.detail', compact('job', 'applications', 'latestApplications', 'applicationStats'));
    }

    public function jobEdit($id)
    {
        $job = DummyData::findById('jobs', $id);
        if (!$job || $job['provider_id'] !== $this->currentUserId) {
            abort(404, 'Lowongan tidak ditemukan');
        }
        $categories = DummyData::getCollection('categories');
        $salaryTypes = DummyData::get('form_options.salary_types', []);

        return view('penyedia.jobs.edit', compact('job', 'categories', 'salaryTypes'));
    }

    public function applications()
    {
        $applications = DummyData::getCollection('applications', 'provider_id', $this->currentUserId);
        return view('penyedia.applications.index', compact('applications'));
    }

    public function applicationDetail($id)
    {
        $application = DummyData::findById('applications', $id);
        if (!$application || $application['provider_id'] !== $this->currentUserId) {
            abort(404, 'Lamaran tidak ditemukan');
        }
        return view('penyedia.applications.detail', compact('application'));
    }

    public function reviews()
    {
        $provider = DummyData::getCollection('provider_profiles', 'user_id', $this->currentUserId)->first();
        $receivedReviews = DummyData::getCollection('reviews', 'reviewed_id', $this->currentUserId);
        $givenReviews = DummyData::getCollection('reviews', 'reviewer_id', $this->currentUserId);

        return view('penyedia.reviews.index', compact('provider', 'receivedReviews', 'givenReviews'));
    }

    public function profile()
    {
        $user = DummyData::findById('users', $this->currentUserId);
        return view('penyedia.profile.index', compact('user'));
    }
}
