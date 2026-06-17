<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\Lamaran;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $my_applications = $user->lamarans()->with('lowongan.penyedia.profile')->get();
        
        $stats = [
            'lamaran_dikirim' => $my_applications->count(),
            'lamaran_diproses' => $my_applications->where('status', 'diproses')->count(),
            'lamaran_diterima' => $my_applications->where('status', 'diterima')->count(),
            'rating' => 0,
        ];

        $last_application = $my_applications->sortByDesc('created_at')->first();
        $recent_reviews = collect();
        $recent_jobs = Lowongan::with('penyedia.profile')->where('status', 'aktif')->latest()->take(4)->get();

        return view('mahasiswa.dashboard', compact('user', 'stats', 'last_application', 'recent_reviews', 'recent_jobs'));
    }

    public function cariLowongan(Request $request)
    {
        $query = Lowongan::with('penyedia.profile')->where('status', 'aktif');

        if ($request->filled('keyword')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->keyword . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->keyword . '%');
            });
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

        if (!$profile || empty($profile->cv_path)) {
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
        $lamarans = Lamaran::with(['lowongan.penyedia.profile'])
                           ->where('pelamar_id', Auth::id())
                           ->latest()
                           ->get();
                           
        return view('mahasiswa.applications.index', compact('lamarans'));
    }

    public function jobs()
    {
        $jobs = Lowongan::with('penyedia.profile')->where('status', 'aktif')->latest()->get();
        $categories = []; 
        return view('mahasiswa.jobs.index', compact('jobs', 'categories'));
    }

    public function jobDetail($id)
    {
        $job = Lowongan::with('penyedia.profile')->where('status', 'aktif')->findOrFail($id);
        return view('mahasiswa.jobs.detail', compact('job'));
    }

    public function favorites()
    {
        $favorites = collect();
        return view('mahasiswa.favorites.index', compact('favorites'));
    }

    public function applications()
    {
        $applications = Lamaran::with(['lowongan.penyedia.profile'])
                               ->where('pelamar_id', Auth::id())
                               ->latest()
                               ->get();
        return view('mahasiswa.applications.index', compact('applications'));
    }

    public function applicationDetail($id)
    {
        $application = Lamaran::with(['lowongan.penyedia.profile'])
                              ->where('pelamar_id', Auth::id())
                              ->findOrFail($id);
        return view('mahasiswa.applications.detail', compact('application'));
    }

    public function reviews()
    {
        $reviews = collect();
        return view('mahasiswa.reviews.index', compact('reviews'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('mahasiswa.profile.index', compact('user'));
    }
}