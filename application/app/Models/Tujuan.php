<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tujuan extends Model
{
    use HasFactory;

    protected $table = 'tujuan';

    protected $fillable = [
        'user_id',
        'nama_tujuan',
        'target_nominal',
        'nominal_saat_ini',
        'target_nominal_terakhir',
        'nominal_saat_ini_terakhir',
        'progress',
        'deadline',
        'status',
    ];

    /**
     * Relasi ke model User.
     * Satu tujuan dimiliki oleh satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor opsional — otomatis hitung progress jika belum diset manual.
     */
    public function getProgressAttribute($value)
    {
        if ($value === null || $value == 0) {
            return $this->target_nominal > 0
                ? round(($this->nominal_saat_ini / $this->target_nominal) * 100)
                : 0;
        }
        return $value;
    }

    public function getNominalDisplayAttribute()
    {
        if (in_array($this->status, ['used', 'withdrawn'])) {
            return $this->nominal_saat_ini_terakhir ?? $this->nominal_saat_ini;
        }
        return $this->nominal_saat_ini;
    }

    public function getTargetDisplayAttribute()
    {
        if (in_array($this->status, ['used', 'withdrawn'])) {
            return $this->target_nominal_terakhir ?? $this->target_nominal;
        }
        return $this->target_nominal;
    }

    public function scopeOwnedBy($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
