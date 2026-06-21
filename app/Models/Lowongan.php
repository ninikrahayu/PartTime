<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    use HasFactory;

    protected $fillable = [
        'penyedia_id', 'judul', 'deskripsi', 'kriteria', 
        'shift', 'gaji', 'lokasi', 'status',
        'category', 'salary_type', 'start_date', 'end_date', 'quota', 'deadline', 'contact'
    ];

    public function penyedia()
    {
        return $this->belongsTo(User::class, 'penyedia_id');
    }

    public function lamarans()
    {
        return $this->hasMany(Lamaran::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}