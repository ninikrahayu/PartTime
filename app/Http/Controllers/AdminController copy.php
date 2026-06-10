<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function pendingAccounts()
    {
        $pendingUsers = User::where('status', 'pending')->get();
        return view('admin.verifikasi.akun', compact('pendingUsers'));
    }

    public function approveAccount($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'verified']);

        return back()->with('success', 'Akun pengguna berhasil diverifikasi dan diaktifkan.');
    }

    public function rejectAccount(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'rejected']);

        return back()->with('success', 'Akun pengguna ditolak.');
    }
}