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
        'status',
        'is_active'
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

    public function lamarans()
    {
        return $this->hasMany(Lamaran::class, 'pelamar_id');
    }

    public function lowongans()
    {
        return $this->hasMany(Lowongan::class, 'penyedia_id');
    }

    public function givenReviews()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    public function receivedReviews()
    {
        return $this->hasMany(Review::class, 'reviewee_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function averageRating()
    {
        return round($this->receivedReviews()->avg('rating') ?? 0, 1);
    }
}