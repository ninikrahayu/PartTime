<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lowongan;
use App\Models\Lamaran;
use App\Models\User;

class PublicController extends Controller
{
    public function landing()
    {
        $jobs = Lowongan::with('penyedia.profile')->where('status', 'aktif')->latest()->take(6)->get();
        $categories = \App\Models\Category::all(); 
        
        $stats = [
            'total_jobs' => Lowongan::count(),
            'total_providers' => User::where('role', 'penyedia')->count(),
            'total_students' => User::where('role', 'mahasiswa')->count(),
            'total_applications' => Lamaran::count()
        ];

        return view('public.landing', compact('jobs', 'categories', 'stats'));
    }

    public function lowonganList(Request $request)
    {
        $query = Lowongan::with('penyedia.profile')->where('status', 'aktif')->latest();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'LIKE', '%' . $request->search . '%')
                  ->orWhereHas('penyedia', function($pQuery) use ($request) {
                      $pQuery->where('name', 'LIKE', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->filled('category')) {
            $query->whereIn('category', (array) $request->category);
        }

        if ($request->filled('location')) {
            $query->whereIn('lokasi', (array) $request->location);
        }

        if ($request->filled('schedule')) {
            $query->whereIn('shift', (array) $request->schedule);
        }

        if ($request->filled('min_salary')) {
            $query->where('gaji', '>=', $request->min_salary);
        }

        if ($request->filled('sort')) {
            if ($request->sort == 'terbaru') {
                $query->latest();
            } elseif ($request->sort == 'gaji_tertinggi') {
                $query->orderBy('gaji', 'desc');
            }
        }

        $jobs = $query->paginate(12);
        $categories = \App\Models\Category::all();
        
        return view('public.lowongan.index', compact('jobs', 'categories'));
    }

    public function lowonganDetail($id)
    {
        $job = Lowongan::with('penyedia.profile')->where('status', 'aktif')->findOrFail($id);

        $similarJobs = Lowongan::with('penyedia.profile')
                        ->where('id', '!=', $id)
                        ->where('status', 'aktif')
                        ->inRandomOrder()
                        ->take(3)
                        ->get();

        return view('public.lowongan.detail', compact('job', 'similarJobs'));
    }

    public function registerRole()
    {
        return view('public.auth.register-role');
    }

    public function registerMahasiswa()
    {
        return view('public.auth.register-mahasiswa');
    }

    public function registerPenyedia()
    {
        return view('public.auth.register-penyedia');
    }

    public function login()
    {
        return view('public.auth.login');
    }

    public function forgotPassword()
    {
        return view('public.auth.forgot-password');
    }

    public function resetPassword()
    {
        return view('public.auth.reset-password');
    }
}