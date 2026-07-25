<?php

namespace App\Observers;

use App\Models\Keuangan;
use App\Models\Anggaran;
use App\Exceptions\SaldoTerlaluBesarException;
use Carbon\Carbon;

class KeuanganObserver
{
    // Gunakan "created" bukan "creating" jika tidak membutuhkan 
    // pembatalan insert saat melebihi limit (karena di Controller sudah ada validasi manual).
    // Tapi jika ingin tetap "creating" untuk throw Exception, gunakan DB::raw().
    
    public function creating(Keuangan $keuangan): void
    {
        $user = $keuangan->user;
        $nominal = $keuangan->jumlah;

        // Simulasi penghitungan untuk validasi batas
        $prediksiSaldo = $user->saldo + ($keuangan->jenis === 'Pemasukan' ? $nominal : -$nominal);

        if ($prediksiSaldo > 999999999999999) {
            throw new SaldoTerlaluBesarException('Saldo terlalu besar.');
        }

        // Contoh: Jika user tidak mengisi keterangan, otomatis isi dengan nama kategori
        if (empty($keuangan->keterangan)) {
            // Pastikan relasi kategori sudah di-load agar tidak error null
            $keuangan->loadMissing('kategori');
            
            $namaKategori = $keuangan->kategori ? $keuangan->kategori->nama_kategori : 'Lain-lain';
            
            // Hasil format: "Transaksi Pengeluaran - Belanja"
            $keuangan->keterangan = "Transaksi {$keuangan->jenis} {$namaKategori}";
        }

        // Contoh: Memaksa jenis huruf besar di awal
        $keuangan->jenis = ucfirst($keuangan->jenis);
        
        // Wajib refresh agar model PHP-nya sinkron dengan DB yang baru diupdate
        $user->refresh(); 
    }

    /**
     * Handle saat transaksi baru selesai disimpan ke DB
     */
    public function created(Keuangan $keuangan): void
    {
        try {
            // Your logic
            $user = $keuangan->user; // Pastikan relasi user() ada di model Keuangan
            $nominal = $keuangan->jumlah;

            // 1. UPDATE SALDO USER (Aman karena data keuangan sudah sah di DB)
            if ($keuangan->jenis === 'Pemasukan') {
                $user->increment('saldo', $nominal);
            } else {
                $user->decrement('saldo', $nominal);
            }
    
            // 2. UPDATE ANGGARAN (Jika jenisnya pengeluaran)
            if ($keuangan->jenis === 'Pengeluaran') {
                $this->updateAnggaran($keuangan);
            }
        } catch (\Exception $e) { // Make sure this is $e
            \Log::error("Failed to process observer: " . $e->getMessage()); // So this works
        }
    }

    public function updating(Keuangan $keuangan): void
    {
        $user = $keuangan->user;
        $original = $keuangan->getOriginal();
        $nominalLama = $original['jumlah'];
        $nominalBaru = $keuangan->jumlah;

        // 1. Kembalikan saldo dari transaksi lama
        if ($original['jenis'] === 'Pemasukan') {
            $user->decrement('saldo', $nominalLama);
        } else {
            $user->increment('saldo', $nominalLama);
        }

        // Validasi batas atas setelah perubahan
        $user->refresh();
        if ($user->saldo > 999999999999999) {
            // Rollback manual di observer agak tricky, jadi pastikan di Controller juga ada validasi
            throw new SaldoTerlaluBesarException('Saldo terlalu besar.');
        }
    }

    /**
     * Handle the Keuangan "updated" event.
     */
    public function updated(Keuangan $keuangan): void
    {
        $user = $keuangan->user;
        $nominalBaru = $keuangan->jumlah;

        // 2. Terapkan saldo dari transaksi baru
        if ($keuangan->jenis === 'Pemasukan') {
            $user->increment('saldo', $nominalBaru);
        } else {
            $user->decrement('saldo', $nominalBaru);
        }

        // Jika jenisnya berubah jadi pengeluaran, atau memang dari awal pengeluaran
        if ($keuangan->jenis === 'Pengeluaran' || $keuangan->getOriginal('jenis') === 'Pengeluaran') {
            $this->updateAnggaran($keuangan);
            
            // Jika kategori atau tanggal berubah, pastikan anggaran lama juga dihitung ulang
            if ($keuangan->isDirty('kategori_id') || $keuangan->isDirty('tanggal')) {
                $originalKeuangan = new Keuangan($keuangan->getOriginal());
                $this->updateAnggaran($originalKeuangan);
            }
        }
    }

    public function deleted(Keuangan $keuangan): void
    {
        $keuangan->user->hitungUlangSaldo();

        if ($keuangan->jenis === 'Pengeluaran') {
            $this->updateAnggaran($keuangan);
        }
    }

    /**
     * Helper fungsi hitung ulang anggaran
     */
    private function updateAnggaran(Keuangan $keuangan): void
    {
        // Ambil objek Carbon dari tanggal transaksi keuangan
        $tanggalTransaksi = Carbon::parse($keuangan->tanggal);
        $periode = $tanggalTransaksi->format('Y-m');

        $anggaran = Anggaran::where('user_id', $keuangan->user_id)
            ->where('kategori_id', $keuangan->kategori_id)
            ->where('periode', $periode)
            ->first();

        if ($anggaran) {
            // Ambil batas awal dan akhir bulan dari TANGGAL TRANSAKSI
            $awalBulan = $tanggalTransaksi->copy()->startOfMonth();
            $akhirBulan = $tanggalTransaksi->copy()->endOfMonth();

            // Hitung total pengeluaran riil terupdate
            $totalTerpakai = Keuangan::where('user_id', $keuangan->user_id)
                ->where('kategori_id', $keuangan->kategori_id)
                ->where('jenis', 'Pengeluaran')
                ->whereBetween('tanggal', [$awalBulan, $akhirBulan])
                ->sum('jumlah');

            // Update langsung kolom di database tanpa memicu event loop
            $anggaran->withoutEvents(function () use ($anggaran, $totalTerpakai) {
                $anggaran->update([
                    'nominal_yang_terpakai' => $totalTerpakai
                ]);
            });
        }
    }
}