<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    use HasFactory;

    protected $fillable = [
        'penyedia_id', 'judul', 'deskripsi', 'kriteria', 
        'shift', 'gaji', 'lokasi', 'status'
    ];

<<<<<<< HEAD
    // Relasi balik: Lowongan ini milik 1 Penyedia (User)
=======

>>>>>>> feature/manage-lowongan
    public function penyedia()
    {
        return $this->belongsTo(User::class, 'penyedia_id');
    }

<<<<<<< HEAD
    // Relasi: 1 Lowongan bisa punya banyak Lamaran masuk
=======
>>>>>>> feature/manage-lowongan
    public function lamarans()
    {
        return $this->hasMany(Lamaran::class);
    }
}