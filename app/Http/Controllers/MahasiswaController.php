<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\Lamaran;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\DummyData;
class MahasiswaController extends Controller
{
    public function cariLowongan(Request $request)
    {
        $query = Lowongan::with('penyedia.profile')->where('status', 'aktif');

        if ($request->filled('keyword')) {
            $query->where('judul', 'like', '%' . $request->keyword . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->keyword . '%');
        }
        
        if ($request->filled('shift')) {
            $query->where('shift', $request->shift);
        }
        
        if ($request->filled('gaji_min')) {
            $query->where('gaji', '>=', $request->gaji_min);
        }

        $lowongans = $query->latest()->get();
        
        return view('mahasiswa.jobs.index', compact('lowongans'));
    }

    public function lamarPekerjaan(Request $request, $lowongan_id)
    {
        $pelamar_id = Auth::id();
        $profile = Profile::where('user_id', $pelamar_id)->first();

        if (!$profile || !$profile->cv_path) {
            return back()->with('error', 'Silakan unggah CV di menu profil terlebih dahulu sebelum melamar.');
        }

        $sudahMelamar = Lamaran::where('pelamar_id', $pelamar_id)
                               ->where('lowongan_id', $lowongan_id)
                               ->exists();

        if ($sudahMelamar) {
            return back()->with('error', 'Anda sudah melamar lowongan ini sebelumnya.');
        }

        Lamaran::create([
            'pelamar_id' => $pelamar_id,
            'lowongan_id' => $lowongan_id,
            'catatan_tambahan' => $request->catatan_tambahan,
            'status' => 'pending',
        ]);

        return redirect()->route('mahasiswa.lamaran.status')->with('success', 'Lamaran berhasil dikirim ke penyedia!');
    }

    public function statusLamaran()
    {
        $lamarans = Lamaran::with(['lowongan.penyedia'])
                           ->where('pelamar_id', Auth::id())
                           ->latest()
                           ->get();
                           
        return view('mahasiswa.applications.index', compact('lamarans'));
    }

    // --- METODE DUMMY DATA UNTUK UI (JANGAN DIHAPUS SEBELUM UI DIINTEGRASIKAN SEPENUHNYA) ---
    protected $currentUserId = 'usr-student-001';

    public function dashboard()
    {
        $user = DummyData::findById('users', $this->currentUserId);
        $my_applications = DummyData::getCollection('applications', 'student_id', $this->currentUserId);
        
        $stats = [
            'lamaran_dikirim' => $my_applications->count(),
            'lamaran_diproses' => $my_applications->where('status', 'diproses')->count(),
            'lamaran_diterima' => $my_applications->where('status', 'diterima')->count(),
            'rating' => 4.8,
        ];

        $last_application = $my_applications->sortByDesc('applied_at')->first();
        $recent_reviews = DummyData::getCollection('reviews', 'reviewed_id', $this->currentUserId)->take(3);
        $recent_jobs = DummyData::getCollection('jobs')->where('status', 'aktif')->take(4);

        return view('mahasiswa.dashboard', compact('user', 'stats', 'last_application', 'recent_reviews', 'recent_jobs'));
    }

    public function jobs()
    {
        $jobs = DummyData::getCollection('jobs')->where('status', 'aktif');
        $categories = DummyData::getCollection('categories');
        return view('mahasiswa.jobs.index', compact('jobs', 'categories'));
    }

    public function jobDetail($id)
    {
        $job = DummyData::findById('jobs', $id);
        if (!$job) abort(404);
        return view('mahasiswa.jobs.detail', compact('job'));
    }

    public function favorites()
    {
        $favorites = DummyData::getCollection('jobs')->where('status', 'aktif')->take(3);
        return view('mahasiswa.favorites.index', compact('favorites'));
    }

    public function applications()
    {
        $applications = DummyData::getCollection('applications', 'student_id', $this->currentUserId);
        return view('mahasiswa.applications.index', compact('applications'));
    }

    public function applicationDetail($id)
    {
        $application = DummyData::findById('applications', $id);
        if (!$application) abort(404);
        return view('mahasiswa.applications.detail', compact('application'));
    }

    public function reviews()
    {
        $reviews = DummyData::getCollection('reviews', 'reviewed_id', $this->currentUserId);
        return view('mahasiswa.reviews.index', compact('reviews'));
    }

    public function profile()
    {
        $user = DummyData::findById('users', $this->currentUserId);
        return view('mahasiswa.profile.index', compact('user'));
    }
}