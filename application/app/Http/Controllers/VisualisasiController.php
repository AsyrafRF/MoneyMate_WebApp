<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\Kategori;
use App\Models\Anggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class VisualisasiController extends Controller
{
    public function laporan(Request $request)
    {
        $userId = Auth::id();

        // ---------------------------------------
        //  MODE & PERIODE
        // ---------------------------------------
        $mode = $request->get('mode', 'bulanan'); 
        $periode = $request->get('periode', now()->format('Y-m-d'));
        $tanggalAcuan = Carbon::createFromFormat('Y-m-d', $periode);

        // Tentukan range berdasarkan mode
        switch ($mode) {
            case 'harian':
                $rangeTanggal = [
                    $tanggalAcuan->copy()->startOfDay(),
                    $tanggalAcuan->copy()->endOfDay(),
                ];
                break;

            case 'mingguan':
                $rangeTanggal = [
                    $tanggalAcuan->copy()->startOfWeek(Carbon::MONDAY),
                    $tanggalAcuan->copy()->endOfWeek(Carbon::SUNDAY),
                ];
                break;

            default: // bulanan
                $rangeTanggal = [
                    $tanggalAcuan->copy()->startOfMonth(),
                    $tanggalAcuan->copy()->endOfMonth(),
                ];
                break;
        }

        // ---------------------------------------
        //  QUERY TRANSAKSI DASAR
        // ---------------------------------------
        $query = Keuangan::where('user_id', $userId)
            ->with(['kategori.anggarans']);

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        } else {
            $query->whereBetween('tanggal', $rangeTanggal);
        }

        $transaksi = $query->clone()->orderBy('tanggal', 'desc')->paginate(10);
        $laporan   = $query->clone()->orderBy('jumlah', 'desc')->paginate(10);

        // ---------------------------------------
        //  TOTAL PEMASUKAN & PENGELUARAN
        // ---------------------------------------
        $pemasukanQuery = Keuangan::where('user_id', $userId)->where('jenis', 'Pemasukan');
        $pengeluaranQuery = Keuangan::where('user_id', $userId)->where('jenis', 'Pengeluaran');

        if ($request->filled('kategori_id')) {
            $pemasukanQuery->where('kategori_id', $request->kategori_id);
            $pengeluaranQuery->where('kategori_id', $request->kategori_id);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $pemasukanQuery->whereBetween('tanggal', [$request->start_date, $request->end_date]);
            $pengeluaranQuery->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        } else {
            $pemasukanQuery->whereBetween('tanggal', $rangeTanggal);
            $pengeluaranQuery->whereBetween('tanggal', $rangeTanggal);
        }

        $totalPemasukan = $pemasukanQuery->sum('jumlah');
        $totalPengeluaran = $pengeluaranQuery->sum('jumlah');
        $totalSaldo = $totalPemasukan - $totalPengeluaran;

        // ---------------------------------------
        //  TOTAL ANGGARAN (per bulan)
        // ---------------------------------------
        $periodeBulan = $tanggalAcuan->format('Y-m');

        $anggaranQuery = Anggaran::where('user_id', $userId)
            ->where('periode', $periodeBulan);

        if ($request->filled('kategori_id')) {
            $anggaranQuery->where('kategori_id', $request->kategori_id);
        }

        $totalAnggaran = $anggaranQuery->sum('jumlah_anggaran');
        $realisasi = $totalPengeluaran;
        $selisih = $totalAnggaran - $realisasi;

        // ---------------------------------------
        //  donut CHART (kategori pengeluaran)
        // ---------------------------------------
        $kategoriData = Keuangan::selectRaw('kategoris.nama_kategori as kategori, SUM(keuangans.jumlah) as total')
            ->join('kategoris', 'keuangans.kategori_id', '=', 'kategoris.id_kategori')
            ->where('keuangans.user_id', $userId)
            ->where('keuangans.jenis', 'Pengeluaran')
            ->whereBetween('keuangans.tanggal', $rangeTanggal)
            ->groupBy('kategoris.nama_kategori')
            ->pluck('total', 'kategori')
            ->map(fn($v) => (float)$v);

        // ---------------------------------------
        //  ALGORITMA INTELLIGENT INSIGHT (GEN-Z)
        // ---------------------------------------
        $rangeTanggalLalu = [];
        switch ($mode) {
            case 'harian':
                $rangeTanggalLalu = [
                    $tanggalAcuan->copy()->subDay()->startOfDay(),
                    $tanggalAcuan->copy()->subDay()->endOfDay(),
                ];
                break;
            case 'mingguan':
                $rangeTanggalLalu = [
                    $tanggalAcuan->copy()->subWeek()->startOfWeek(Carbon::MONDAY),
                    $tanggalAcuan->copy()->subWeek()->endOfWeek(Carbon::SUNDAY),
                ];
                break;
            default: // bulanan
                $rangeTanggalLalu = [
                    $tanggalAcuan->copy()->subMonth()->startOfMonth(),
                    $tanggalAcuan->copy()->subMonth()->endOfMonth(),
                ];
                break;
        }

        // Hitung pengeluaran periode lalu
        $pengeluaranLalu = Keuangan::where('user_id', $userId)
            ->where('jenis', 'Pengeluaran')
            ->whereBetween('tanggal', $rangeTanggalLalu)
            ->sum('jumlah');

        // Kalkulasi persentase kenaikan/penurunan
        $perbandinganPersen = 0;
        $statusTren = 'tetap'; // naik, turun, tetap

        if ($pengeluaranLalu > 0) {
            $selisihPersen = (($totalPengeluaran - $pengeluaranLalu) / $pengeluaranLalu) * 100;
            $perbandinganPersen = abs(round($selisihPersen, 1));
            
            if ($selisihPersen > 0) {
                $statusTren = 'naik';
            } elseif ($selisihPersen < 0) {
                $statusTren = 'turun';
            }
        } elseif ($pengeluaranLalu == 0 && $totalPengeluaran > 0) {
            // Jika periode lalu kosong tapi sekarang ada pengeluaran
            $statusTren = 'naik_baru'; 
        }

        // Hitung rata-rata harian biar makin informatif
        $jumlahHari = $rangeTanggal[0]->diffInDays($rangeTanggal[1]) + 1;
        $rataRataPengeluaran = $totalPengeluaran / ($jumlahHari > 0 ? $jumlahHari : 1);

        // ---------------------------------------
        //  Bulan Algorithm (per bulan)
        // ---------------------------------------
        $monthlyData = Keuangan::selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as bulan, jenis, SUM(jumlah) as total")
            ->where('user_id', $userId)
            ->whereBetween('tanggal', $rangeTanggal)
            ->groupBy('bulan', 'jenis')
            ->orderBy('bulan')
            ->get();

        $bulanLabels = $monthlyData->pluck('bulan')->unique()->values();
        $PemasukanSeries = [];
        $PengeluaranSeries = [];

        foreach ($bulanLabels as $bulan) {
            $PemasukanSeries[] = $monthlyData->where('bulan', $bulan)->where('jenis', 'Pemasukan')->sum('total');
            $PengeluaranSeries[] = $monthlyData->where('bulan', $bulan)->where('jenis', 'Pengeluaran')->sum('total');
        }

        // ---------------------------------------
        //  ANGGARAN vs REALISASI (FIXED)
        //  Dipastikan TIDAK rusak join karena filter periode diterapkan
        // ---------------------------------------
        $data = DB::table('anggarans')
            ->join('kategoris', 'anggarans.kategori_id', '=', 'kategoris.id_kategori')
            ->where('anggarans.user_id', $userId)
            ->where('anggarans.periode', $periodeBulan) // contoh: 2026-11
            ->where('kategoris.jenis', 'Pengeluaran')
            ->select(
                'kategoris.nama_kategori as kategori',
                DB::raw('SUM(anggarans.nominal_yang_terpakai) as realisasi'),
                DB::raw('SUM(anggarans.jumlah_anggaran) as anggaran')
            )
            ->groupBy('kategoris.nama_kategori')
            ->orderBy('kategoris.nama_kategori')
            ->get();

        $kategoriLabels = $data->pluck('kategori');
        $realisasiData = $data->pluck('realisasi')->map(fn($v) => (int) $v)->values();
        $anggaranData = $data->pluck('anggaran')->map(fn($v) => (int) $v)->values();

        $jumlahDownload = DB::table('pdf_download_logs')
            ->where('user_id', Auth::user()->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        return view('application.visualisasi_data', compact(
            'laporan',
            'totalPemasukan',
            'totalPengeluaran',
            'totalSaldo',
            'totalAnggaran',
            'realisasi',
            'selisih',
            'transaksi',
            'kategoriData',
            'bulanLabels',
            'PemasukanSeries',
            'PengeluaranSeries',
            'kategoriLabels',
            'realisasiData',
            'anggaranData',
            'mode',
            'periode',
            'jumlahDownload',
            // Variabel Baru Insight Cerdas
            'statusTren',
            'perbandinganPersen',
            'rataRataPengeluaran'
        ));
    }

    // Export PDF
    public function exportPdf(Request $request)
    {
        $mode = $request->mode;
        $user = Auth::user(); // Ambil data user login

        // =====================================
        // MODE: RANGE BULAN (KHASUS PREMIUM)
        // =====================================
        if ($mode === 'range') {
            
            // Proteksi: Jika bukan premium, tendang balik
            if (!$user->is_premium) {
                return back()->with('error', 'Fitur cetak laporan rentang bulan hanya tersedia untuk pengguna Premium.');
            }

            $start = $request->start_month; 
            $end   = $request->end_month;   

            if (!$start || !$end) {
                return back()->with('error', 'Pilih periode bulan dengan benar.');
            }

            $startDate = date('Y-m-01', strtotime($start));
            $endDate   = date('Y-m-t', strtotime($end)); 

            $transaksi = Keuangan::where('keuangans.user_id', $user->id)->whereBetween('keuangans.tanggal', [$startDate, $endDate])->join('kategoris', 'keuangans.kategori_id', '=', 'kategoris.id_kategori')->orderBy('keuangans.tanggal')->select('keuangans.*', 'kategoris.nama_kategori')->get();

            $periode_label = date('F Y', strtotime($start)) . ' - ' . date('F Y', strtotime($end));
        }

        // =====================================
        // MODE: BULANAN (1 bulan)
        // =====================================
        elseif ($mode === 'bulanan') {

            $periode = $request->periode; // Format "2026-05"

            if (!$periode) {
                return back()->with('error', 'Pilih bulan terlebih dahulu.');
            }

            // Proteksi Limitasi untuk Pengguna Non-Premium
            if (!$user->is_premium) {

                // Hitung jumlah download bulan ini untuk periode tertentu
                $jumlahDownload = DB::table('pdf_download_logs')
                    ->where('user_id', $user->id)
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->count();

                // Jika sudah 3 kali atau lebih
                if ($jumlahDownload >= 3) {
                    return back()->with(
                        'alert',
                        'Batas anda sudah tercapai bulan ini! Upgrade ke Premium untuk mengunduh melebihi batas bulanan.'
                    );
                }
            }

            $bulan = date('m', strtotime($periode));
            $tahun = date('Y', strtotime($periode));

            $transaksi = Keuangan::where('keuangans.user_id', $user->id)
                ->whereMonth('keuangans.tanggal', $bulan)
                ->whereYear('keuangans.tanggal', $tahun)
                ->join('kategoris', 'keuangans.kategori_id', '=', 'kategoris.id_kategori')
                ->orderBy('keuangans.tanggal')
                ->select('keuangans.*', 'kategoris.nama_kategori')
                ->get();

            $periode_label = date('F Y', strtotime($periode));

            // Jika berhasil dan user NON-PREMIUM, catat ke database agar tidak bisa download lagi
            if (!$user->is_premium) {DB::table('pdf_download_logs')->insert(['user_id' => $user->id, 'periode_target' => $periode, 'created_at' => now(), 'updated_at' => now(),]);}
        }

        // =====================================
        // SUMMARY & GENERATE PDF
        // =====================================
        $total_pemasukan = $transaksi->where('jenis', 'Pemasukan')->sum('jumlah');
        $total_pengeluaran = $transaksi->where('jenis', 'Pengeluaran')->sum('jumlah');

        $pdf = Pdf::loadView('partials.pdf.laporan.export-pdf', [
            'mode' => $mode,
            'periode_label' => $periode_label,
            'transaksi' => $transaksi,
            'total_pemasukan' => $total_pemasukan,
            'total_pengeluaran' => $total_pengeluaran,
        ])->setPaper('a4', 'portrait')->setOption(['enable_php' => true]);

        return $pdf->download('laporan-keuangan.pdf');
    }
}