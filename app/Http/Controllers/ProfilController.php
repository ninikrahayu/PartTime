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
            if ($profile->cv_path) {
                Storage::disk('public')->delete($profile->cv_path);
            }
            $profile->cv_path = $request->file('cv_file')->store('cv_documents', 'public');
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
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'no_hp' => 'required|string|max:20',
            'business_name' => 'required|string|max:255',
            'business_type' => 'required|string|max:100',
            'business_phone' => 'required|string|max:20',
            'business_address' => 'required|string',
            'description' => 'nullable|string',
            'logo_path' => 'nullable|image|max:2048',
            'document_path' => 'nullable|mimes:pdf|max:5120',
        ]);

        $user->update($request->only(['name', 'username', 'no_hp']));

        if ($request->hasFile('logo_path')) {
            if ($profile->logo_path) {
                Storage::disk('public')->delete($profile->logo_path);
            }
            $profile->logo_path = $request->file('logo_path')->store('business_logos', 'public');
        }

        if ($request->hasFile('document_path')) {
            if ($profile->document_path) {
                Storage::disk('public')->delete($profile->document_path);
            }
            $profile->document_path = $request->file('document_path')->store('verification_documents', 'public');
        }

        $profile->update($request->only(['business_name', 'business_type', 'business_phone', 'business_address', 'description']));
        $profile->save();

        return back()->with('success', 'Profil akun dan usaha berhasil diperbarui.');
    }
}