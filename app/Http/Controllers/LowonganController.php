<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LowonganController extends Controller
{
    public function index()
    {
        $lowongans = Lowongan::where('penyedia_id', Auth::id())->get();
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
}