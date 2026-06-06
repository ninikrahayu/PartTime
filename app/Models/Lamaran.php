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

    public function pelamar()
    {
        return $this->belongsTo(User::class, 'pelamar_id');
    }

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class);
    }
}