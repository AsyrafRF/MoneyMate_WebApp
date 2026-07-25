<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;


class PremiumTransaction extends Model
{
    use MassPrunable;

    // Mengizinkan semua kolom untuk diisi secara massal
    protected $guarded = [];

    protected $fillable = [
        'user_id', 
        'invoice_number', 
        'plan', 
        'amount', 
        'discount_amount',
        'status',
        'proof_path',
        'unique_code',
        'total_amount'
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
        'total_amount' => 'decimal:0',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prunable(): Builder
    {
        return static::where('updated_at', '<=', now()->subDays(2))
            ->whereIn('status', ['pending', 'rejected']);
    }
}