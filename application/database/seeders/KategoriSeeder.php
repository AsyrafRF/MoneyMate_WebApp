<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Pemasukan
            ['nama_kategori' => 'Lainnya', 'jenis' => 'Pemasukan'],

            // Pengeluaran
            ['nama_kategori' => 'Lain-lain', 'jenis' => 'Pengeluaran'],
        ];

        foreach ($data as $item) {
            Kategori::firstOrCreate(
                [
                    'nama_kategori' => $item['nama_kategori'],
                    'user_id' => null, // hanya cari kategori umum
                ],
                [
                    'jenis' => $item['jenis'],
                ]
            );
        }
        // 🔥 Tambahkan kategori acak
        // Kategori::factory(10)->create();
    }
}
