<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\Kategori;
use App\Models\Anggaran;
use App\Models\Tujuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        // =========================
        // QUERY DASAR (UNTUK FILTER)
        // =========================
        $baseQuery = Keuangan::where('user_id', Auth::id())->with('kategori');

        // ============================
        // FILTER BY DATE RANGE
        // ============================

        if ($request->filter) {
            switch ($request->filter) {
                case 'today':
                    $baseQuery->whereDate('tanggal', Carbon::today());
                    break;
                case 'this_week':
                    $baseQuery->whereBetween('tanggal', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ]);
                    break;

                case 'this_month':
                    $baseQuery->whereMonth('tanggal', now()->month)
                            ->whereYear('tanggal', now()->year);
                    break;
                case 'monthly':
                    // format input: 2026-01 (YYYY-MM)
                    if ($request->filled('month')) {
                        $month = Carbon::parse($request->month);
                        $baseQuery->whereMonth('tanggal', $month->month)
                                ->whereYear('tanggal', $month->year);
                    }
                    break;
            }
        }

        // FILTER RANGE MANUAL
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $baseQuery->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }

        // FILTER KATEGORI
        if ($request->filled('kategori')) {
            $baseQuery->whereHas('kategori', function ($q) use ($request) {
                $q->where('nama_kategori', $request->kategori);
            });
        }

        // SEARCH (Pencarian di DB)
        if ($request->filled('search')) {
            $search = $request->search;
            $baseQuery->where(function ($q) use ($search) {
                $q->where('keterangan', 'like', "%$search%")
                ->orWhere('tanggal', 'like', "%$search%")
                ->orWhere('jenis', 'like', "%$search%")
                ->orWhereHas('kategori', function ($k) use ($search) {
                    $k->where('nama_kategori', 'like', "%$search%");
                });
            });
        }

        // =========================
        // TOTAL SUMMARY (TANPA PAGINASI) SESUAI FILTER
        // =========================
        $queryPemasukan = clone $baseQuery;
        $queryPengeluaran = clone $baseQuery;
        if (
            !$request->filled('filter') &&
            !$request->filled('search') &&
            !$request->filled('start_date')
        ) {
            $queryPemasukan->where('tanggal', '>=', Carbon::now()->startOfMonth());
            $queryPengeluaran->where('tanggal', '>=', Carbon::now()->startOfMonth());
        }
        $tampilanPemasukan = $queryPemasukan
            ->where('jenis', 'Pemasukan')
            ->sum('jumlah');
        $tampilanPengeluaran = $queryPengeluaran
            ->where('jenis', 'Pengeluaran')
            ->sum('jumlah');
        $totalPemasukan = (clone $baseQuery)
            ->where('jenis', 'Pemasukan')
            ->sum('jumlah');
        $totalPengeluaran = (clone $baseQuery)
            ->where('jenis', 'Pengeluaran')
            ->sum('jumlah');
        $totalSaldo = $totalPemasukan - $totalPengeluaran;
        // Analisis Perbandingan Alltime vs Filter (Premium)
        // 1. Ambil Saldo Berdasarkan Filter (Sudah ada di kode Anda)
        $totalPemasukanFilter = (clone $baseQuery)->where('jenis', 'Pemasukan')->sum('jumlah');
        $totalPengeluaranFilter = (clone $baseQuery)->where('jenis', 'Pengeluaran')->sum('jumlah');
        $totalSaldoFilter = $totalPemasukanFilter - $totalPengeluaranFilter;
        // 2. Ambil Saldo Keseluruhan (All Time) - Khusus disiapkan untuk pengecekan
        // Query yang hanya dikunci oleh user_id tanpa filter lain
        $allTimeQuery = Keuangan::where('user_id', Auth::id());
        $totalPemasukanAll = (clone $allTimeQuery)->where('jenis', 'Pemasukan')->sum('jumlah');
        $totalPengeluaranAll = (clone $allTimeQuery)->where('jenis', 'Pengeluaran')->sum('jumlah');
        $totalSaldoAll = $totalPemasukanAll - $totalPengeluaranAll;
        // Logika Label Dinamis
        $filterNames = [
            'today'      => 'Hari Ini',
            'this_week'  => 'Minggu Ini',
            'this_month' => 'Bulan Ini',
            'monthly'    => 'Bulanan',
        ];
        $labelFilter = 'Seluruh Waktu';
        if ($request->filter && isset($filterNames[$request->filter])) {
            $labelFilter = $filterNames[$request->filter];
            
            // Jika filter adalah 'monthly' dan ada input bulan (YYYY-MM)
            if ($request->filter === 'monthly' && $request->filled('month')) {
                $labelFilter = \Carbon\Carbon::parse($request->month)->translatedFormat('F Y');
            }
        } elseif ($request->filled('start_date')) {
            $labelFilter = $request->start_date . ' s/d ' . $request->end_date;
        } elseif ($request->filled('search')) {
            $labelFilter = "Hasil Cari: " . $request->search;
        }

        // =========================
        // DATA TABEL (PAKAI PAGINASI)
        // =========================
        $transaksiQuery = (clone $baseQuery);
        // LOGIKA BYPASS: 
        // Jika user TIDAK sedang mencari (search) DAN TIDAK sedang memfilter (filter/start_date)
        // Maka batasi hanya 3 bulan terakhir.
        if (!$request->filled('filter') && !$request->filled('search') && !$request->filled('start_date')) {
            $transaksiQuery->where('tanggal', '>=', Carbon::now()->startOfMonth());
        }
        $transaksi = $transaksiQuery
            ->orderBy('tanggal', 'asc')
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        $user = auth()->user();
        $catatan = Keuangan::where('user_id', $user->id)->get();
        $tujuan = Tujuan::where('user_id', $user->id)->get();

        // Hitung sisa upload bukti 2 bulan terakhir untuk user non-premium
        $duaBulanLalu = now()->subMonths(2);
        $jumlahUpload = $user->keuangans()
            ->whereNotNull('bukti')
            ->where('created_at', '>=', $duaBulanLalu)
            ->count();
            
        $sisaUpload = max(0, 40 - $jumlahUpload);
        $limitSaldo = 6000000;

        return view('application.pencatatan_keuangan', compact(
            'transaksi',
            'tampilanPemasukan',
            'tampilanPengeluaran',
            'totalSaldo',
            'totalPemasukan',
            'totalPengeluaran',
            'totalPemasukanFilter',
            'totalPengeluaranFilter',
            'totalSaldoAll',
            'totalPemasukanAll',
            'totalPengeluaranAll',
            'labelFilter',
            'catatan', 'tujuan', 'user', 'sisaUpload', 'limitSaldo'
        ));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $nominal = (int) $request->jumlah;
        $jenis = $request->jenis;

        // =========================
        // VALIDASI FORM DASAR
        // =========================
        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:Pemasukan,Pengeluaran',
            'kategori_id' => 'required|exists:kategoris,id_kategori',
            'jumlah' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string|max:255',
            'bukti' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'tujuan_id' => 'nullable|exists:tujuan,id'
        ]);

        $kategori = Kategori::findOrFail($request->kategori_id);

        $isExists = Kategori::where('id_kategori', $request->kategori_id)
                        ->where('jenis', $request->jenis)
                        ->exists();

        if (!$isExists) {
            return back()->with('error', 'Kategori tidak sesuai dengan jenis!');
        }

        $excludedCategories = ['Tujuan Finansial', 'Hutang', 'Piutang', 'Tagihan'];

        // ==========================================
        // VALIDASI PREMIUM UNTUK KATEGORI CUSTOM
        // ==========================================
        // Jika kategori memiliki user_id (artinya kategori buatan sendiri)
        // dan user tersebut bukan user premium
        // Cek jika kategori punya user_id, user bukan premium, DAN nama kategori bukan 'Tujuan Finansial'
        if (!is_null($kategori->user_id) && !$user->is_premium && !in_array($kategori->nama_kategori, $excludedCategories)) {
            return redirect()->back()
                ->with('show_paywall', true)
                ->with('alert', 'Fitur kategori kustom hanya tersedia untuk akun Premium!')
                ->withInput();
        }

        // =========================
        // VALIDASI LIMIT SALDO
        // =========================
        if ($user->isExceedingLimit($nominal, $jenis)) {
            return redirect()->back()
                ->with('show_paywall', true)
                ->with('alert', 'Gagal! Saldo akun freemium tidak boleh melebihi Rp 6.000.000.');
        }

        // =======================================================
        // 🔥 VALIDASI LIMIT UPLOAD BUKTI (NON-PREMIUM)
        // =======================================================
        if (!$user->is_premium && $request->hasFile('bukti')) {
            // Hitung upload bukti dalam 2 bulan terakhir
            $duaBulanLalu = now()->subMonths(2);
            
            $jumlahUpload = $user->keuangans()
                ->whereNotNull('bukti')
                ->where('created_at', '>=', $duaBulanLalu)
                ->count();

            if ($jumlahUpload >= 40) {
                return redirect()->back()
                    ->with('show_paywall', true)
                    ->with('alert', 'Gagal! Batas upload bukti untuk akun freemium adalah 40 kali per 2 bulan. Upgrade ke Premium untuk upload tanpa batas!')
                    ->withInput();
            }
        }

        // =========================
        // VALIDASI TUJUAN FINANSIAL (🔥 PINDAH KE LUAR TRY)
        // =========================
        if ($kategori->nama_kategori === "Tujuan Finansial") {

            if (!$request->tujuan_id) {
                return redirect()->back()
                    ->with('error', 'Gagal! Tujuan wajib dipilih!')
                    ->withInput();
            }

            if ($nominal > $user->total_saldo) {
                return redirect()->back()
                    ->with('error', 'Gagal! Saldo tidak mencukupi untuk menabung ke tujuan finansial. Saldo Anda: ' . $user->saldo_rupiah)
                    ->withInput();
            }

            // ========================
            // VALIDASI TARGET NOMINAL
            // ========================
            $tujuan = Tujuan::where('id', $request->tujuan_id)
                            ->where('user_id', $user->id) // Keamanan: pastikan tujuan milik user yang login
                            ->firstOrFail();

            $sisa_target = $tujuan->target_nominal - $tujuan->nominal_saat_ini;

            // Cek jika tujuan sudah tercapai (sisa 0 atau minus)
            if ($sisa_target <= 0) {
                return redirect()->back()
                    ->with('error', 'Gagal! Tujuan finansial ini sudah tercapai atau melebihi target.')
                    ->withInput();
            }

            // Cek jika nominal input lebih besar dari sisa target
            if ($nominal > $sisa_target) {
                return redirect()->back()
                    ->with('error', 'Gagal! Nominal melebihi sisa target tujuan. Sisa target: Rp ' . number_format($sisa_target, 0, ',', '.'))
                    ->withInput();
            }
            // ==========================================

            // Cek apakah tujuan sudah selesai, digunakan, atau ditarik dananya
            if (in_array($tujuan->status, ['selesai', 'used', 'withdrawn'])) {
                return redirect()->back()
                    ->with('error', 'Gagal! Tidak bisa menabung ke tujuan finansial yang sudah tidak aktif/diselesaikan.')
                    ->withInput();
            }
        }

        // =========================
        // SIAPKAN DATA
        // =========================
        $data = $request->all();
        $data['user_id'] = $user->id;

        // =========================
        // BARU MASUK TRANSACTION
        // =========================
        DB::beginTransaction();

        try {

            // Ambil tujuan (kalau ada)
            if ($kategori->nama_kategori === "Tujuan Finansial") {
                $tujuan = Tujuan::findOrFail($request->tujuan_id);

                // SET KETERANGAN OTOMATIS
                $data['keterangan'] = $tujuan->nama_tujuan . ': ' . ($request->keterangan ?? '-');
            }

            // Upload bukti
            if ($request->hasFile('bukti')) {
                $file = $request->file('bukti');
                $filename = $user->id . '_' . time() . '_' . $file->getClientOriginalName();

                $file->storeAs('bukti', $filename, 'public');
                $data['bukti'] = 'storage/bukti/' . $filename;
            }

            // Simpan transaksi
            $keuangan = Keuangan::create($data);

            // Update tujuan
            if ($kategori->nama_kategori === "Tujuan Finansial") {
                $tujuan->nominal_saat_ini += $nominal;

                if (!$tujuan->save()) {
                    throw new \Exception('Gagal mengupdate tujuan finansial.');
                }
            }

            DB::commit();

            return redirect()->back()
                ->with('success', 'Catatan transaksi berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();

            // simpan detail error ke log
            \Log::error($e);

            return redirect()->back()
                ->with('error', '❌ Transaksi gagal disimpan.')
                ->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $nominal = (int) $request->jumlah;
        $jenis = $request->jenis;
        
        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:Pemasukan,Pengeluaran',
            'kategori_id' => 'required|exists:kategoris,id_kategori',
            'jumlah' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string|max:255',
            'bukti' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $kategori = Kategori::findOrFail($request->kategori_id);

        $isExists = Kategori::where('id_kategori', $request->kategori_id)
                        ->where('jenis', $request->jenis)
                        ->exists();

        if (!$isExists) {
            return back()->with('error', 'Kategori tidak sesuai dengan jenis!');
        }

        $excludedCategories = ['Tujuan Finansial', 'Hutang', 'Piutang', 'Tagihan'];

        // Validasi Paywall Kategori
        if (!is_null($kategori->user_id) && !$user->is_premium && !in_array($kategori->nama_kategori, $excludedCategories)) {
            return redirect()->back()
                ->with('show_paywall', true)
                ->with('alert', 'Kategori ini hanya untuk member Premium.')
                ->withInput();
        }

        // Cek Limit Saldo user gratis
        if ($user->isExceedingLimit($nominal, $jenis)) {
            return redirect()->back()
                ->with('show_paywall', true)
                ->with('alert', 'Gagal! Saldo akun freemium tidak boleh melebihi Rp 6.000.000.');
        }

        // Limit Upload Bukti
        if (!$user->is_premium && $request->hasFile('bukti')) {
            // Hitung upload bukti dalam 2 bulan terakhir
            $duaBulanLalu = now()->subMonths(2);
            
            $jumlahUpload = $user->keuangans()
                ->whereNotNull('bukti')
                ->where('created_at', '>=', $duaBulanLalu)
                ->count();

            if ($jumlahUpload >= 40) {
                return redirect()->back()
                    ->with('show_paywall', true)
                    ->with('alert', 'Gagal! Batas upload bukti untuk akun freemium adalah 40 kali per 2 bulan. Upgrade ke Premium untuk upload tanpa batas!')
                    ->withInput();
            }
        }

        $keuangan = Keuangan::where('id', $id)
                            ->where('user_id', Auth::id()) // filter user
                            ->firstOrFail();

        $data = $request->all();
        $data['user_id'] = Auth::id(); // ✅ user_id ditambahkan di sini

        // Handle file bukti
        if ($request->hasFile('bukti')) {
            // Hapus bukti lama kalau ada
            if ($keuangan->bukti && file_exists(public_path($keuangan->bukti))) {
                unlink(public_path($keuangan->bukti));
            }

            // Upload bukti baru
            $file = $request->file('bukti');
            $filename = Auth::id() . '_' . time() . '_' . $file->getClientOriginalName();
            $file->storeAs('bukti', $filename, 'public');
            $data['bukti'] = 'storage/bukti/' . $filename;
        }

        $keuangan->update($data);

        return redirect()->back()->with('success', 'Catatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $keuangan = Keuangan::findOrFail($id);

            if (
                $keuangan->kategori->nama_kategori === "Tujuan Finansial"
                && $keuangan->tujuan_id
            ) {
                $tujuan = Tujuan::find($keuangan->tujuan_id); // ⬅️ BUKAN findOrFail

                if ($tujuan) {
                    $tujuan->nominal_saat_ini -= $keuangan->jumlah;
                    $tujuan->nominal_saat_ini = max(0, $tujuan->nominal_saat_ini);
                    $tujuan->save();
                }
                // jika tujuan sudah tidak ada → lanjut hapus transaksi
            }

            $keuangan->delete();

            DB::commit();

            return redirect()->back()
                ->with('success', 'Transaksi berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->with('error', '❌ Gagal menghapus transaksi.')
                ->withErrors(['exception' => $e->getMessage()]);
        }
    }

}
