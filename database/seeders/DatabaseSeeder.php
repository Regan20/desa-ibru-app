<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            DesaSeeder::class,
            UserSeeder::class,
            PelangganSeeder::class,
            TagihanSeeder::class,
            BeritaSeeder::class,
            PengaduanSeeder::class,
        ]);
    }
}
