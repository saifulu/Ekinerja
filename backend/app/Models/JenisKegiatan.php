<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKegiatan extends Model
{
    use HasFactory;

    protected $table = 'jenis_kegiatan';

    protected $fillable = [
        'nip',
        'golongan',
        'jenis_kegiatan'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship dengan User
    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }

    // Scope untuk filter berdasarkan NIP user
    public function scopeForUser($query, $nip)
    {
        return $query->where('nip', $nip);
    }
}