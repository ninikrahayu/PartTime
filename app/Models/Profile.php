<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'nim', 'universitas', 'fakultas', 'jurusan', 'semester', 'ipk', 'alamat', 'ktm_path', 'cv_path',
        'business_name', 'business_type', 'business_email', 'business_phone', 
        'business_address', 'description', 'logo_path', 'document_path'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}