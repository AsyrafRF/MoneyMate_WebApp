<?php

namespace App\Observers;

use App\Models\Anggaran;
use App\Models\Keuangan;
use Carbon\Carbon;

class AnggaranObserver
{
    /**
     * Handle the Anggaran "creating" event.
     */
    public function creating(Anggaran $anggaran): void
    {
        // Ambil awal dan akhir bulan berdasarkan kolom periode (Format: Y-m)
        try {
            $awalBulan = Carbon::parse($anggaran->periode . '-01')->startOfMonth();
            $akhirBulan = Carbon::parse($anggaran->periode . '-01')->endOfMonth();

            // Hitung total pengeluaran yang sudah terjadi untuk kategori ini
            $totalTerpakai = Keuangan::where('user_id', $anggaran->user_id)
                ->where('kategori_id', $anggaran->kategori_id)
                ->where('jenis', 'Pengeluaran')
                ->whereBetween('tanggal', [$awalBulan, $akhirBulan])
                ->sum('jumlah');

            // Isi nominal_yang_terpakai sebelum data disimpan ke DB
            $anggaran->nominal_yang_terpakai = $totalTerpakai;
            
        } catch (\Exception $e) {
            \Log::error("Gagal menghitung pengeluaran awal di AnggaranObserver: " . $e->getMessage());
        }
    }
}