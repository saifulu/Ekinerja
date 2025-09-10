<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'nip',
        'golongan',
        'instansi',
        'ruangan',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Scope untuk keamanan query
    public function scopeSecureSearch($query, $term)
    {
        return $query->where(function($q) use ($term) {
            $safeTerm = '%' . addslashes($term) . '%';
            $q->where('name', 'LIKE', $safeTerm)
              ->orWhere('email', 'LIKE', $safeTerm)
              ->orWhere('nip', 'LIKE', $safeTerm);
        });
    }

    // Helper methods untuk role
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    // Relationship dengan JenisKegiatan
    public function jenisKegiatan()
    {
        return $this->hasMany(JenisKegiatan::class, 'nip', 'nip');
    }
}
