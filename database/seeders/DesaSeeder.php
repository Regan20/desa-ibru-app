<?php

namespace Database\Seeders;

use App\Models\Desa;
use Illuminate\Database\Seeder;

class DesaSeeder extends Seeder
{
    public function run(): void
    {
        Desa::insert([
            ['nama' => 'Ibru',     'tarif_per_m3' => 3000, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Sukamaju', 'tarif_per_m3' => 4500, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
