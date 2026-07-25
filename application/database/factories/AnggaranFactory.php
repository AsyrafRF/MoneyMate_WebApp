<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Kategori;
use Carbon\Carbon;

class AnggaranFactory extends Factory
{
    public function definition(): array
    {
        $currentPeriode = Carbon::now()->format('Y-m');
        $periodeFaker = $this->faker->date('Y-m');
        $periode = rand(0, 1) === 0 ? $currentPeriode : $periodeFaker;

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'kategori_id' => Kategori::where('jenis', 'Pengeluaran')
                             ->where('is_auto', false)
                             ->inRandomOrder()
                             ->first()
                             ->id_kategori,
            'jumlah_anggaran' => $this->faker->numberBetween(1000000, 10000000),
            'periode' => $periode,
        ];
    }
}
