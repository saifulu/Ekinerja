<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailJenisKegiatan extends Model
{
    use HasFactory;

    protected $table = 'detail_jenis_kegiatan';

    protected $fillable = [
        'jenis_kegiatan',
        'nip',
        'unit',
        'tanggal_dibuat',
        'hasil_temuan',
        'signature_pelaksana',
        'signature_pj',
        'dokumentasi',
        'status',
        'created_by'
    ];

    protected $casts = [
        'tanggal_dibuat' => 'datetime',
        'dokumentasi' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected $attributes = [
        'status' => 'draft'
    ];

    /**
     * Relationship dengan User (created_by)
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relationship dengan User berdasarkan NIP
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk filter berdasarkan NIP
     */
    public function scopeByNip($query, $nip)
    {
        return $query->where('nip', $nip);
    }

    /**
     * Scope untuk filter berdasarkan jenis kegiatan
     */
    public function scopeByJenisKegiatan($query, $jenisKegiatan)
    {
        return $query->where('jenis_kegiatan', $jenisKegiatan);
    }
}