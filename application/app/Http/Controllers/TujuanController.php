<?php

namespace App\Http\Controllers;

use App\Models\Tujuan;
use App\Models\Keuangan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TujuanController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $tujuan = Tujuan::where('user_id', $userId)
            ->orderByRaw("CASE WHEN status = 'active' THEN 0 ELSE 1 END") // active dulu
            ->orderBy('deadline', 'asc')    // ⬅ urut dari deadline tercepat
            ->orderBy('created_at', 'desc') // opsional: jika deadline sama, yang terbaru ditampilkan dulu
            ->paginate(9)   // ⬅ tampilkan 9 kartu per halaman
            ->through(function ($item) {
                // ========== Progress Nominal ==========
                $item->persen_nominal = ($item->target_nominal > 0)
                    ? ($item->nominal_saat_ini / $item->target_nominal) * 100
                    : 0;

                $item->warna_nominal =
                    $item->persen_nominal < 25 ? '#FF0000' : (
                        $item->persen_nominal < 80 ? '#FF9800' : (
                            $item->persen_nominal < 100 ? '#4CAF50' : '#00FF00'
                        )
                    );

                // ========== Progress Waktu ==========
                $tanggalMulai = Carbon::parse($item->created_at);
                $deadline = Carbon::parse($item->deadline)->endOfDay();
                $sekarang = Carbon::now();

                if ($deadline->lessThanOrEqualTo($tanggalMulai)) {
                    // Kalau deadline lebih cepat dari tanggal mulai
                    $item->progress_hari = 100;
                    $item->total_hari = 0;
                } else {
                    $totalDetik = $tanggalMulai->diffInRealSeconds($deadline);
                    $detikBerjalan = $tanggalMulai->diffInRealSeconds($sekarang);

                    // Pastikan tidak negatif & tidak lebih dari 100%
                    $item->progress_hari = min(max(($detikBerjalan / $totalDetik) * 100, 0), 100);
                    $item->total_hari = round($totalDetik / 86400, 1);
                }

                // Hitung sisa waktu menuju deadline (format: X tahun Y bulan Z hari A jam)
                if ($deadline->greaterThan($sekarang)) {

                    $diff = $sekarang->diff($deadline);

                    // Ambil seluruh komponen waktu
                    $item->sisa_tahun = $diff->y;
                    $item->sisa_bulan = $diff->m;
                    $item->sisa_hari  = $diff->d;
                    $item->sisa_jam   = $diff->h;

                } else {
                    $item->sisa_tahun = 0;
                    $item->sisa_bulan = 0;
                    $item->sisa_hari  = 0;
                    $item->sisa_jam   = 0;
                }

                $item->warna_hari = $item->progress_hari < 70
                    ? '#2196F3'
                    : ($item->progress_hari < 100 ? '#FFC107' : '#F44336');

                return $item;
            });

        // ========== Hitung total keuangan ==========
        $totalPemasukan = Keuangan::where('user_id', Auth::id())
            ->where('jenis', 'Pemasukan')
            ->sum('jumlah');
        $totalPengeluaran = Keuangan::where('user_id', Auth::id())
            ->where('jenis', 'Pengeluaran')
            ->sum('jumlah');
        $totalSaldo = $totalPemasukan - $totalPengeluaran;

        // ========== Hitung summary Tujuan ==========
        $totalTabungan = $tujuan->sum('nominal_saat_ini');
        $totalTarget = $tujuan->sum('target_nominal');
        $sisaTarget = $totalTarget - $totalTabungan;

        return view('application.tujuan_finansial', compact(
            'tujuan',
            'totalSaldo',
            'totalTabungan',
            'totalTarget',
            'sisaTarget'
        ));
    }

    public function store(Request $request)
    {
        $userId = auth()->id();
        $user = auth()->user();

        // 1. Hitung Saldo Saat Ini
        $saldoUser = auth()->user()->total_saldo;

        // --- LOGIKA LIMITASI SAAS ---
        $jumlahTujuan = Tujuan::where('user_id', $userId)->count();

        if (!$user->is_premium && $jumlahTujuan >= 1) {
            return redirect()
                ->back()
                ->with('error', '<strong>Batas Tercapai!</strong> Pengguna freemium hanya dapat membuat 1 tujuan finansial. <a href="/plans" class="alert-link">Upgrade ke Premium</a> untuk tanpa batas!');
        }
        // ----------------------------

        // 1. Validasi Manual
        $validator = Validator::make($request->all(), [
            'nama_tujuan' => 'required|string|max:255',
            'target_nominal' => 'required|numeric|min:1',
            'nominal_saat_ini' => 'nullable|numeric|min:0|lte:target_nominal',
            'deadline' => 'required|date',
        ], [
            'nominal_saat_ini.lte' => 'Gagal! Nominal awal tidak boleh melebihi target nominal.',
        ]);

        // 2. Jika validasi form gagal, kirim sebagai session 'error'
        if ($validator->fails()) {
            return back()
                ->withErrors($validator) // Tetap sertakan ini agar input lama tidak hilang
                ->withInput()
                ->with('error', $validator->errors()->first()); // Ambil pesan error pertama untuk alert
        }

        // Mengambil data yang lolos validasi!
        $validated = $validator->validated();

        $nominalInput = $validated['nominal_saat_ini'] ?? 0;

        // 3. CEK: Apakah saldo cukup untuk nominal awal?
        if ($nominalInput > $saldoUser) {
            return back()
                ->with('error', 'Saldo tidak cukup! Saldo Anda saat ini: Rp ' . number_format($saldoUser, 0, ',', '.'))
                ->withInput();
        }

        // Lanjutkan simpan data...
        $validated['user_id'] = $userId; // ✅ sesuai akun user
        $validated['nominal_saat_ini'] = $nominalInput;

        // Simpan data tujuan dulu
        $tujuan = Tujuan::create($validated);

        // Cari atau buat kategori "Tujuan Finansial"
        $kategori = \App\Models\Kategori::firstOrCreate(
            [
                'nama_kategori' => 'Tujuan Finansial',
                'user_id' => $userId
            ],
            [
                'jenis' => 'Pengeluaran',
                'is_auto' => false
            ]
        );

        // Jika nominal_saat_ini > 0, otomatis buat catatan keuangan
        if ($tujuan->nominal_saat_ini > 0) {
            // Jika kategori sudah ada tapi belum is_auto → update
            if (!$kategori->is_auto) {
                $kategori->update(['is_auto' => false]);
            }

            // Simpan catatan keuangan
            \App\Models\Keuangan::create([
                'user_id' => $userId,
                'tanggal' => now(),
                'jenis' => 'Pengeluaran',
                'kategori_id' => $kategori->id_kategori,
                'tujuan_id' => $tujuan->id,
                'jumlah' => $tujuan->nominal_saat_ini,
                'keterangan' => 'Tujuan: ' . $tujuan->nama_tujuan,
                'is_auto' => true, // 👈 tanda transaksi otomatis
            ]);
        }

        return redirect()
            ->route('tujuan.index')
            ->with('success', 'Tujuan berhasil ditambahkan!');
    }

    public function add(Request $request, $id)
    {
        $request->validate([
            'nominal_saat_ini' => 'required|numeric|min:0',
        ]);
        $tujuan = Tujuan::findOrFail($id);
        $userId = Auth::id();

        // Hitung Saldo
        $saldoUser = auth()->user()->total_saldo;

        $nominalTambahan = $request->nominal_saat_ini;
        $totalBaru = $tujuan->nominal_saat_ini + $nominalTambahan;

        // CEK 1: Saldo cukup?
        if ($nominalTambahan > $saldoUser) {
            return back()->with('error', 'Saldo tidak cukup untuk menambah nominal ini.')->withInput();
        }

        // CEK 2: Melebihi target?
        if ($totalBaru > $tujuan->target_nominal) {
            return back()->with('error', 'Penambahan melebihi target tujuan.')->withInput();
        }

        // update nominal saat ini
        $tambahNominalTujuan = $request->nominal_saat_ini + $tujuan->nominal_saat_ini;

        // Update progress otomatis
        $tujuan->progress = min(100, floor(($tambahNominalTujuan / $tujuan->target_nominal) * 100));

        // CEK: tidak boleh melebihi target
        if ($tambahNominalTujuan > $tujuan->target_nominal) {
            return back()
                ->withErrors(['nominal_saat_ini' => 'Penambahan melebihi target tujuan.'])
                ->with('error', 'Nominal tidak boleh melebihi target.')
                ->withInput();
        }

        // Update nominal di tabel tujuan
        $tujuan->update([
            'nominal_saat_ini' => $tambahNominalTujuan,
            'progress' => $tujuan->progress,
        ]);

        // Jika ada perubahan nominal, buat record keuangan otomatis
        if ($tambahNominalTujuan > 0) {
            // Cari kategori "Tujuan Finansial"
            $kategori = \App\Models\Kategori::firstOrCreate(
                ['nama_kategori' => 'Tujuan Finansial', 'user_id' => Auth::id()],
                ['jenis' => 'Pengeluaran', 'is_auto' => false]
            );

            // Simpan ke tabel keuangan
            \App\Models\Keuangan::create([
                'user_id' => Auth::id(),
                'tanggal' => now(),
                'jenis' => 'Pengeluaran',
                'kategori_id' => $kategori->id_kategori,
                'tujuan_id' => $tujuan->id,
                'jumlah' => $request->nominal_saat_ini,
                'keterangan' => 'Tujuan: ' . $tujuan->nama_tujuan,
                'is_auto' => true, // 👈 tanda transaksi otomatis
            ]);
        }

        return redirect()
            ->route('tujuan.index')
            ->with('success', 'Nominal berhasil diperbarui!');
    }

    /**
     * Update data tujuan (nama_tujuan, target_nominal, deadline)
     */
    public function perbarui(Request $request, $id)
    {
        $tujuan = Tujuan::where('id', $id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        // Validasi
        $validated = $request->validate([
            'nama_tujuan'     => 'required|string|max:255',
            'target_nominal'  => 'required|integer|min:1',
            'deadline' => 'required|date',
        ]);

        // Update data utama
        $tujuan->update([
            'nama_tujuan'    => $validated['nama_tujuan'],
            'target_nominal' => $validated['target_nominal'],
            'deadline'       => $validated['deadline'],
        ]);

        // Recalculate progress
        $tujuan->progress = min(100, floor(($tujuan->nominal_saat_ini / $tujuan->target_nominal) * 100));
        $tujuan->save();

        return redirect()
            ->route('tujuan.index')
            ->with('success', 'Data Tujuan Finansial berhasil diperbarui!');
    }

    public function destroy(Request $request, $id)
    {
        $tujuan = Tujuan::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $opsi = $request->input('opsi_hapus');

        DB::transaction(function () use ($tujuan, $opsi) {
            if ($opsi === 'hapus_semua') {
                // OPSI 1: Hapus tujuan beserta semua riwayat keuangan terkait
                \App\Models\Keuangan::where('tujuan_id', $tujuan->id)->delete();
            } 
            elseif ($opsi === 'kembalikan_saldo') {
                // OPSI 2: Kembalikan nominal_saat_ini ke saldo (Pemasukan)
                if ($tujuan->nominal_saat_ini > 0) {
                    $kategori = \App\Models\Kategori::firstOrCreate(
                        ['nama_kategori' => 'Pengembalian Dana Tujuan', 'user_id' => auth()->id()],
                        ['jenis' => 'Pemasukan', 'is_auto' => true]
                    );

                    \App\Models\Keuangan::create([
                        'user_id' => auth()->id(),
                        'tanggal' => now(),
                        'jenis' => 'Pemasukan',
                        'kategori_id' => $kategori->id_kategori,
                        'jumlah' => $tujuan->nominal_saat_ini,
                        'keterangan' => 'Pengembalian dana dari penghapusan tujuan: ' . $tujuan->nama_tujuan,
                        'is_auto' => true,
                    ]);
                }
                
                // Set tujuan_id di transaksi lama menjadi null agar record keuangan tidak hilang tapi tidak terikat tujuan lagi
                \App\Models\Keuangan::where('tujuan_id', $tujuan->id)->update(['tujuan_id' => null]);
            }

            $tujuan->delete();
        });

        return redirect()->route('tujuan.index')
            ->with('success', 'Tujuan berhasil dihapus dengan opsi yang dipilih.');
    }

    public function pakai($id)
    {
        $tujuan = Tujuan::where('id', $id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        // Pastikan sudah 100%
        if ($tujuan->nominal_saat_ini < $tujuan->target_nominal) {
            return back()->with('error', 'Tujuan belum mencapai 100%.');
        }

        // Simpan nilai terakhir sebelum di-reset
        $tujuan->nominal_saat_ini_terakhir = $tujuan->nominal_saat_ini;
        $tujuan->target_nominal_terakhir = $tujuan->target_nominal;

        // Reset nominal dan target, update status
        $tujuan->nominal_saat_ini = 0;
        $tujuan->target_nominal = 0;
        $tujuan->status = 'used';

        $tujuan->save();

        return back()->with('success', 'Tabungan tujuan telah digunakan.');
    }

    public function tarik($id)
    {
        $tujuan = Tujuan::where('id', $id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        if ($tujuan->nominal_saat_ini < $tujuan->target_nominal) {
            return back()->with('error', 'Tujuan belum mencapai 100%.');
        }

        // Cari kategori "Tujuan Finansial"
        $kategori = \App\Models\Kategori::firstOrCreate(
            ['nama_kategori' => 'Tujuan Finansial', 'user_id' => Auth::id()],
            ['jenis' => 'Pengeluaran', 'is_auto' => false]
        );

        // Catat sebagai pemasukan
        Keuangan::create([
            'user_id' => Auth::id(),
            'tanggal' => now(),
            'jenis' => 'Pemasukan',
            'kategori_id' => $kategori->id_kategori,
            'jumlah' => $tujuan->nominal_saat_ini,
            'keterangan' => 'Penarikan tabungan dari tujuan: ' . $tujuan->nama_tujuan,
            'is_auto' => true,
        ]);

        // Simpan nilai terakhir sebelum di-reset
        $tujuan->nominal_saat_ini_terakhir = $tujuan->nominal_saat_ini;
        $tujuan->target_nominal_terakhir = $tujuan->target_nominal;

        // Reset nominal dan target, update status
        $tujuan->nominal_saat_ini = 0;
        $tujuan->target_nominal = 0;
        $tujuan->status = 'withdrawn';

        $tujuan->save();

        return back()->with('success', 'Dana tujuan telah ditarik ke pemasukan.');
    }
}
