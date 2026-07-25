<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
use App\Models\Kategori;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Keuangan>
 */
class KeuanganFactory extends Factory
{
    public function definition(): array
    {
        $faker = $this->faker ?? \Faker\Factory::create('id_ID');

        // Ambil kategori secara acak dari tabel kategoris
        $kategoriModel = Kategori::inRandomOrder()->first();

        // Jika belum ada kategori, buat dummy dulu untuk menghindari error
        if (!$kategoriModel) {
            $kategoriModel = Kategori::create([
                'nama_kategori' => 'Default',
                'jenis' => $faker->randomElement(['Pemasukan', 'Pengeluaran']),
                'user_id' => User::inRandomOrder()->value('id'),
            ]);
        }

        // Jenis mengikuti dari kategori
        $jenis = $kategoriModel->jenis;

        // Tentukan keterangan realistis berdasarkan kategori
        $keterangan = match ($kategoriModel->nama_kategori) {
            // Pemasukan
            'Gaji' => 'Gaji bulanan dari perusahaan tempat bekerja',
            'Bonus' => 'Bonus kinerja bulan ini dari kantor',
            'Investasi' => 'Pendapatan dari hasil investasi reksa dana',
            'Hadiah' => 'Mendapat hadiah dari undian belanja online',

            // Pengeluaran
            'Makan & Minum' => $faker->randomElement([
                'Makan siang di warung dekat kantor',
                'Ngopi di kafe favorit',
                'Beli makan malam bersama keluarga',
            ]),
            'Transportasi' => $faker->randomElement([
                'Naik ojek online ke kantor',
                'Isi bensin motor',
                'Bayar parkir di mall',
            ]),
            'Belanja' => $faker->randomElement([
                'Belanja kebutuhan rumah tangga di supermarket',
                'Beli pakaian baru di toko online',
                'Beli alat tulis di minimarket',
            ]),
            'Tempat Tinggal' => $faker->randomElement([
                'Bayar tagihan listrik bulanan',
                'Bayar tagihan air PDAM',
                'Bayar tagihan internet rumah',
            ]),
            'Hiburan' => $faker->randomElement([
                'Nonton film di bioskop',
                'Langganan Netflix bulanan',
                'Main game online berbayar',
            ]),

            default => 'Transaksi keuangan rutin',
        };

        return [
            'user_id'    => User::inRandomOrder()->value('id'),
            'jenis'      => $jenis,
            'kategori_id'=> $kategoriModel->id_kategori,
            'jumlah'     => $jenis === 'Pemasukan'
                ? $faker->numberBetween(500, 5000)
                : $faker->numberBetween(1000, 10000),
            'keterangan' => $keterangan,
            'tanggal'    => Carbon::now()->subDays(rand(0, 30)),
            'bukti'      => 'bukti/dummy' . rand(1, 5) . '.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
