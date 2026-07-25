<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    use MassPrunable;
    
    protected $fillable = [
        'user_id', 'session_id', 'device_name', 'platform', 'browser', 'ip_address', 'last_active_at'
    ];

    public function prunable(): Builder
    {
        return static::where('created_at', '<=', now()->subMinutes(125));
    }
}
