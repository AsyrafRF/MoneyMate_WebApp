<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserDashboard extends Component
{
    /**
     * Listeners untuk mendengarkan perubahan data dari modal pencatatan,
     * anggaran, atau tujuan agar dashboard auto-refresh instant.
     */
    protected $listeners = [
        'keuanganUpdated' => '$refresh',
        'anggaranUpdated' => '$refresh',
        'tujuanUpdated'   => '$refresh',
    ];

    /**
     * Mengambil string bulan berjalan (Format: YYYY-MM)
     */
    private function getBulanIni(): string
    {
        return Carbon::now()->format('Y-m');
    }

    /**
     * Mengoptimalkan performa menggunakan Computed Property.
     * Data dicache selama request cycle ini, menghindari query duplikat.
     */
    #[Computed]
    public function user()
    {
        return Auth::user();
    }

    #[Computed]
    public function limitSaldo(): int
    {
        return 6000000; 
    }

    #[Computed]
    public function sisaUpload(): int
    {
        $duaBulanLalu = now()->subMonths(2);
        
        $jumlahUpload = $this->user->keuangans()
            ->whereNotNull('bukti')
            ->where('created_at', '>=', $duaBulanLalu)
            ->count();
            
        return max(0, 40 - $jumlahUpload);
    }

    #[Computed]
    public function allTujuan()
    {
        return $this->user->tujuans()
            ->whereIn('status', ['active', 'reached'])
            ->orderBy('status', 'asc')
            ->orderBy('deadline', 'asc')
            ->get(); // Tanpa ->take(2) agar semua list muncul di modal dropdown
    }

    #[Computed]
    public function totalPengeluaranBulanIni(): float
    {
        return (float) $this->user->keuangans()
            ->where('jenis', 'Pengeluaran')
            ->whereYear('tanggal', Carbon::now()->year)
            ->whereMonth('tanggal', Carbon::now()->month)
            ->sum('jumlah');
    }

    #[Computed]
    public function topKategori()
    {
        return $this->user->keuangans()
            ->select('kategori_id', DB::raw('SUM(jumlah) as total_jumlah'))
            ->where('jenis', 'Pengeluaran')
            ->whereYear('tanggal', Carbon::now()->year)
            ->whereMonth('tanggal', Carbon::now()->month)
            ->groupBy('kategori_id')
            ->orderBy('total_jumlah', 'desc')
            ->with('kategori')
            ->take(5)
            ->get();
    }

    #[Computed]
    public function anggarans()
    {
        $bulanIni = Carbon::now();

        // 1. Buat subquery untuk mencari transaksi pengeluaran terbaru per kategori bulan ini
        $transaksiTerakhir = \DB::table('keuangans')
            ->select('kategori_id', \DB::raw('MAX(id) as max_id')) // Menggunakan 'id' atau 'created_at' agar akurat secara kronologis
            ->where('user_id', Auth::id())
            ->where('jenis', 'Pengeluaran')
            ->whereYear('tanggal', $bulanIni->year)
            ->whereMonth('tanggal', $bulanIni->month)
            ->groupBy('kategori_id');

        // 2. Gabungkan (Join) ke query utama Anggaran
        return $this->user->anggarans()
            ->periode($this->getBulanIni())
            ->leftJoinSub($transaksiTerakhir, 'terakhir_dipakai', function ($join) {
                $join->on('anggarans.kategori_id', '=', 'terakhir_dipakai.kategori_id');
            })
            ->with('kategori')
            // Urutkan berdasarkan transaksi terbaru (NULL / belum terpakai akan ditaruh di bawah)
            ->orderByRaw('-terakhir_dipakai.max_id ASC')
            ->take(3)
            ->get();
    }

    #[Computed]
    public function tujuans()
    {
        return $this->user->tujuans()
            ->whereIn('status', ['active', 'reached'])
            ->orderBy('status', 'asc') // Utamakan yang masih aktif
            ->orderBy('deadline', 'asc')
            ->take(2)
            ->get();
    }

    #[Computed]
    public function recentTransactions()
    {
        return $this->user->keuangans()
            ->with('kategori')
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();
    }

    /**
     * Merender komponen ke view anak
     */
    public function render()
    {
        // Mengirim data ke Chart.js untuk reaktivitas Livewire 3
        $this->dispatch('updateChartData', [
            'labels' => $this->topKategori->map(fn($item) => $item->kategori->nama_kategori ?? 'Lainnya'),
            'data'   => $this->topKategori->map(fn($item) => $item->total_jumlah)
        ]);

        return view('livewire.user-dashboard')
            ->extends('layouts.app')
            ->title('Dashboard');
    }
}