<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PushSubscription extends Model
{
    protected $fillable = [
        'endpoint',
        'public_key',
        'auth_token',
        'content_encoding',
        'subscribable_type',
        'subscribable_id',
    ];

    /**
     * Polimorfik: owner subscription
     */
    public function subscribable()
    {
        return $this->morphTo();
    }
}
