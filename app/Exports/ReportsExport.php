<?php

namespace App\Exports;

use App\Models\Lowongan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportsExport implements FromView
{
    public function view(): View
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

        return view('exports.reports-table', [
            'jobs' => $jobs
        ]);
    }
}
