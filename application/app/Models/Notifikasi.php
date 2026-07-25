<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\User;

class Notifikasi extends Model
{
    use HasFactory;
    use MassPrunable;

    protected $table = 'notifications';

    protected $fillable = [
        'user_id',
        'notif_id',
        'summary',
        'content',
        'sender',
        'type',
        'meta',
        'is_read',
        'resent_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'resent_at' => 'datetime',
        'meta' => 'array',
    ];

    protected $hidden = ['id', 'meta_kategori_id', 'meta_month'];
    protected $visible = ['notif_id', 'summary', 'content', 'sender', 'type', 'is_read', 'resent_at', 'created_at'];


    /**
     * Boot otomatis saat model dibuat.
     */
    protected static function boot()
    {
        parent::boot();

        // Generate notif_id otomatis jika belum ada
        static::creating(function ($model) {
            if (empty($model->notif_id)) {
                $model->notif_id = (string) Str::uuid();
            }

            // Set waktu resent_at pertama kali
            if (empty($model->resent_at)) {
                $model->resent_at = now();
            }
        });

        // Update waktu resent_at tiap kali model diperbarui
        static::updating(function ($model) {
            $model->resent_at = now();
        });
    }

    /**
     * Relasi: notifikasi milik satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: hanya notifikasi belum dibaca.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope: hanya notifikasi dengan tipe tertentu.
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope: filter notifikasi berdasarkan user tertentu.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Tandai notifikasi sebagai sudah dibaca.
     */
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }

    public function prunable(): Builder
    {
        // Logika: Ambil notifikasi yang sudah lama jika total > 120
        // Namun, Prunable biasanya berbasis waktu (misal: lebih dari 120 hari)
        return static::where('created_at', '<=', now()->subDays(120));
    }
}
