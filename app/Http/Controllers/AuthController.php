<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ==========================================
    // PROSES LOGIN
    // ==========================================
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Cek jika akun ditolak admin
            if ($user->status === 'rejected') {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun Anda ditolak. Hubungi Admin.']);
            }

            // Redirect sesuai Role (sesuai dengan URL di web.php Anda)
            return match ($user->role) {
                'admin' => redirect()->intended('/admin/dashboard'),
                'penyedia' => redirect()->intended('/penyedia/dashboard'),
                default => redirect()->intended('/mahasiswa/dashboard'),
            };
        }

        return back()->withErrors(['email' => 'Email atau password tidak valid.'])->onlyInput('email');
    }

    // ==========================================
    // PROSES REGISTRASI (Sesuai Database Baru)
    // ==========================================
   public function register(Request $request)
    {
        $role = $request->input('role');

        if ($role === 'mahasiswa') {
            // Validasi khusus Mahasiswa (Nama variabel sudah disamakan dengan form frontend)
            $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:50|unique:users|alpha_dash', // alpha_dash menolak spasi
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|string|max:15|unique:users,no_hp',
                'password' => 'required|min:8|confirmed',
                'campus' => 'required|string|max:255',
                'major' => 'required|string|max:255',
                'semester' => 'required|integer|min:1|max:14',
                'ipk' => 'required|numeric|min:0|max:4',
                'address' => 'required|string',
                'ktm' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            ], [
                // Pesan Error Kustom agar tidak membingungkan
                'username.alpha_dash' => 'Username tidak boleh mengandung spasi.',
                'username.unique' => 'Username ini sudah dipakai orang lain.',
                'phone.unique' => 'Nomor telepon ini sudah terdaftar.',
                'password.min' => 'Password minimal harus 8 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.'
            ]);
        } elseif ($role === 'penyedia') {
            // Validasi khusus Penyedia
            $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:50|unique:users|alpha_dash',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|string|max:15|unique:users,no_hp',
                'password' => 'required|min:8|confirmed',
                'company_name' => 'required|string|max:255',
                'company_type' => 'required|string|max:255',
                'business_address' => 'required|string',
                'business_description' => 'required|string',
                'verification_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            ], [
                'username.alpha_dash' => 'Username tidak boleh mengandung spasi.',
                'password.min' => 'Password minimal harus 8 karakter.'
            ]);
        } else {
            return back()->with('error', 'Role tidak valid.');
        }

        // 1. Simpan Data Inti User (Mengubah 'phone' dari form ke kolom 'no_hp' di DB)
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'no_hp' => $request->phone, 
            'password' => Hash::make($request->password),
            'role' => $role,
            'status' => 'pending', 
        ]);

        // 2. Simpan Data Profil
        if ($role === 'mahasiswa') {
            $ktmPath = $request->hasFile('ktm') ? $request->file('ktm')->store('documents/ktm', 'public') : null;

            Profile::create([
                'user_id' => $user->id,
                'universitas' => $request->campus,
                'jurusan' => $request->major,
                'semester' => $request->semester,
                'ipk' => $request->ipk,
                'alamat' => $request->address,
                'ktm_path' => $ktmPath,
            ]);
        } else {
            $documentPath = $request->hasFile('verification_document') ? $request->file('verification_document')->store('documents/provider', 'public') : null;

            Profile::create([
                'user_id' => $user->id,
                'business_name' => $request->company_name,
                'business_type' => $request->company_type,
                'business_address' => $request->business_address,
                'description' => $request->business_description,
                'document_path' => $documentPath,
            ]);
        }

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
    // PROSES LOGOUT

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}