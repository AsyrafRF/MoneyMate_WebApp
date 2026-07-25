<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Anggaran;
use Carbon\Carbon;

class AnggaranSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $kategoris = Kategori::where('jenis', 'Pengeluaran')
                     ->where('is_auto', false)
                     ->get();
        $currentPeriode = Carbon::now()->format('Y-m');

        foreach ($users as $user) {
            foreach ($kategoris as $kategori) {

                // Random pilih periode: bulan ini atau bulan acak
                $periode = rand(0, 1) === 0
                    ? $currentPeriode
                    : Carbon::now()->subMonths(rand(1, 12))->format('Y-m'); // 12 bulan terakhir

                // Jika record sudah ada, skip atau update
                Anggaran::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'kategori_id' => $kategori->id_kategori,
                        'periode' => $periode,
                    ],
                    [
                        'jumlah_anggaran' => rand(1000000, 10000000),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }

        // Tambahan data acak ekstra, pastikan satu per satu
        for ($i = 0; $i < 20; $i++) {
            $user = User::inRandomOrder()->first();
            $kategori = $kategoris->random();
            $periode = Carbon::now()->subMonths(rand(0, 12))->format('Y-m');

            Anggaran::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'kategori_id' => $kategori->id_kategori,
                    'periode' => $periode,
                ],
                [
                    'jumlah_anggaran' => rand(1000000, 10000000),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
