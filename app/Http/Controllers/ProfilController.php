<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function updateMahasiswa(Request $request)
    {
        $profile = Profile::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'universitas' => 'nullable|string|max:255',
            'semester' => 'nullable|integer',
            'jurusan' => 'nullable|string|max:255',
            'cv_file' => 'nullable|mimes:pdf|max:5120',
        ]);

        if ($request->hasFile('cv_file')) {
            if ($profile->cv_path) {
                Storage::disk('public')->delete($profile->cv_path);
            }
            $profile->cv_path = $request->file('cv_file')->store('cv_documents', 'public');
        }

        $profile->update($request->only(['universitas', 'semester', 'jurusan']));
        $profile->save();

        return back()->with('success', 'Profil dan CV berhasil diperbarui.');
    }

    public function updatePenyedia(Request $request)
    {
        $profile = Profile::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'business_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'business_address' => 'nullable|string',
        ]);

        $profile->update($request->only(['business_name', 'description', 'business_address']));

        return back()->with('success', 'Profil usaha berhasil diperbarui.');
    }
}