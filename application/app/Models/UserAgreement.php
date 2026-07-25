<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAgreement extends Model
{
    protected $fillable = [
        'user_id',
        'document_type',
        'document_version',
        'accepted_at',
        'ip_address',
        'user_agent',
        'completed_at',
    ];

    protected $casts = [
        'accepted_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('document_type', $type);
    }

    public static function hasAcceptedAll(int $userId, string $version = '1.0'): bool
    {
        $required = ['terms', 'agreement', 'privacy'];
        $count = static::forUser($userId)
            ->whereIn('document_type', $required)
            ->where('document_version', $version)
            ->count();

        return $count === count($required);
    }

    public function getIsCompletedAttribute(): bool
    {
        return !is_null($this->completed_at);
    }
}