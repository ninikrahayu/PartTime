<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lamaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelamar_id', 'lowongan_id', 'catatan_tambahan', 'status'
    ];

    // Relasi balik: Lamaran ini milik 1 Pelamar (User)
    public function pelamar()
    {
        return $this->belongsTo(User::class, 'pelamar_id');
    }

    // Relasi balik: Lamaran ini ditujukan ke 1 Lowongan spesifik
    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class);
    }
}