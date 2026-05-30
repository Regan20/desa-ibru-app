<?php

namespace Database\Seeders;

use App\Models\Desa;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    public function run(): void
    {
        $ibru     = Desa::where('nama', 'Ibru')->first();
        $sukamaju = Desa::where('nama', 'Sukamaju')->first();
        $arman    = User::where('username', 'user123')->first();

        $data = [
            ['kode' => 'IBR-2024-001', 'nama' => 'Ahmad Suharjo', 'desa_id' => $ibru->id,     'wilayah' => 'Dusun Tengah',    'kategori' => 'Rumah Tangga', 'hp' => '081234567890', 'pemakaian' => 24.5, 'status' => 'Aktif',     'user_id' => $arman->id],
            ['kode' => 'IBR-2024-002', 'nama' => 'Siti Maryam',   'desa_id' => $sukamaju->id, 'wilayah' => 'Dusun Krajan',    'kategori' => 'Rumah Tangga', 'hp' => '081234567891', 'pemakaian' => 18.2, 'status' => 'Aktif',     'user_id' => null],
            ['kode' => 'IBR-2024-003', 'nama' => 'Hadi Susanto',  'desa_id' => $ibru->id,     'wilayah' => 'Dusun Pebukitan', 'kategori' => 'Usaha Kecil',  'hp' => '081234567892', 'pemakaian' => 42.8, 'status' => 'Tunggakan', 'user_id' => null],
            ['kode' => 'IBR-2024-004', 'nama' => 'Rizky Pratama', 'desa_id' => $ibru->id,     'wilayah' => 'Dusun Tengah',    'kategori' => 'Rumah Tangga', 'hp' => '081234567893', 'pemakaian' => 31.7, 'status' => 'Aktif',     'user_id' => null],
            ['kode' => 'IBR-2024-005', 'nama' => 'Dewi Lestari',  'desa_id' => $sukamaju->id, 'wilayah' => 'Dusun Tengah',    'kategori' => 'Rumah Tangga', 'hp' => '081234567894', 'pemakaian' => 15.3, 'status' => 'Aktif',     'user_id' => null],
        ];

        foreach ($data as $row) {
            Pelanggan::create($row);
        }
    }
}
