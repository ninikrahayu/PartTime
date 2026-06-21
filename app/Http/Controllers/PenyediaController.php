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

        $chartData = [];
        $maxCount = 0;
        for ($i = 5; $i >= 0; $i--) {
            $month = \Carbon\Carbon::now()->subMonths($i);
            $count = (clone $lamaranQuery)
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            
            $chartData[] = [
                'month' => $month->translatedFormat('M'),
                'count' => $count,
            ];
            if ($count > $maxCount) $maxCount = $count;
        }

        // Hitung persentase tinggi (minimal 1 agar ada sedikit bar)
        foreach ($chartData as &$data) {
            $data['height'] = $maxCount > 0 ? max(5, round(($data['count'] / $maxCount) * 100)) : 5;
        }

        return view('penyedia.dashboard', compact('user', 'provider', 'stats', 'recent_applications', 'recent_jobs', 'chartData'));
    }



    public function jobs(Request $request)
    {
        $query = Auth::user()->lowongans()->withCount('lamarans');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori')) {
            $query->where('category', $request->kategori);
        }

        $jobs = $query->latest()->paginate(10)->withQueryString();
        $categories = \App\Models\Category::all(); 
        $jobStatuses = [
            ['value' => 'aktif', 'label' => 'Aktif'],
            ['value' => 'closed', 'label' => 'Closed']
        ];

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

    public function applications(Request $request)
    {
        $query = Lamaran::with(['pelamar.profile', 'lowongan'])
            ->whereHas('lowongan', function ($q) {
                $q->where('penyedia_id', Auth::id());
            });

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('pelamar', function($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })->orWhereHas('lowongan', function($q2) use ($search) {
                    $q2->where('judul', 'like', "%{$search}%");
                });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $applications = $query->latest()->paginate(10)->withQueryString();
            
        return view('penyedia.applications.index', compact('applications'));
    }

    public function applicationDetail($id)
    {
        $application = Lamaran::with(['pelamar.profile', 'lowongan'])
            ->whereHas('lowongan', function ($query) {
                $query->where('penyedia_id', Auth::id());
            })
            ->findOrFail($id);

        // Review dari penyedia ke mahasiswa
        $penyediaReview = \App\Models\Review::where('lamaran_id', $application->id)
            ->where('reviewer_id', Auth::id())
            ->first();

        // Review dari mahasiswa ke penyedia
        $mahasiswaReview = \App\Models\Review::where('lamaran_id', $application->id)
            ->where('reviewer_id', $application->pelamar_id)
            ->first();

        // Rata-rata rating mahasiswa ini dari semua review
        $avgRating = \App\Models\Review::where('reviewee_id', $application->pelamar_id)->avg('rating');
        $totalReviews = \App\Models\Review::where('reviewee_id', $application->pelamar_id)->count();

        return view('penyedia.applications.detail', compact('application', 'penyediaReview', 'mahasiswaReview', 'avgRating', 'totalReviews'));
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
        $provider = clone $user->profile;
        return view('penyedia.profile.index', compact('user', 'provider'));
    }
}