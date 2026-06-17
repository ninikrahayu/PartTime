<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 
        'username', 
        'email', 
        'no_hp', 
        'password', 
        'role', 
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function lowongans()
    {
        return $this->hasMany(Lowongan::class, 'penyedia_id');
    }

    public function lamarans()
    {
        return $this->hasMany(Lamaran::class, 'pelamar_id');
    }
}