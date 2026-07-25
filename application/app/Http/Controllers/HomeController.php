<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Keuangan;
use App\Models\Kategori;
use App\Models\User;

class HomeController extends Controller
{
    public function beranda()
    {
        // 1️⃣ Jumlah pengguna aktif (yang sudah verifikasi email)
        // $activeUsers = User::whereNotNull('email_verified_at')->count();

        // 2️⃣ Jumlah transaksi keuangan tercatat
        // $transactions = Keuangan::count();

        // 3️⃣ Jumlah kategori unik (misalnya 'Makan', 'Gaji', 'Investasi', dll)
        // $categories = Kategori::select('nama_kategori')
        //                 ->distinct()
        //                 ->count('nama_kategori');

        // 4️⃣ Jumlah laporan bulanan (hitung berapa bulan unik dari kolom 'tanggal')
        // $monthlyReports = Keuangan::select(DB::raw('YEAR(tanggal) as year, MONTH(tanggal) as month'))
        //                     ->distinct()
        //                     ->count();
        
        $financeChart = Keuangan::select(
                DB::raw('YEAR(tanggal) as year'),
                DB::raw('MONTHNAME(tanggal) as month_name'),
                DB::raw('jenis'),
                DB::raw('SUM(jumlah) as total')
            )
            ->groupBy('year', 'month_name', 'jenis')
            ->orderBy(DB::raw('MIN(tanggal)'), 'asc')
            ->get();

        // Ambil daftar bulan dari data yang benar-benar ada di tabel Keuangan
        $monthlyCounts = Keuangan::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('MONTHNAME(created_at) as month_name'),
                DB::raw('SUM(CASE WHEN jenis = "Pemasukan" THEN 1 ELSE 0 END) as Pemasukan_count'),
                DB::raw('SUM(CASE WHEN jenis = "Pengeluaran" THEN 1 ELSE 0 END) as Pengeluaran_count')
            )
            ->groupBy('year', 'month', 'month_name')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Siapkan data untuk Chart.js
        $months = $monthlyCounts->pluck('month_name');
        $Pemasukan = $monthlyCounts->pluck('Pemasukan_count');
        $Pengeluaran = $monthlyCounts->pluck('Pengeluaran_count');

        // Statistik tambahan
        $activeUsers = User::activeLastDays(7)->count();
        $transactions = Keuangan::count();
        $categories = Kategori::where('jenis', 'Pengeluaran')
            ->select('nama_kategori')
            ->distinct()
            ->count('nama_kategori');
        $monthlyReports = $monthlyCounts->count();

        return view('landing.beranda', compact(
            'activeUsers',
            'transactions',
            'categories',
            'monthlyReports',
            'months',
            'Pemasukan',
            'financeChart',
            'Pengeluaran'
        ));
    }

    public function tentang()
    {
        return view('landing.tentang');
    }

    public function informasi()
    {
        return view('landing.informasi');
    }

    public function kontak()
    {
        return view('landing.kontak');
    }

    public function dismiss() {
        session()->forget('show_feedback');
        return redirect()->back();
    }
}