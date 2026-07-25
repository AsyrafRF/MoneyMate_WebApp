<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RedeemCode extends Model
{
    protected $fillable = [
        'code',
        'duration_days',
        'max_uses',
        'uses',
        'expires_at',
        'is_active',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'duration_days' => 'integer',
        'max_uses' => 'integer',
        'uses' => 'integer',
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
    ];

    /**
     * Cek apakah kode valid untuk digunakan
     */
    public function isValid(): bool
    {
        // Cek status aktif
        if (!$this->is_active) {
            return false;
        }

        // Cek tanggal kadaluarsa
        if ($this->expires_at && now()->gt($this->expires_at)) {
            return false;
        }

        // Cek batas penggunaan
        if ($this->max_uses && $this->uses >= $this->max_uses) {
            return false;
        }

        return true;
    }
}