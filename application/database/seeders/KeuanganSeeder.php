<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Keuangan;

class KeuanganSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        // $data = [];

        // for ($i = 1; $i <= 15; $i++) {
        //     $data[] = [
        //         'user_id'    => 1,
        //         'jenis'      => $i % 2 == 0 ? 'Pemasukan' : 'Pengeluaran',
        //         'kategori'   => $i % 2 == 0 ? 'Gaji' : 'Makan & Minum',
        //         'jumlah'     => $i % 2 == 0 ? rand(1000000, 5000000) : rand(10000, 250000),
        //         'keterangan' => $i % 2 == 0 ? 'Pemasukan rutin' : 'Pengeluaran harian',
        //         'tanggal'    => Carbon::now()->subDays(rand(0, 30)),
        //         'bukti'      => 'bukti/dummy' . $i . '.jpg',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ];
        // }

        // DB::table('keuangans')->insert($data);

        // Buat 30 data dummy acak
        Keuangan::factory()->count(30)->create();
    }
}
