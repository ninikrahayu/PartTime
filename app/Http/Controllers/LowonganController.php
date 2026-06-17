<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\Lamaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LowonganController extends Controller
{
    public function index()
    {
        $lowongans = Lowongan::withCount('lamarans')
            ->where('penyedia_id', Auth::id())
            ->latest()
            ->get();
            
        return view('penyedia.jobs.index', compact('lowongans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kriteria' => 'nullable|string',
            'shift' => 'required|string',
            'gaji' => 'nullable|numeric',
            'lokasi' => 'required|string',
        ]);

        $validated['penyedia_id'] = Auth::id();
        $validated['status'] = 'aktif';

        Lowongan::create($validated);

        return redirect()->route('penyedia.lowongan.index')->with('success', 'Lowongan berhasil diterbitkan.');
    }

    public function update(Request $request, $id)
    {
        $lowongan = Lowongan::where('penyedia_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kriteria' => 'nullable|string',
            'shift' => 'required|string',
            'gaji' => 'nullable|numeric',
            'lokasi' => 'required|string',
            'status' => 'required|in:aktif,closed',
        ]);

        $lowongan->update($validated);

        return redirect()->route('penyedia.lowongan.index')->with('success', 'Lowongan berhasil diperbarui.');
    }

    public function daftarPelamar($id)
    {
        $lowongan = Lowongan::where('penyedia_id', Auth::id())->findOrFail($id);
        $lamarans = $lowongan->lamarans()->with('pelamar.profile')->latest()->get();

        return view('penyedia.applications.index', compact('lowongan', 'lamarans'));
    }

    public function ubahStatusLamaran(Request $request, $lamaran_id)
    {
        $request->validate([
            'status' => 'required|in:diproses,diterima,ditolak'
        ]);

        $lamaran = Lamaran::whereHas('lowongan', function($query) {
            $query->where('penyedia_id', Auth::id());
        })->findOrFail($lamaran_id);

        $lamaran->update(['status' => $request->status]);

        return back()->with('success', 'Status lamaran berhasil diubah menjadi ' . $request->status);
    }
}