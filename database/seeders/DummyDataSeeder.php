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
            $jobs = [
                [
                    'judul' => 'Barista Part-Time Shift Malam',
                    'deskripsi' => 'Dibutuhkan barista untuk shift malam. Pengalaman minimal 1 tahun.',
                    'kriteria' => 'Bisa buat kopi, ramah, jujur',
                    'lokasi' => 'Purwokerto',
                    'gaji' => 1500000,
                    'salary_type' => 'Bulan',
                    'shift' => 'Malam',
                    'status' => 'aktif',
                    'category' => 'Barista',
                    'quota' => 2,
                    'start_date' => now()->format('Y-m-d'),
                    'deadline' => now()->addDays(30)->format('Y-m-d'),
                ],
                [
                    'judul' => 'Kasir Toko Buku Part-Time',
                    'deskripsi' => 'Dibutuhkan kasir untuk toko buku di akhir pekan (Sabtu & Minggu).',
                    'kriteria' => 'Teliti, ramah, bisa mengoperasikan mesin kasir',
                    'lokasi' => 'Banyumas',
                    'gaji' => 750000,
                    'salary_type' => 'Bulan',
                    'shift' => 'Pagi',
                    'status' => 'aktif',
                    'category' => 'Kasir',
                    'quota' => 1,
                    'start_date' => now()->addDays(2)->format('Y-m-d'),
                    'deadline' => now()->addDays(15)->format('Y-m-d'),
                ],
                [
                    'judul' => 'Admin Media Sosial (Remote)',
                    'deskripsi' => 'Dicari admin untuk membalas DM dan komentar Instagram. Waktu kerja fleksibel.',
                    'kriteria' => 'Aktif medsos, kreatif, fast response',
                    'lokasi' => 'Remote',
                    'gaji' => 1000000,
                    'salary_type' => 'Bulan',
                    'shift' => 'Fleksibel',
                    'status' => 'aktif',
                    'category' => 'Administrasi',
                    'quota' => 3,
                    'start_date' => now()->addDays(5)->format('Y-m-d'),
                    'deadline' => now()->addDays(20)->format('Y-m-d'),
                ],
                [
                    'judul' => 'Penjaga Stand Makanan',
                    'deskripsi' => 'Membantu menjaga stand makanan di bazar kampus selama 3 hari.',
                    'kriteria' => 'Cekatan, sehat jasmani',
                    'lokasi' => 'Unsoed Purwokerto',
                    'gaji' => 300000,
                    'salary_type' => 'Proyek',
                    'shift' => 'Siang',
                    'status' => 'aktif',
                    'category' => 'Event',
                    'quota' => 4,
                    'start_date' => now()->addDays(10)->format('Y-m-d'),
                    'deadline' => now()->addDays(8)->format('Y-m-d'),
                ]
            ];

            $createdJobs = [];
            foreach ($jobs as $jobData) {
                $jobData['penyedia_id'] = $penyedia->id;
                $createdJobs[] = Lowongan::create($jobData);
            }

            Lamaran::create([
                'pelamar_id' => $mahasiswa->id,
                'lowongan_id' => $createdJobs[0]->id,
                'status' => 'diproses',
            ]);
        }
    }
}
