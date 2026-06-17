<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Lowongan;
use App\Models\Lamaran;

class PenyediaController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $provider = $user->profile;
        
        $jobsQuery = $user->lowongans();
        $lamaranQuery = Lamaran::whereHas('lowongan', function ($query) {
            $query->where('penyedia_id', Auth::id());
        });

        $stats = [
            'jobs_aktif' => (clone $jobsQuery)->where('status', 'aktif')->count(),
            'jobs_menunggu' => 0, 
            'lamaran_masuk' => (clone $lamaranQuery)->count(),
            'lamaran_diterima' => (clone $lamaranQuery)->where('status', 'diterima')->count(),
        ];

        $recent_jobs = (clone $jobsQuery)->withCount('lamarans')->latest()->take(5)->get();
        $recent_applications = (clone $lamaranQuery)->with(['pelamar.profile', 'lowongan'])->latest()->take(5)->get();

        return view('penyedia.dashboard', compact('user', 'provider', 'stats', 'recent_applications', 'recent_jobs'));
    }

    public function profilUsaha()
    {
        $user = Auth::user();
        $provider = $user->profile;
        return view('penyedia.profil-usaha', compact('user', 'provider'));
    }

    public function jobs()
    {
        $jobs = Auth::user()->lowongans()->withCount('lamarans')->latest()->paginate(10);
        $categories = \App\Models\Category::all(); 
        $jobStatuses = ['aktif', 'closed'];

        return view('penyedia.jobs.index', compact('jobs', 'categories', 'jobStatuses'));
    }

    public function jobCreate()
    {
        $categories = \App\Models\Category::all(); 
        $salaryTypes = []; 

        return view('penyedia.jobs.create', compact('categories', 'salaryTypes'));
    }

    public function jobDetail($id)
    {
        $job = Auth::user()->lowongans()->with(['lamarans.pelamar.profile'])->findOrFail($id);

        $applications = $job->lamarans;
        $latestApplications = $applications->sortByDesc('created_at')->take(5);
        
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
        $job = Auth::user()->lowongans()->findOrFail($id);
        $categories = \App\Models\Category::all(); 
        $salaryTypes = []; 

        return view('penyedia.jobs.edit', compact('job', 'categories', 'salaryTypes'));
    }

    public function applications()
    {
        $applications = Lamaran::with(['pelamar.profile', 'lowongan'])
            ->whereHas('lowongan', function ($query) {
                $query->where('penyedia_id', Auth::id());
            })
            ->latest()
            ->paginate(10);
            
        return view('penyedia.applications.index', compact('applications'));
    }

    public function applicationDetail($id)
    {
        $application = Lamaran::with(['pelamar.profile', 'lowongan'])
            ->whereHas('lowongan', function ($query) {
                $query->where('penyedia_id', Auth::id());
            })
            ->findOrFail($id);

        return view('penyedia.applications.detail', compact('application'));
    }

    public function reviews()
    {
        $provider = Auth::user()->profile;
        $receivedReviews = \App\Models\Review::where('reviewee_id', Auth::id())->with(['reviewer', 'lamaran.lowongan'])->latest()->paginate(10);
        $givenReviews = \App\Models\Review::where('reviewer_id', Auth::id())->with(['reviewee', 'lamaran.lowongan'])->latest()->paginate(10);

        return view('penyedia.reviews.index', compact('provider', 'receivedReviews', 'givenReviews'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('penyedia.profile.index', compact('user'));
    }
}