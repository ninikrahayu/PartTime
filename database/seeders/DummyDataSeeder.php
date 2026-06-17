<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Lowongan;
use App\Models\Lamaran;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $penyedia = User::where('role', 'penyedia')->first();
        $mahasiswa = User::where('role', 'mahasiswa')->first();

        if ($penyedia && $mahasiswa) {
            $lowongan = Lowongan::create([
                'penyedia_id' => $penyedia->id,
                'judul' => 'Barista Part-Time Shift Malam',
                'deskripsi' => 'Dibutuhkan barista untuk shift malam.',
                'kriteria' => 'Bisa buat kopi',
                'lokasi' => 'Purwokerto',
                'gaji' => 1500000,
                'salary_type' => 'Bulan',
                'shift' => 'Malam',
                'status' => 'aktif',
                'category' => 'Barista',
                'quota' => 2,
                'start_date' => now()->format('Y-m-d'),
                'deadline' => now()->addDays(30)->format('Y-m-d'),
            ]);

            Lamaran::create([
                'pelamar_id' => $mahasiswa->id,
                'lowongan_id' => $lowongan->id,
                'status' => 'diproses',
            ]);
        }
    }
}
