<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tujuan;

class TujuanSeeder extends Seeder
{
    public function run(): void
    {
        // Generate 10 data tujuan
        Tujuan::factory()->count(10)->create();
    }
}
