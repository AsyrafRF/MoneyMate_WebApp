<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';
    protected $primaryKey = 'id_kategori';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama_kategori',
        'jenis',
        'user_id',
        'is_auto',
        'icon'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function keuangans()
    {
        return $this->hasMany(Keuangan::class, 'kategori_id', 'id_kategori');
    }

    public function anggarans()
    {
        return $this->hasMany(Anggaran::class, 'kategori_id', 'id_kategori');
    }

    public function anggaran()
    {
        return $this->hasMany(\App\Models\Anggaran::class, 'kategori_id', 'id_kategori');
    }
}
