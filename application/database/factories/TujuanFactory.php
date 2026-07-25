<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class TujuanFactory extends Factory
{
    public function definition(): array
    {
        $target = $this->faker->randomElement([
            1000000, 2000000, 5000000, 7000000, 
            10000000, 15000000, 20000000, 
            $this->faker->numberBetween(5_000_000, 50_000_000)
        ]);

        $current = $this->faker->numberBetween(0, $target);

        $tujuanList = [
            'Beli Laptop Baru',
            'Liburan ke Jepang',
            'Tabungan Darurat',
            'Renovasi Rumah',
            'Beli HP Baru',
            'Biaya Pendidikan',
            'Modal Bisnis',
            'Beli Mobil',
            'Beli Motor Baru',
            'Pernikahan',
            'Investasi Properti',
            'Upgrade PC Gaming',
            'Bangun Rumah',
            'Beli Kamera DSLR',
            'Liburan Eropa',
            'Naik Haji',
            'Dana Kesehatan Orang Tua',
            'Ganti Furniture Rumah',
            'Beli Smart TV',
            'Pindah Rumah'
        ];

        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'nama_tujuan' => $this->faker->randomElement($tujuanList),
            'target_nominal' => $target,
            'nominal_saat_ini' => $current,
            'progress' => intval(($current / $target) * 100),
            'deadline' => $this->faker->dateTimeBetween('+1 month', '+3 years')->format('Y-m-d'),
        ];
    }
}
