<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenyediaController extends Controller
{
    protected $currentUserId = 'usr-provider-001';

    public function dashboard()
    {
        $user = Auth::user();
        
        $stats = [
            'jobs_aktif' => 0,
            'jobs_menunggu' => 0,
            'lamaran_masuk' => 0,
            'lamaran_diterima' => 0,
        ];

        $recent_applications = [];
        $recent_jobs = [];

        return view('penyedia.dashboard', compact('user', 'stats', 'recent_applications', 'recent_jobs'));
    }

    public function profilUsaha()
    {
        $user = Auth::user();
        $provider = $user->profile;
        
        if ($provider) {
            // Memetakan data dari format Database ke format yang diminta HTML/Blade
            $provider->phone = $user->no_hp; // Mengambil nomor dari tabel user
            $provider->address = $provider->business_address ?? '-'; // Mengambil alamat bisnis
            $provider->verification_document = $provider->document_path ? 'Dokumen_Izin.pdf' : 'Belum diunggah';
        }

        return view('penyedia.profil-usaha', compact('user', 'provider'));
    }

    public function jobs()
    {
        $jobs = \App\Models\Lowongan::with('category')->where('user_id', Auth::id())->latest()->get();
        
        foreach($jobs as $job) {
            $job->category_name = $job->category ? $job->category->name : 'Tanpa Kategori';
            $job->applicants_count = 0; 
        }

        $categories = \App\Models\Category::all();
    
        $jobStatuses = [
            'pending' => 'Menunggu Review',
            'active' => 'Aktif',
            'rejected' => 'Ditolak',
            'closed' => 'Ditutup'
        ];

        return view('penyedia.jobs.index', compact('jobs', 'categories', 'jobStatuses'));
    }

    public function jobCreate()
    {
        if (\App\Models\Category::count() == 0) {
            \App\Models\Category::insert([
                ['name' => 'F&B (Cafe/Resto)', 'slug' => 'fnb'],
                ['name' => 'Retail (Toko/Minimarket)', 'slug' => 'retail'],
                ['name' => 'IT / Freelance', 'slug' => 'it'],
                ['name' => 'Event / Usher', 'slug' => 'event']
            ]);
        }
    

        $categories = \App\Models\Category::all();
        
        // Diubah ke associative array untuk dropdown form
        $salaryTypes = [
            'Per Jam' => 'Per Jam',
            'Per Hari' => 'Per Hari',
            'Per Bulan' => 'Per Bulan',
            'Project Based' => 'Project Based'
        ];

        return view('penyedia.jobs.create', compact('categories', 'salaryTypes'));
    }

    // 3. Menyimpan data form ke Database (Fungsi Baru)
    public function jobStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'location' => 'required|string',
            'salary' => 'required|numeric',
            'salary_type' => 'required|string',
            'schedule' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'quota' => 'required|integer|min:1',
            'deadline' => 'required|date',
        ]);

        \App\Models\Lowongan::create([
            'user_id' => Auth::id(), // ID Penyedia yang sedang login
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'location' => $request->location,
            'salary' => $request->salary,
            'salary_type' => $request->salary_type,
            'schedule' => $request->schedule,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'quota' => $request->quota,
            'deadline' => $request->deadline,
            'contact' => $request->contact,
            'status' => 'pending', // Otomatis pending (menunggu acc Admin)
        ]);

        return redirect('/penyedia/jobs')->with('success', 'Lowongan berhasil dikirim dan menunggu review Admin.');
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
}