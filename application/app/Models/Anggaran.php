<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggaran extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_anggaran';

    protected $fillable = [
        'user_id',
        'kategori_id',
        'jumlah_anggaran',
        'nominal_yang_terpakai', // Pertahankan karena dipakai sistem
        'periode',
    ];

    protected $appends = ['tampilan'];

    /**
     * Visualisasi anggaran mengambil LANGSUNG dari data database yang sudah matang.
     * Tidak ada lagi query SQL tersembunyi di sini (Sangat Cepat!).
     */
    public function getTampilanAttribute(): array
    {
        // Ambil data langsung dari kolom database
        $jumlahAnggaran = (float) $this->jumlah_anggaran;
        $nominalTerpakai = (float) $this->nominal_yang_terpakai; 
        
        // sisa_anggaran otomatis diambil dari virtual column MySQL schema Anda
        $sisaAnggaran = (float) $this->sisa_anggaran; 

        return [
            'nominal_yang_terpakai'   => $nominalTerpakai,
            'jumlah_anggaran_tampilan' => $jumlahAnggaran,
            'sisa_anggaran_tampilan'   => $sisaAnggaran,
            'persentase_terpakai'      => $jumlahAnggaran > 0 ? round(($nominalTerpakai / $jumlahAnggaran) * 100) : 0,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id_kategori');
    }

    public function scopePeriode($query, $bulan)
    {
        return $query->where('periode', $bulan);
    }
}