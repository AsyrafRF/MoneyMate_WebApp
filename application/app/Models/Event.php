<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Menentukan kolom mana saja yang boleh diisi lewat form / query
    protected $fillable = [
        'title',
        'description',
        'image',
        'description_image',
        'start_date',
        'end_date',
        'terms',
        'is_active',
    ];
}