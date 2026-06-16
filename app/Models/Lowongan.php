<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category_id', 'title', 'description', 'requirements',
        'location', 'salary', 'salary_type', 'schedule', 'start_date',
        'end_date', 'quota', 'deadline', 'contact', 'status'
    ];

    // Relasi ke Pembuat Lowongan (Penyedia)
    public function penyedia()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}