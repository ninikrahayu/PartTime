<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DummyData;

class MahasiswaController extends Controller
{
    // Simulasi user yang sedang login
    protected $currentUserId = 'usr-student-001';

    public function dashboard()
    {
        $user = DummyData::findById('users', $this->currentUserId);
        $profile = DummyData::getCollection('student_profiles', 'user_id', $this->currentUserId)->first();
        
        $my_applications = DummyData::getCollection('applications', 'student_id', $this->currentUserId);
        
        // Asumsikan rating dummy untuk simulasi
        $rating = 4.8;
        
        $stats = [
            'lamaran_dikirim' => $my_applications->count(),
            'lamaran_diproses' => $my_applications->where('status', 'diproses')->count(),
            'lamaran_diterima' => $my_applications->where('status', 'diterima')->count(),
            'rating' => $rating
        ];

        $recent_jobs = DummyData::getCollection('jobs', 'status', 'aktif')->take(5);
        $last_application = $my_applications->sortByDesc('applied_at')->first();
        $recent_reviews = DummyData::getCollection('reviews', 'student_id', $this->currentUserId)->where('review_type', 'for_student')->take(2);

        return view('mahasiswa.dashboard', compact('user', 'profile', 'stats', 'recent_jobs', 'last_application', 'recent_reviews'));
    }

    public function jobs()
    {
        $jobs = DummyData::getCollection('jobs', 'status', 'aktif');
        $categories = DummyData::get('categories', []);
        return view('mahasiswa.jobs.index', compact('jobs', 'categories'));
    }

    public function jobDetail($id)
    {
        $job = DummyData::findById('jobs', $id);
        if (!$job) {
            abort(404, 'Lowongan tidak ditemukan');
        }
        return view('mahasiswa.jobs.detail', compact('job'));
    }

    public function favorites()
    {
        $favoriteRecords = DummyData::getCollection('favorites', 'student_id', $this->currentUserId);
        $jobs = DummyData::getCollection('jobs')->keyBy('id');
        $favorites = $favoriteRecords->map(function ($favorite) use ($jobs) {
            $job = $jobs->get($favorite['job_id']);

            return $job ? array_merge($job, ['saved_at' => $favorite['saved_at'], 'favorite_id' => $favorite['id']]) : null;
        })->filter()->values();
        $categories = DummyData::getCollection('categories');

        return view('mahasiswa.favorites.index', compact('favorites', 'categories'));
    }

    public function applications()
    {
        $applications = DummyData::getCollection('applications', 'student_id', $this->currentUserId);
        $providers = $applications->pluck('provider_name')->unique()->values();
        $statuses = DummyData::get('status_options.application', []);

        return view('mahasiswa.applications.index', compact('applications', 'providers', 'statuses'));
    }

    public function applicationDetail($id)
    {
        $application = DummyData::findById('applications', $id);
        if (!$application || $application['student_id'] !== $this->currentUserId) {
            abort(404, 'Lamaran tidak ditemukan');
        }

        $job = DummyData::findById('jobs', $application['job_id']);
        $provider = DummyData::getCollection('provider_profiles', 'user_id', $application['provider_id'])->first();
        $studentReview = DummyData::getCollection('reviews', 'application_id', $id)
            ->where('reviewer_id', $this->currentUserId)
            ->first();
        $providerReview = DummyData::getCollection('reviews', 'application_id', $id)
            ->where('reviewed_id', $this->currentUserId)
            ->first();

        return view('mahasiswa.applications.detail', compact('application', 'job', 'provider', 'studentReview', 'providerReview'));
    }

    public function reviews()
    {
        $profile = DummyData::getCollection('student_profiles', 'user_id', $this->currentUserId)->first();
        $receivedReviews = DummyData::getCollection('reviews', 'reviewed_id', $this->currentUserId);
        $givenReviews = DummyData::getCollection('reviews', 'reviewer_id', $this->currentUserId);

        return view('mahasiswa.reviews.index', compact('profile', 'receivedReviews', 'givenReviews'));
    }

    public function profile()
    {
        $user = DummyData::findById('users', $this->currentUserId);
        $profile = DummyData::getCollection('student_profiles', 'user_id', $this->currentUserId)->first();
        return view('mahasiswa.profile.index', compact('user', 'profile'));
    }
}
