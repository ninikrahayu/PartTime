<?php

namespace App\Exports;

use App\Models\Lowongan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LowonganExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Lowongan::with('penyedia')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Judul Lowongan',
            'Kategori',
            'Penyedia',
            'Gaji',
            'Status',
            'Tanggal Dibuat'
        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->judul,
            $row->category ?? '-',
            $row->penyedia->name ?? '-',
            $row->gaji,
            ucfirst($row->status),
            $row->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
