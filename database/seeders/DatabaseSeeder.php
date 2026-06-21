<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin Pusat
        $admin = User::create([
            'name' => 'Administrator PartTime-KU',
            'username' => 'admin_pusat',
            'email' => 'admin@parttime.com',
            'no_hp' => '08111111111',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'status' => 'verified',
        ]);
        Profile::create(['user_id' => $admin->id]);

        // 2. Akun Penyedia (UMKM)
        $penyedia = User::create([
            'name' => 'Budi Kopi Kenangan',
            'username' => 'kopi_kenangan',
            'email' => 'umkm@parttime.com',
            'no_hp' => '08222222222',
            'password' => Hash::make('password123'),
            'role' => 'penyedia',
            'status' => 'verified',
        ]);
        Profile::create([
            'user_id' => $penyedia->id,
            'business_name' => 'Kopi Kenangan Purwokerto',
            'business_type' => 'Cafe',
            'business_address' => 'Jl. HR Bunyamin, Purwokerto',
            'description' => 'Mencari mahasiswa part-time untuk posisi Barista shift sore.',
        ]);

        // 3. Akun Pelamar / Mahasiswa
        $mahasiswa = User::create([
            'name' => 'Yusuf Rafii Ahmad',
            'username' => 'yusuf_rafii',
            'email' => 'mahasiswa@parttime.com',
            'no_hp' => '08333333333',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
            'status' => 'verified',
        ]);
        Profile::create([
            'user_id' => $mahasiswa->id,
            'universitas' => 'Universitas Jenderal Soedirman',
            'fakultas' => 'Teknik',
            'jurusan' => 'Informatika',
            'semester' => 4,
            'ipk' => 3.80,
            'alamat' => 'Purwokerto',
        ]);
    }
}