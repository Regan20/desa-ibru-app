<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use App\Models\Tagihan;
use Illuminate\Database\Seeder;

class TagihanSeeder extends Seeder
{
    public function run(): void
    {
        // [no_tagihan, kode_pelanggan, pemakaian, status, tanggal_bayar]
        $data = [
            ['TGH-241001', 'IBR-2024-001', 24.5, 'Belum Bayar', null],
            ['TGH-241002', 'IBR-2024-002', 18.2, 'Lunas',       '15 Okt 2024'],
            ['TGH-241003', 'IBR-2024-003', 42.8, 'Terlambat',   null],
            ['TGH-241004', 'IBR-2024-004', 31.7, 'Lunas',       '18 Okt 2024'],
        ];

        foreach ($data as [$no, $kode, $m3, $status, $tglBayar]) {
            $pelanggan = Pelanggan::where('kode', $kode)->first();
            $jumlah    = (int) round($m3 * $pelanggan->tarif()); // pemakaian x tarif desa

            Tagihan::create([
                'no_tagihan'    => $no,
                'pelanggan_id'  => $pelanggan->id,
                'periode'       => 'Oktober 2024',
                'pemakaian'     => $m3,
                'jumlah'        => $jumlah,
                'jatuh_tempo'   => '20 Okt 2024',
                'status'        => $status,
                'tanggal_bayar' => $tglBayar,
            ]);
        }
    }
}
