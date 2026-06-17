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

    public function penyedia()
    {
        return $this->belongsTo(User::class, 'penyedia_id');
    }

    public function lamarans()
    {
        return $this->hasMany(Lamaran::class);
    }
}