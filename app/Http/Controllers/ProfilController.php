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
            'name' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'universitas' => 'nullable|string|max:255',
            'semester' => 'nullable|integer',
            'jurusan' => 'nullable|string|max:255',
            'ipk' => 'nullable|numeric|min:0|max:4',
            'cv_file' => 'nullable|mimes:pdf|max:5120',
        ]);

        if ($request->hasFile('cv_file')) {
            if ($profile->ktm_path) {
                Storage::disk('public')->delete($profile->ktm_path);
            }
            $profile->ktm_path = $request->file('cv_file')->store('cv_documents', 'public');
        }

        $user = Auth::user();
        $user->update($request->only(['name', 'no_hp']));

        $profile->update($request->only(['universitas', 'semester', 'jurusan', 'ipk']));
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