<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\Lamaran;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}