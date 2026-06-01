<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DummyData;

class PublicController extends Controller
{
    public function landing()
    {
        // Hanya ambil lowongan yang aktif untuk landing page
        $jobs = DummyData::getCollection('jobs', 'status', 'aktif')->take(6);
        $categories = DummyData::getCollection('categories')->take(8);
        
        $stats = [
            'total_jobs' => count(DummyData::get('jobs', [])),
            'total_providers' => count(DummyData::get('provider_profiles', [])),
            'total_students' => count(DummyData::get('student_profiles', [])),
            'total_applications' => count(DummyData::get('applications', []))
        ];

        return view('public.landing', compact('jobs', 'categories', 'stats'));
    }

    public function lowonganList(Request $request)
    {
        $jobs = DummyData::getCollection('jobs', 'status', 'aktif');
        $categories = DummyData::getCollection('categories');
        
        return view('public.lowongan.index', compact('jobs', 'categories'));
    }

    public function lowonganDetail($id)
    {
        $job = DummyData::findById('jobs', $id);
        
        if (!$job) {
            abort(404, 'Lowongan tidak ditemukan');
        }

        $similarJobs = DummyData::getCollection('jobs', 'category_id', $job['category_id'])
                        ->where('id', '!=', $id)
                        ->where('status', 'aktif')
                        ->take(3);

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
