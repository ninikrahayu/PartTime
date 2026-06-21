<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\Lamaran;
use App\Models\Profile;
use App\Models\Favorite;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama Mahasiswa.
     * Mengambil data lamaran, rata-rata rating review, jumlah wishlist, dan lowongan aktif.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $user = Auth::user();
        $my_applications = $user->lamarans()->with('lowongan.penyedia.profile')->get();
        
        $stats = [
            'lamaran_dikirim' => $my_applications->count(),
            'lamaran_diproses' => $my_applications->where('status', 'diproses')->count(),
            'lamaran_diterima' => $my_applications->where('status', 'diterima')->count(),
            'rating' => round($user->receivedReviews()->avg('rating') ?? 0, 1),
            'wishlist' => $user->favorites()->count(),
            'lowongan_aktif' => Lowongan::where('status', 'aktif')->count(),
        ];

        $last_application = $my_applications->sortByDesc('created_at')->first();
        $recent_reviews = \App\Models\Review::where('reviewee_id', Auth::id())->latest()->take(3)->get();
        $recent_jobs = Lowongan::with('penyedia.profile')->where('status', 'aktif')->latest()->take(4)->get();

        return view('mahasiswa.dashboard', compact('user', 'stats', 'last_application', 'recent_reviews', 'recent_jobs'));
    }

    /**
     * Memfilter katalog pencarian lowongan pekerjaan berdasarkan keyword, shift, gaji minimal, dan kategori.
     * Digunakan oleh Mahasiswa untuk mencari lowongan aktif.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
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
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $jobs = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();
        
        return view('mahasiswa.jobs.index', compact('jobs', 'categories'));
    }

    /**
     * Mengirimkan lamaran pekerjaan mahasiswa untuk lowongan tertentu.
     * Memvalidasi apakah profil pelamar sudah memiliki CV dan belum pernah melamar sebelumnya.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $lowongan_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function lamarPekerjaan(Request $request, $lowongan_id)
    {
        $pelamar_id = Auth::id();
        $profile = Profile::where('user_id', $pelamar_id)->first();

        if (!$profile || empty($profile->ktm_path)) {
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

    /**
     * Menampilkan riwayat/status seluruh lamaran yang diajukan oleh Mahasiswa.
     *
     * @return \Illuminate\View\View
     */
    public function statusLamaran()
    {
        $applications = Lamaran::with(['lowongan.penyedia.profile'])
                               ->where('pelamar_id', Auth::id())
                               ->latest()
                               ->paginate(10);
                           
        return view('mahasiswa.applications.index', compact('applications'));
    }

    /**
     * Menampilkan daftar semua lowongan aktif (katalog umum untuk mahasiswa).
     *
     * @return \Illuminate\View\View
     */
    public function jobs()
    {
        $jobs = Lowongan::with('penyedia.profile')->where('status', 'aktif')->latest()->paginate(10);
        $categories = \App\Models\Category::all(); 
        return view('mahasiswa.jobs.index', compact('jobs', 'categories'));
    }

    /**
     * Menampilkan detail informasi lowongan tertentu beserta penyedia dan review-nya.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function jobDetail($id)
    {
        $job = Lowongan::with('penyedia.profile')->where('status', 'aktif')->findOrFail($id);
        return view('mahasiswa.jobs.detail', compact('job'));
    }

    /**
     * Menampilkan daftar lowongan favorit / wishlist yang disimpan oleh Mahasiswa.
     *
     * @return \Illuminate\View\View
     */
    public function favorites()
    {
        $favorites = Favorite::with('lowongan.penyedia.profile')
                             ->where('user_id', Auth::id())
                             ->latest()
                             ->paginate(10);
                             
        return view('mahasiswa.favorites.index', compact('favorites'));
    }

    /**
     * Menambahkan atau menghapus (toggle) lowongan dari daftar wishlist/favorit mahasiswa.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $lowongan_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleFavorite(Request $request, $lowongan_id)
    {
        $user_id = Auth::id();
        $favorite = Favorite::where('user_id', $user_id)->where('lowongan_id', $lowongan_id)->first();

        if ($favorite) {
            $favorite->delete();
            return back()->with('success', 'Lowongan dihapus dari daftar favorit/wishlist.');
        } else {
            Favorite::create([
                'user_id' => $user_id,
                'lowongan_id' => $lowongan_id
            ]);
            return back()->with('success', 'Lowongan berhasil disimpan ke daftar favorit/wishlist.');
        }
    }

    /**
     * Menampilkan daftar seluruh lamaran pekerjaan mahasiswa (alternatif rute).
     *
     * @return \Illuminate\View\View
     */
    public function applications()
    {
        $applications = Lamaran::with(['lowongan.penyedia.profile'])
                               ->where('pelamar_id', Auth::id())
                               ->latest()
                               ->paginate(10);
        return view('mahasiswa.applications.index', compact('applications'));
    }

    /**
     * Menampilkan rincian pelacakan status lamaran (timeline) serta ulasan dua arah.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function applicationDetail($id)
    {
        $application = Lamaran::with(['lowongan.penyedia.profile'])
                              ->where('pelamar_id', Auth::id())
                              ->findOrFail($id);

        // Review dari mahasiswa ke penyedia
        $mahasiswaReview = \App\Models\Review::where('lamaran_id', $application->id)
            ->where('reviewer_id', Auth::id())
            ->first();

        // Review dari penyedia ke mahasiswa
        $penyediaReview = \App\Models\Review::where('lamaran_id', $application->id)
            ->where('reviewer_id', $application->lowongan->penyedia_id)
            ->first();

        return view('mahasiswa.applications.detail', compact('application', 'mahasiswaReview', 'penyediaReview'));
    }

    /**
     * Menyimpan ulasan (rating & komentar) mahasiswa terhadap penyedia kerja.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $lamaran_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeReview(Request $request, $lamaran_id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $lamaran = Lamaran::where('pelamar_id', Auth::id())->findOrFail($lamaran_id);

        \App\Models\Review::updateOrCreate(
            [
                'lamaran_id' => $lamaran->id,
                'reviewer_id' => Auth::id(),
            ],
            [
                'reviewee_id' => $lamaran->lowongan->penyedia_id,
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]
        );

        return back()->with('success', 'Review berhasil dikirim.');
    }

    /**
     * Menampilkan daftar review/ulasan yang diterima mahasiswa dari penyedia kerja.
     *
     * @return \Illuminate\View\View
     */
    public function reviews()
    {
        $reviews = \App\Models\Review::where('reviewee_id', Auth::id())->with(['reviewer', 'lamaran.lowongan'])->latest()->paginate(10);
        return view('mahasiswa.reviews.index', compact('reviews'));
    }

    /**
     * Menampilkan profil mahasiswa.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        $user = Auth::user();
        return view('mahasiswa.profile.index', compact('user'));
    }
}