<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    /**
     * Halaman utama pengelolaan kategori (Premium Only)
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user->is_premium) {
            return view('application.pengelolaan_kategori', [
                'kategori'     => collect(),
                'isPremium'    => false,
                'stats'        => null,
                'currentJenis' => 'semua',
                'search'       => '',
            ]);
        }

        $query = Kategori::where('user_id', $user->id)
            ->where('nama_kategori', '!=', 'Tujuan Finansial') // Tambahkan baris ini
            ->withCount('keuangans');

        // Filter berdasarkan jenis
        $currentJenis = $request->get('jenis', 'semua');
        if ($currentJenis !== 'semua') {
            $query->where('jenis', $currentJenis);
        }

        // Pencarian
        $search = $request->get('search', '');
        if ($search !== '') {
            $query->where('nama_kategori', 'like', '%' . $search . '%');
        }

        $kategori = $query->orderBy('jenis', 'asc')
            ->orderBy('is_auto', 'desc')
            ->orderBy('nama_kategori', 'asc')
            ->get();

        $stats = [
            'total'       => Kategori::where('user_id', $user->id)
                                ->where('nama_kategori', '!=', 'Tujuan Finansial')->count(),
            'pemasukan'   => Kategori::where('user_id', $user->id)->where('jenis', 'pemasukan')
                                ->where('nama_kategori', '!=', 'Tujuan Finansial')->count(),
            'pengeluaran' => Kategori::where('user_id', $user->id)->where('jenis', 'pengeluaran')
                                ->where('nama_kategori', '!=', 'Tujuan Finansial')->count(),
        ];

        return view('application.pengelolaan_kategori', [
            'kategori'     => $kategori,
            'isPremium'    => true,
            'stats'        => $stats,
            'currentJenis' => $currentJenis,
            'search'       => $search,
        ]);
    }

    /**
     * Simpan kategori baru via AJAX
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->is_premium) {
            return response()->json([
                'message' => 'Fitur ini hanya tersedia untuk pengguna premium.',
            ], 403);
        }

        $request->validate([
            'nama_kategori' => 'required|string|max:50|unique:kategoris,nama_kategori,NULL,id_kategori,user_id,' . $user->id,
            'jenis'         => 'required|in:pemasukan,pengeluaran',
            'icon'          => 'nullable|string|max:50',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.max'      => 'Nama kategori maksimal 50 karakter.',
            'nama_kategori.unique'   => 'Kategori dengan nama ini sudah ada.',
            'jenis.required'         => 'Jenis kategori wajib dipilih.',
            'jenis.in'               => 'Jenis kategori tidak valid.',
        ]);

        $kategori = Kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'jenis'         => $request->jenis,
            'icon'          => $request->input('icon', 'bi-tag'), // Simpan ikon kustom
            'user_id'       => $user->id,
            'is_auto'       => false,
        ]);

        $kategori->loadCount('keuangans');

        return response()->json([
            'message' => 'Kategori "' . $kategori->nama_kategori . '" berhasil ditambahkan.',
            'data'    => $kategori,
        ], 201);
    }

    /**
     * Perbarui kategori via AJAX
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user->is_premium) {
            return response()->json([
                'message' => 'Fitur ini hanya tersedia untuk pengguna premium.',
            ], 403);
        }

        $kategori = Kategori::where('id_kategori', $id)
            ->where('user_id', $user->id)
            ->where('is_auto', false)
            ->firstOrFail();

        $request->validate([
            'nama_kategori' => 'required|string|max:50|unique:kategoris,nama_kategori,' . $id . ',id_kategori,user_id,' . $user->id,
            'jenis'         => 'required|in:pemasukan,pengeluaran',
            'icon'          => 'nullable|string|max:50',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.max'      => 'Nama kategori maksimal 50 karakter.',
            'nama_kategori.unique'   => 'Kategori dengan nama ini sudah ada.',
            'jenis.required'         => 'Jenis kategori wajib dipilih.',
            'jenis.in'               => 'Jenis kategori tidak valid.',
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'jenis'         => $request->jenis,
            'icon'          => $request->input('icon', 'bi-tag'), // Update ikon kustom
        ]);

        $kategori->loadCount('keuangans');

        return response()->json([
            'message' => 'Kategori berhasil diperbarui.',
            'data'    => $kategori,
        ]);
    }

    /**
     * Hapus kategori via AJAX
     */
    public function destroy($id)
    {
        $user = Auth::user();

        if (!$user->is_premium) {
            return response()->json([
                'message' => 'Fitur ini hanya tersedia untuk pengguna premium.',
            ], 403);
        }

        $kategori = Kategori::where('id_kategori', $id)
            ->where('user_id', $user->id)
            ->where('is_auto', false)
            ->firstOrFail();

        $usageCount = $kategori->keuangans()->count();

        if ($usageCount > 0) {
            return response()->json([
                'message' => 'Kategori ini tidak bisa dihapus karena masih digunakan oleh ' . $usageCount . ' transaksi.',
            ], 422);
        }

        $nama = $kategori->nama_kategori;
        $kategori->delete();

        return response()->json([
            'message' => 'Kategori "' . $nama . '" berhasil dihapus.',
        ]);
    }

    /**
     * Ambil daftar kategori berdasarkan jenis dengan validasi premium (untuk dropdown)
     */
    public function getByJenis($jenis)
    {
        $user = auth()->user();
        $userId = $user->id;

        $kategori = Kategori::where('jenis', $jenis)
            ->where(function ($query) use ($userId, $user) {

                $query->whereNull('user_id');

                $query->orWhere(function ($subQuery) use ($userId, $user) {
                    $subQuery->where('user_id', $userId)
                    ->where(function ($q) use ($user) {

                        if ($user->is_premium) {
                            $q->whereRaw('1 = 1');
                        } else {
                            $q->where('nama_kategori', 'Tujuan Finansial');
                        }
                    });
                });
            })
            ->where('is_auto', false)

            // PRIORITAS URUTAN
            ->orderByRaw("
                CASE
                    WHEN nama_kategori IN ('Lainnya', 'Lain-lain') THEN 999
                    ELSE 0
                END ASC
            ")

            // urutan normal
            ->orderBy('nama_kategori', 'asc')

            ->get([
                'id_kategori',
                'nama_kategori',
                'icon'
            ]);

        return response()->json($kategori);
    }
}