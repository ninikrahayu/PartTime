<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'universitas', 'semester', 'jurusan', 'cv_path',
        'nama_toko', 'deskripsi_usaha', 'alamat_lengkap', 'jam_operasional', 'foto_usaha_path'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}