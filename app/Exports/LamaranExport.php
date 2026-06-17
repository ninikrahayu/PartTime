<?php

namespace App\Exports;

use App\Models\Lamaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LamaranExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Lamaran::with(['pelamar', 'lowongan.penyedia'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Pelamar',
            'Email Pelamar',
            'Lowongan',
            'Penyedia',
            'Status Lamaran',
            'Tanggal Melamar'
        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->pelamar->name ?? '-',
            $row->pelamar->email ?? '-',
            $row->lowongan->judul ?? '-',
            $row->lowongan->penyedia->name ?? '-',
            ucfirst($row->status),
            $row->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
