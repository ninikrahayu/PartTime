<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lowongan;
use App\Models\Lamaran;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\UsersExport;
use App\Exports\LowonganExport;
use App\Exports\LamaranExport;
use App\Exports\ReportsExport;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalMahasiswa  = User::where('role', 'mahasiswa')->count();
        $totalPenyedia   = User::where('role', 'penyedia')->count();
        $totalLowongan   = Lowongan::count();
        $totalLamaran    = Lamaran::count();

        $summaryCards = [
            ['label' => 'Total Mahasiswa',   'value' => $totalMahasiswa,  'icon' => 'fa-user-graduate'],
            ['label' => 'Total Penyedia',    'value' => $totalPenyedia,   'icon' => 'fa-building'],
            ['label' => 'Total Lowongan',    'value' => $totalLowongan,   'icon' => 'fa-briefcase'],
            ['label' => 'Total Lamaran',     'value' => $totalLamaran,    'icon' => 'fa-file-lines'],
        ];

        $additionalStats = [
            ['label' => 'Lowongan Aktif', 'value' => Lowongan::where('status', 'aktif')->count()],
            ['label' => 'Lowongan Ditutup', 'value' => Lowongan::where('status', 'selesai')->count()],
            ['label' => 'Lamaran Diterima', 'value' => Lamaran::where('status', 'diterima')->count()],
            ['label' => 'Lamaran Ditolak', 'value' => Lamaran::where('status', 'ditolak')->count()],
        ];

        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $months->push(now()->subMonths($i)->format('M'));
        }

        $jobsPerMonth = [];
        $appsPerMonth = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $jobsPerMonth[] = Lowongan::whereMonth('created_at', $date->month)
                                      ->whereYear('created_at', $date->year)
                                      ->count();
            $appsPerMonth[] = Lamaran::whereMonth('created_at', $date->month)
                                     ->whereYear('created_at', $date->year)
                                     ->count();
        }

        $charts = [
            'jobs_per_month' => [
                'labels' => $months->toArray(),
                'data' => $jobsPerMonth
            ],
            'applicants_per_month' => [
                'labels' => $months->toArray(),
                'data' => $appsPerMonth
            ]
        ];

        $recentApps = Lamaran::with(['pelamar', 'lowongan.penyedia'])->latest()->take(5)->get();
        $recentApplications = $recentApps->map(function($app) {
            return [
                'student_name' => $app->pelamar->name ?? 'Anonim',
                'job_title' => $app->lowongan->judul ?? '-',
                'status' => $app->status,
                'applied_at' => $app->created_at->diffForHumans()
            ];
        });

        $pendingAccs = User::where('status', 'pending')->latest()->take(5)->get();
        $pendingAccounts = $pendingAccs->map(function($acc) {
            return [
                'name' => $acc->name,
                'role' => $acc->role,
                'created_at' => $acc->created_at->diffForHumans(),
                'verification_status' => $acc->status
            ];
        });

        $pendingJbs = Lowongan::with('penyedia')->where('status', 'menunggu_review')->latest()->take(5)->get();
        $pendingJobs = $pendingJbs->map(function($job) {
            return [
                'title' => $job->judul,
                'provider_name' => $job->penyedia->name ?? '-',
                'category' => $job->category ?? 'Umum',
                'status' => $job->status,
                'created_at' => $job->created_at->diffForHumans()
            ];
        });

        return view('admin.dashboard', compact(
            'summaryCards',
            'additionalStats',
            'charts',
            'recentApplications',
            'pendingAccounts',
            'pendingJobs'
        ));
    }

    // ── VERIFIKASI AKUN ─────────────────────────────────────────────────────────

    public function pendingAccounts(Request $request)
    {
        $studentQuery = User::where('role', 'mahasiswa')->with('profile')->latest();
        $providerQuery = User::where('role', 'penyedia')->with('profile')->latest();

        if ($request->filled('search')) {
            $studentQuery->where(function($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('email', 'LIKE', '%' . $request->search . '%');
            });
            $providerQuery->where(function($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('email', 'LIKE', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $studentQuery->where('status', $request->status);
            $providerQuery->where('status', $request->status);
        }

        $students  = $studentQuery->get();
        $providers = $providerQuery->get();

        $verificationStatuses = [
            ['value' => 'pending',  'label' => 'Menunggu Verifikasi'],
            ['value' => 'verified', 'label' => 'Terverifikasi'],
            ['value' => 'rejected', 'label' => 'Ditolak'],
        ];

        return view('admin.verifikasi.akun', compact('students', 'providers', 'verificationStatuses'));
    }

    public function approveAccount(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'verified']);
        return back()->with('success', "Akun {$user->name} berhasil diverifikasi.");
    }

    public function rejectAccount(Request $request, $id)
    {
        $request->validate(['reason' => 'nullable|string|max:500']);
        $user = User::findOrFail($id);
        $user->update(['status' => 'rejected']);
        return back()->with('success', "Akun {$user->name} berhasil ditolak.");
    }

    // ── VERIFIKASI LOWONGAN ──────────────────────────────────────────────────────

    public function verifikasiLowongan(Request $request)
    {
        $query = Lowongan::with('penyedia')->latest();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'LIKE', '%' . $request->search . '%')
                  ->orWhereHas('penyedia', function($providerQuery) use ($request) {
                      $providerQuery->where('name', 'LIKE', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $lowongans = $query->get();
        $pendingJobs = $lowongans->map(function($job) {
            return [
                'id' => $job->id,
                'title' => $job->judul,
                'location' => $job->lokasi,
                'provider_name' => $job->penyedia->name ?? '-',
                'category' => $job->category ?? 'Umum',
                'salary' => $job->gaji,
                'salary_type' => $job->salary_type ?? 'Bulan',
                'quota' => $job->quota ?? 0,
                'status' => $job->status,
                'schedule' => $job->shift,
                'start_date' => $job->start_date ?? '-',
                'deadline' => $job->deadline ?? '-',
                'description' => $job->deskripsi,
                'requirements' => explode("\n", $job->kriteria ?? '')
            ];
        });

        $categories = Lowongan::whereNotNull('category')->distinct()->pluck('category')->map(function($c, $i) {
            return ['id' => $i + 1, 'name' => $c];
        });

        $jobStatuses = [
            ['value' => 'aktif',  'label' => 'Aktif'],
            ['value' => 'closed', 'label' => 'Ditutup'],
        ];

        return view('admin.verifikasi.lowongan', compact('pendingJobs', 'categories', 'jobStatuses'));
    }

    // ── MANAJEMEN PENGGUNA ───────────────────────────────────────────────────────

    public function users(Request $request)
    {
        $query = User::with('profile')->latest();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('email', 'LIKE', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->paginate(10)->through(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'account_status' => $user->is_active ? 'aktif' : 'nonaktif',
                'verification_status' => $user->status,
                'created_at' => $user->created_at ? $user->created_at->format('Y-m-d H:i:s') : now()->format('Y-m-d H:i:s'),
                'last_login' => $user->updated_at ? $user->updated_at->diffForHumans() : '-'
            ];
        });
        
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function showUser($id)
    {
        $u = User::with('profile')->findOrFail($id);
        $user = [
            'id' => $u->id,
            'name' => $u->name,
            'email' => $u->email,
            'role' => $u->role,
            'status' => $u->status,
            'account_status' => $u->is_active ? 'aktif' : 'nonaktif',
            'verification_status' => $u->status,
            'phone' => $u->no_hp ?? '-',
            'created_at' => $u->created_at ? $u->created_at->format('Y-m-d H:i:s') : now()->format('Y-m-d H:i:s'),
        ];
        $profile = $u->profile ? $u->profile->toArray() : [];
        if (!isset($profile['skills'])) $profile['skills'] = [];
        return view('admin.users.show', compact('user', 'profile'));
    }

    public function editUser($id)
    {
        $u = User::with('profile')->findOrFail($id);
        $user = [
            'id' => $u->id,
            'name' => $u->name,
            'email' => $u->email,
            'role' => $u->role,
            'status' => $u->status,
            'is_active' => $u->is_active,
            'phone' => $u->no_hp ?? '-'
        ];
        $profile = $u->profile ? $u->profile->toArray() : [];
        return view('admin.users.edit', compact('user', 'profile'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,mahasiswa,penyedia',
        ]);

        User::create([
            'name' => $request->name,
            'username' => \Illuminate\Support\Str::slug($request->name) . rand(100, 999),
            'email' => $request->email,
            'no_hp' => $request->phone ?? null,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => $request->role,
            'status' => 'verified',
            'is_active' => 1,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'status' => 'required|in:pending,verified,rejected',
            'is_active' => 'required|in:1,0',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
            'is_active' => $request->is_active,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => \Illuminate\Support\Facades\Hash::make($request->password)]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function toggleActiveUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Pengguna berhasil {$status}.");
    }

    public function destroyUser($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    public function exportUsersXls()
    {
        return Excel::download(new UsersExport, 'data_pengguna.xlsx');
    }

    public function exportUsersPdf()
    {
        $users = User::all();
        $pdf = Pdf::loadView('exports.users-pdf', compact('users'))->setPaper('a4', 'landscape');
        return $pdf->download('data_pengguna.pdf');
    }

    // ── KATEGORI ─────────────────────────────────────────────────────────────────

    public function categories(Request $request)
    {
        $query = \App\Models\Category::query();

        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $categories = $query->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:categories,name']);
        \App\Models\Category::create($request->only('name'));
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function updateCategory(Request $request, $id)
    {
        $category = \App\Models\Category::findOrFail($id);
        $request->validate(['name' => 'required|string|max:255|unique:categories,name,'.$id, 'status' => 'required|in:aktif,nonaktif']);
        $category->update($request->only('name', 'status'));
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroyCategory($id)
    {
        \App\Models\Category::findOrFail($id)->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }

    // ── MANAJEMEN LOWONGAN ───────────────────────────────────────────────────────

    public function jobs(Request $request)
    {
        $query = Lowongan::with('penyedia')->latest();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'LIKE', '%' . $request->search . '%')
                  ->orWhereHas('penyedia', function($providerQuery) use ($request) {
                      $providerQuery->where('name', 'LIKE', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $jobs = $query->paginate(10)->through(function($job) {
            return [
                'id' => $job->id,
                'title' => $job->judul,
                'location' => $job->lokasi,
                'provider_name' => $job->penyedia->name ?? '-',
                'category' => $job->category ?? 'Umum',
                'salary' => $job->gaji,
                'status' => $job->status
            ];
        });
        
        return view('admin.jobs.index', compact('jobs'));
    }

    public function showJob($id)
    {
        $jobModel = Lowongan::with(['penyedia', 'lamarans.pelamar'])->findOrFail($id);
        $job = [
            'id' => $jobModel->id,
            'title' => $jobModel->judul,
            'location' => $jobModel->lokasi,
            'provider_name' => $jobModel->penyedia->name ?? '-',
            'provider_email' => $jobModel->penyedia->email ?? '-',
            'provider_phone' => $jobModel->penyedia->no_hp ?? '-',
            'category' => $jobModel->category ?? 'Umum',
            'salary' => $jobModel->gaji,
            'salary_type' => $jobModel->salary_type ?? 'Bulan',
            'quota' => $jobModel->quota ?? 0,
            'status' => $jobModel->status,
            'schedule' => $jobModel->shift,
            'working_hours' => $jobModel->shift ?? 'Belum ditentukan',
            'start_date' => $jobModel->start_date ?? '-',
            'deadline' => $jobModel->deadline ?? '-',
            'created_at' => $jobModel->created_at,
            'description' => $jobModel->deskripsi,
            'applicants_count' => $jobModel->lamarans->count(),
            'requirements' => explode("\n", $jobModel->kriteria ?? ''),
            'applicants' => $jobModel->lamarans->map(function($app) {
                return [
                    'student_name' => $app->pelamar->name ?? 'Anonim',
                    'applied_at' => $app->created_at->format('d M Y'),
                    'status' => $app->status
                ];
            })->toArray()
        ];

        $reviews = \App\Models\Review::with('reviewer')->where('reviewee_id', $jobModel->penyedia_id)->latest()->get();
        $avg = $reviews->avg('rating') ?? 0;
        $total = $reviews->count();
        $ratingData = [
            'average' => round($avg, 1),
            'total' => $total,
            'reviews' => $reviews,
            'counts' => [
                5 => $reviews->where('rating', 5)->count(),
                4 => $reviews->where('rating', 4)->count(),
                3 => $reviews->where('rating', 3)->count(),
                2 => $reviews->where('rating', 2)->count(),
                1 => $reviews->where('rating', 1)->count(),
            ]
        ];

        return view('admin.jobs.show', compact('job', 'ratingData'));
    }

    public function updateJobStatus(Request $request, $id)
    {
        $job = Lowongan::findOrFail($id);
        $request->validate(['status' => 'required|in:aktif,menunggu_review,selesai,ditolak,nonaktif']);
        $job->update(['status' => $request->status]);
        return back()->with('success', 'Status lowongan berhasil diperbarui.');
    }

    public function destroyJob($id)
    {
        Lowongan::findOrFail($id)->delete();
        return redirect()->route('admin.jobs.index')->with('success', 'Lowongan berhasil dihapus.');
    }

    public function exportJobsXls()
    {
        return Excel::download(new LowonganExport, 'data_lowongan.xlsx');
    }

    public function exportJobsPdf()
    {
        $lowongans = Lowongan::with('penyedia')->get();
        $pdf = Pdf::loadView('exports.lowongan-pdf', compact('lowongans'))->setPaper('a4', 'landscape');
        return $pdf->download('data_lowongan.pdf');
    }

    // ── MANAJEMEN LAMARAN ────────────────────────────────────────────────────────

    public function applications(Request $request)
    {
        $query = Lamaran::with(['pelamar', 'lowongan.penyedia'])->latest();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->whereHas('pelamar', function($pelamarQuery) use ($request) {
                    $pelamarQuery->where('name', 'LIKE', '%' . $request->search . '%');
                });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $applications = $query->paginate(10)->through(function($app) {
            return [
                'id' => $app->id,
                'student_name' => $app->pelamar->name ?? 'Anonim',
                'job_title' => $app->lowongan->judul ?? '-',
                'provider_name' => $app->lowongan->penyedia->name ?? '-',
                'applied_at' => $app->created_at->format('Y-m-d H:i:s'),
                'status' => $app->status
            ];
        });
        
        return view('admin.applications.index', compact('applications'));
    }

    public function showApplication($id)
    {
        $app = Lamaran::with(['pelamar.profile', 'lowongan.penyedia'])->findOrFail($id);
        
        $application = [
            'id' => $app->id,
            'job_title' => $app->lowongan->judul ?? '-',
            'status' => $app->status,
            'applied_at' => $app->created_at->format('d M Y H:i'),
            'cover_letter' => $app->cover_letter ?? '-'
        ];

        $u = $app->pelamar;
        $user = [
            'name' => $u->name ?? 'Anonim',
            'email' => $u->email ?? '-',
            'phone' => $u->no_hp ?? '-'
        ];

        $studentProfile = $app->pelamar->profile ? $app->pelamar->profile->toArray() : [];
        $user = ['email' => $app->pelamar->email, 'phone' => $app->pelamar->no_hp];

        $reviews = \App\Models\Review::with('reviewer')->where('reviewee_id', $app->pelamar->id)->latest()->get();
        $avg = $reviews->avg('rating') ?? 0;
        $total = $reviews->count();
        $ratingData = [
            'average' => round($avg, 1),
            'total' => $total,
            'reviews' => $reviews,
            'counts' => [
                5 => $reviews->where('rating', 5)->count(),
                4 => $reviews->where('rating', 4)->count(),
                3 => $reviews->where('rating', 3)->count(),
                2 => $reviews->where('rating', 2)->count(),
                1 => $reviews->where('rating', 1)->count(),
            ]
        ];

        return view('admin.applications.show', compact('application', 'user', 'studentProfile', 'ratingData'));
    }

    public function updateApplicationStatus(Request $request, $id)
    {
        $app = Lamaran::findOrFail($id);
        $request->validate(['status' => 'required|in:pending,diproses,diterima,ditolak']);
        $app->update(['status' => $request->status]);
        return back()->with('success', 'Status lamaran berhasil diperbarui.');
    }

    public function destroyApplication($id)
    {
        Lamaran::findOrFail($id)->delete();
        return redirect()->route('admin.applications.index')->with('success', 'Lamaran berhasil dihapus.');
    }

    public function exportApplicationsXls()
    {
        return Excel::download(new LamaranExport, 'data_lamaran.xlsx');
    }

    public function exportApplicationsPdf()
    {
        $lamarans = Lamaran::with(['pelamar', 'lowongan.penyedia'])->get();
        $pdf = Pdf::loadView('exports.lamaran-pdf', compact('lamarans'))->setPaper('a4', 'landscape');
        return $pdf->download('data_lamaran.pdf');
    }

    // ── LAPORAN ──────────────────────────────────────────────────────────────────

    public function reports(Request $request)
    {
        $summary = [
            'students'             => User::where('role', 'mahasiswa')->count(),
            'providers'            => User::where('role', 'penyedia')->count(),
            'jobs'                 => Lowongan::count(),
            'applications'         => Lamaran::count(),
            'active_jobs'          => Lowongan::where('status', 'aktif')->count(),
            'completed_jobs'       => Lowongan::where('status', 'selesai')->count(),
            'pending_verifications' => User::where('status', 'pending')->count(),
            'reviews'              => 0
        ];

        $statusOptions = [
            'verification' => [
                ['label' => 'Pending'], ['label' => 'Verified'], ['label' => 'Rejected']
            ],
            'job' => [
                ['label' => 'Aktif'], ['label' => 'Menunggu Review'], ['label' => 'Selesai']
            ],
            'application' => [
                ['label' => 'Menunggu'], ['label' => 'Diterima'], ['label' => 'Ditolak']
            ]
        ];

        $categories = Lowongan::whereNotNull('category')->distinct()->pluck('category')->map(function($c) {
            return ['name' => $c];
        });

        $reports = [
            'verification_summary' => [
                [
                    'type' => 'Mahasiswa', 
                    'menunggu_verifikasi' => User::where('role', 'mahasiswa')->where('status', 'pending')->count(),
                    'terverifikasi' => User::where('role', 'mahasiswa')->where('status', 'verified')->count(),
                    'ditolak' => User::where('role', 'mahasiswa')->where('status', 'rejected')->count()
                ],
                [
                    'type' => 'Penyedia', 
                    'menunggu_verifikasi' => User::where('role', 'penyedia')->where('status', 'pending')->count(),
                    'terverifikasi' => User::where('role', 'penyedia')->where('status', 'verified')->count(),
                    'ditolak' => User::where('role', 'penyedia')->where('status', 'rejected')->count()
                ]
            ],
            'job_summary' => [
                ['status' => 'aktif', 'total' => Lowongan::where('status', 'aktif')->count()],
                ['status' => 'menunggu_review', 'total' => Lowongan::where('status', 'menunggu_review')->count()],
                ['status' => 'selesai', 'total' => Lowongan::where('status', 'selesai')->count()],
            ],
            'application_summary' => [
                ['status' => 'menunggu', 'total' => Lamaran::where('status', 'diproses')->count()],
                ['status' => 'diterima', 'total' => Lamaran::where('status', 'diterima')->count()],
                ['status' => 'ditolak', 'total' => Lamaran::where('status', 'ditolak')->count()],
            ],
            'review_summary' => []
        ];

        $jobsQuery = Lowongan::with('penyedia', 'lamarans')->latest();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $jobsQuery->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }
        if ($request->filled('category')) {
            $jobsQuery->where('category', $request->category);
        }
        if ($request->filled('status')) {
            $jobsQuery->where('status', $request->status);
        }

        $jobs = $jobsQuery->paginate(10)->through(function($job) {
            return [
                'title' => $job->judul,
                'provider_name' => $job->penyedia->name ?? '-',
                'category' => $job->category ?? 'Umum',
                'applicants_count' => $job->lamarans->count(),
                'status' => $job->status,
                'created_at' => $job->created_at->format('d M Y')
            ];
        });

        return view('admin.reports.index', compact('summary', 'statusOptions', 'categories', 'reports', 'jobs'));
    }

    public function exportReportsXls()
    {
        return Excel::download(new ReportsExport, 'laporan_partimeku.xlsx');
    }

    public function exportReportsPdf()
    {
        $jobs = collect(Lowongan::with('penyedia', 'lamarans')->latest()->get()->map(function($job) {
            return [
                'title' => $job->judul,
                'provider_name' => $job->penyedia->name ?? '-',
                'category' => $job->category ?? 'Umum',
                'applicants_count' => $job->lamarans->count(),
                'status' => $job->status,
                'created_at' => $job->created_at->format('d M Y')
            ];
        }));

        $pdf = Pdf::loadView('exports.reports-table', compact('jobs'))->setPaper('a4', 'landscape');
        return $pdf->download('laporan_partimeku.pdf');
    }

    // ── PROFIL ADMIN ─────────────────────────────────────────────────────────────

    public function profile()
    {
        $admin = Auth::user();
        return view('admin.profile.index', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $admin = Auth::user();

        if ($request->filled('current_password')) {
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|min:8|confirmed',
            ]);

            if (!Hash::check($request->current_password, $admin->password)) {
                return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
            }

            $admin->update([
                'password' => Hash::make($request->password)
            ]);

            return back()->with('success', 'Password berhasil diubah.');
        }

        // Jika hanya update profil
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$admin->id,
            'phone' => 'nullable|string|max:20'
        ]);

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->phone
        ]);

        return back()->with('success', 'Profil admin berhasil diperbarui.');
    }
}