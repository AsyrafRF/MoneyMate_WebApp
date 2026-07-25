<?php

namespace Database\Seeders;

use App\Models\RedeemCode;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Opsional, jika ingin truncate
use Carbon\Carbon;

class RedeemCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Opsional: Kosongkan tabel dulu sebelum mengisi (hati-hati di production)
        // DB::table('redeem_codes')->truncate();

        $codes = [
            [
                'code' => 'EXPIRED123',
                'duration_days' => 30,
                'max_uses' => 100,
                'expires_at' => Carbon::now()->subDays(1), // Sudah kadaluarsa (kemarin)
                'is_active' => true, 
                'description' => 'Kode tes yang sudah kadaluarsa.',
            ],
            [
                'code' => 'INACTIVE001',
                'duration_days' => 10,
                'max_uses' => 100,
                'expires_at' => Carbon::now()->addDays(10),
                'is_active' => false, // Non-aktif manual
                'description' => 'Kode yang dimatikan oleh admin.',
            ],
        ];

        foreach ($codes as $data) {
            // Menggunakan firstOrCreate agar tidak error jika seeder dijalankan 2x
            RedeemCode::firstOrCreate(
                ['code' => $data['code']], // Cari berdasarkan kode
                $data // Isi data jika belum ada
            );
        }
    }
}
