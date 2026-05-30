<?php

namespace Database\Seeders;

use App\Models\Pengaduan;
use Illuminate\Database\Seeder;

class PengaduanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'kode' => 'ADU-001', 'nama' => 'Ahmad Suharjo', 'telp' => '081234567890',
                'alamat' => 'Jl. Raya Dusun Tengah RT 01', 'id_pelanggan' => 'IBR-2024-001',
                'kategori' => 'Air Mati / Tidak Mengalir', 'status' => 'Selesai',
                'deskripsi' => 'Air di rumah saya tidak mengalir sejak kemarin pagi. Sudah saya cek meteran dan tidak ada masalah.',
                'balasan' => ['Tim kami telah melakukan pemeriksaan dan menemukan penyumbatan di pipa distribusi utama. Masalah sudah diperbaiki dan air sudah mengalir normal kembali.'],
            ],
            [
                'kode' => 'ADU-002', 'nama' => 'Siti Maryam', 'telp' => '081234567891',
                'alamat' => 'Jl. Raya Dusun Krajan RT 02', 'id_pelanggan' => 'IBR-2024-002',
                'kategori' => 'Kebocoran Pipa', 'status' => 'Ditanggapi',
                'deskripsi' => 'Ada kebocoran pipa besar di jalan depan rumah saya, air terbuang banyak. Lokasi: Jl. Raya Dusun Krajan RT 02.',
                'balasan' => ['Tim teknis akan melakukan perbaikan besok pagi sekitar jam 08:00. Mohon maaf atas ketidaknyamanannya.'],
            ],
            [
                'kode' => 'ADU-003', 'nama' => 'Dewi Lestari', 'telp' => '081234567894',
                'alamat' => 'Dusun Tengah', 'id_pelanggan' => 'IBR-2024-005',
                'kategori' => 'Kualitas Air Buruk', 'status' => 'Pending',
                'deskripsi' => 'Air yang keluar dari kran rumah saya keruh dan berbau tidak sedap sejak 3 hari terakhir.',
                'balasan' => [],
            ],
            [
                'kode' => 'ADU-004', 'nama' => 'Hadi Susanto', 'telp' => '081234567892',
                'alamat' => 'Dusun Pebukitan RT 03', 'id_pelanggan' => 'IBR-2024-003',
                'kategori' => 'Kebocoran Pipa', 'status' => 'Pending',
                'deskripsi' => 'Pipa bocor di RT 03, air mengalir ke jalan sejak pagi.',
                'balasan' => [],
            ],
            [
                'kode' => 'ADU-005', 'nama' => 'Ani Rahayu', 'telp' => '081200000045',
                'alamat' => '-', 'id_pelanggan' => 'IBR-2024-045',
                'kategori' => 'Kualitas Air Buruk', 'status' => 'Proses',
                'deskripsi' => 'Air keruh sejak pagi, mohon segera ditindaklanjuti.',
                'balasan' => [],
            ],
            [
                'kode' => 'ADU-006', 'nama' => 'Budi Santoso', 'telp' => '081200000078',
                'alamat' => '-', 'id_pelanggan' => 'IBR-2024-078',
                'kategori' => 'Meteran', 'status' => 'Selesai',
                'deskripsi' => 'Meteran air di rumah saya terbaca tidak akurat.',
                'balasan' => ['Sudah diperiksa dan diperbaiki oleh tim teknis.'],
            ],
        ];

        foreach ($data as $row) {
            $balasan = $row['balasan'];
            unset($row['balasan']);

            $pengaduan = Pengaduan::create($row);

            foreach ($balasan as $isi) {
                $pengaduan->balasans()->create(['isi' => $isi, 'oleh' => 'Admin BUMDes']);
            }
        }
    }
}
