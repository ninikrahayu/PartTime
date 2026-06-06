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
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@parttime.com',
            'no_hp' => '08111111111',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'status' => 'verified',
        ]);
        Profile::create(['user_id' => $admin->id]);

        $penyedia = User::create([
            'name' => 'Kopi Kenangan',
            'email' => 'umkm@parttime.com',
            'no_hp' => '08222222222',
            'password' => Hash::make('password123'),
            'role' => 'penyedia',
            'status' => 'verified',
        ]);
        Profile::create([
            'user_id' => $penyedia->id,
            'nama_toko' => 'Kopi Kenangan Purwokerto',
            'alamat_lengkap' => 'Jl. HR Bunyamin',
        ]);

        $mahasiswa = User::create([
            'name' => 'Mahasiswa Unsoed',
            'email' => 'mahasiswa@parttime.com',
            'no_hp' => '08333333333',
            'password' => Hash::make('password123'),
            'role' => 'pelamar',
            'status' => 'verified',
        ]);
        Profile::create([
            'user_id' => $mahasiswa->id,
            'universitas' => 'Universitas Jenderal Soedirman',
            'semester' => 4,
        ]);
    }
}