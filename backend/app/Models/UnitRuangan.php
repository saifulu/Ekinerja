<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitRuangan extends Model
{
    use HasFactory;

    protected $table = 'unit_ruangan';

    protected $fillable = [
        'nip',
        'nama_pegawai', 
        'nama_ruangan',
        'tanggal_dibuat'
    ];

    protected $casts = [
        'tanggal_dibuat' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationship dengan User
    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }

    // Scope untuk filter berdasarkan user
    public function scopeForUser($query, $nip)
    {
        return $query->where('nip', $nip);
    }

    // Method untuk mendapatkan ruangan berdasarkan NIP
    public static function getRuanganByNip($nip)
    {
        return self::where('nip', $nip)
                   ->select('nama_ruangan')
                   ->distinct()
                   ->pluck('nama_ruangan')
                   ->toArray();
    }
}
