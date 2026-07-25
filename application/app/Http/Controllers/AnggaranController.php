<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\Kategori;
use App\Models\Keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Carbon\Carbon;

class AnggaranController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        // Ambil tanggal acuan (default hari ini)
        $periode = $request->get('periode', now()->format('Y-m-d'));
        $tanggalAcuan = Carbon::createFromFormat('Y-m-d', $periode);

        $tahunIni = Carbon::now()->format('Y');
        $mode = $request->get('mode', 'bulanan');

        // Pastikan setiap kategori pengeluaran punya entri anggaran bulan ini
        $kategoris = Kategori::where(function ($query) {
                $query->whereNull('user_id')
                    ->orWhere('user_id', Auth::id());
            })
            ->where('jenis', 'Pengeluaran')
            ->where('is_auto', false) 
            ->orderBy('nama_kategori')
            ->get();

        $filter = $request->get('filter', 'bulanan');
        // Dari tanggal acuan, ambil info waktu
        $awalBulan = $tanggalAcuan->copy()->startOfMonth();
        $akhirBulan = $tanggalAcuan->copy()->endOfMonth();

        // Untuk mode mingguan
        $awalMinggu = $tanggalAcuan->copy()->startOfWeek(Carbon::MONDAY);
        $akhirMinggu = $tanggalAcuan->copy()->endOfWeek(Carbon::SUNDAY);

        // Periode bulanan untuk pencocokan di database (tetap pakai Y-m)
        $periodeBulan = $tanggalAcuan->format('Y-m');

        $anggarans = Anggaran::with('kategori')
            ->where('user_id', $user->id)
            ->where('periode', $periodeBulan)
            ->get()
            ->map(function ($item) use (
                $user, $awalBulan, $akhirBulan, $awalMinggu, $akhirMinggu, 
                $tanggalAcuan, $mode
            ) {

                $query = Keuangan::where('user_id', $user->id)
                    ->where('kategori_id', $item->kategori_id)
                    ->where('jenis', 'Pengeluaran');

                switch ($mode) {
                    case 'harian':
                        $query->whereDate('tanggal', $tanggalAcuan);
                        break;
                    case 'mingguan':
                        $query->whereBetween('tanggal', [$awalMinggu, $akhirMinggu]);
                        break;
                    default:
                        $query->whereBetween('tanggal', [$awalBulan, $akhirBulan]);
                }

                $terpakai = $query->sum('jumlah');

                $jumlahAnggaran = $item->jumlah_anggaran;
                $hariDalamBulan = $tanggalAcuan->daysInMonth;

                if ($mode === 'harian') {
                    $jumlahAnggaran /= $hariDalamBulan;
                } elseif ($mode === 'mingguan') {
                    $mingguDalamBulan = ceil($hariDalamBulan / 7);
                    $jumlahAnggaran /= $mingguDalamBulan;
                }

                return $item;
            });

        // Ambil kategori yang belum dipakai di periode ini
        $kategoriTersedia = Kategori::where(function ($query) use ($user) {
                $query->whereNull('user_id')
                    ->orWhere('user_id', $user->id);
            })
            ->where('jenis', 'Pengeluaran')
            ->where('is_auto', false)
            ->whereDoesntHave('anggaran', function ($query) use ($periodeBulan, $user) {
                $query->where('user_id', $user->id)
                    ->where('periode', $periodeBulan);
            })
            // PRIORITAS URUTAN
            ->orderByRaw("
                CASE
                    WHEN nama_kategori IN ('Lain-lain') THEN 999
                    ELSE 0
                END ASC
            ")
            ->orderBy('nama_kategori')
            ->get([
                'id_kategori',
                'nama_kategori',
                'icon'
            ]);

        return view('application.pengelolaan_anggaran', compact('anggarans', 'mode', 'filter', 'periode', 'kategoriTersedia'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $periode = Carbon::now()->format('Y-m');
        $tahunIni = Carbon::now()->format('Y');

        // 1. Validasi Dasar
        $request->validate([
            'jumlah_anggaran' => 'required|numeric|min:0',
            'kategori_id' => 'required',
            'nama_kategori' => 'nullable|string|required_if:kategori_id,new',
        ]);

        // 2. PROTEKSI PREMIUM: Cek jika user mencoba buat kategori baru tapi bukan premium
        if ($request->kategori_id === 'new' && !$user->is_premium) {
            return redirect()->back()->with('error', '⚠️ <strong>Fitur Premium!</strong><br>Membuat kategori kustom hanya tersedia untuk pengguna Premium. Silakan pilih kategori yang tersedia atau <a href="'.route('premium.upgrade').'">Upgrade Sekarang</a>.');
        }

        try {
            $request->validate([
                'jumlah_anggaran' => 'required|numeric|min:0',
                'kategori_id' => [
                    'nullable',
                    function ($attribute, $value, $fail) {
                        if ($value !== 'new' && !is_null($value)) {
                            if (!\App\Models\Kategori::where('id_kategori', $value)->exists()) {
                                $fail('Kategori tidak ditemukan.');
                            }
                        }
                    }
                ],
                'nama_kategori' => 'nullable|string|required_if:kategori_id,new',
            ]);

            // Jika pilih kategori baru
            if ($request->kategori_id === 'new') {

                // Cek bentrok dengan kategori default
                $kategoriDefault = Kategori::whereNull('user_id')
                    ->where('nama_kategori', $request->nama_kategori)
                    ->first();

                if ($kategoriDefault) {
                    return redirect()->back()->with('error', '❌ Nama kategori sudah digunakan sebagai kategori default. Silakan gunakan nama lain.');
                }

                // Cek bentrok dengan kategori user sendiri
                $kategoriUser = Kategori::where('user_id', $user->id)
                    ->where('nama_kategori', $request->nama_kategori)
                    ->first();

                if ($kategoriUser) {
                    return redirect()->back()->with('error', '❌ Anda sudah memiliki kategori dengan nama tersebut.');
                }

                // ❗ Larangan nama kategori khusus "Tujuan Finansial"
                if (strtolower(trim($request->nama_kategori)) === 'tujuan finansial') {
                    return redirect()->back()->with('error', '❌ Nama kategori "Tujuan Finansial" tidak boleh digunakan karena merupakan kategori khusus sistem.');
                }

                // Jika aman → buat kategori
                $kategori = Kategori::create([
                    'nama_kategori' => $request->nama_kategori,
                    'jenis' => 'Pengeluaran',
                    'user_id' => $user->id,
                ]);

                $kategoriId = $kategori->id_kategori;

            } else {
                $kategoriId = $request->kategori_id;
            }

            // Buat anggaran baru
            Anggaran::create([
                'user_id' => $user->id,
                'kategori_id' => $kategoriId,
                'jumlah_anggaran' => $request->jumlah_anggaran,
                'periode' => $periode,
                'periode_tahun' => (string)$tahunIni
            ]);

            return redirect()->back()->with('success', 'Anggaran berhasil ditambahkan!');
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->back()->with('error', '❌ Gagal, Kategori tersebut sudah memiliki anggaran!');
            }
            throw $e;
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah_anggaran' => 'required|numeric|min:0',
        ]);

        $anggaran = Anggaran::findOrFail($id);
        $anggaran->update(['jumlah_anggaran' => $request->jumlah_anggaran]);

        return redirect()->back()->with('success', 'Anggaran berhasil diperbarui!');
    }

    // Hapus anggaran beserta kategori terkait
    public function destroy($id)
    {
        $anggaran = Anggaran::findOrFail($id);

        // Hapus data anggaran terlebih dahulu
        $anggaran->delete();

        // Jika request dari AJAX
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Anggaran berhasil dihapus!'
            ]);
        }

        // Fallback jika bukan AJAX
        return redirect()->back()->with('success', 'Anggaran berhasil dihapus!');
    }
}
