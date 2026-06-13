<?php

namespace Database\Seeders;

use App\Models\Desa;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Database\Seeder;

class DemoBayarSeeder extends Seeder
{
    /**
     * Menyiapkan 5 tagihan "Belum Bayar" untuk pelanggan
     * IBR-2024-002 s/d IBR-2024-006 — satu ID untuk tiap anggota,
     * supaya 5 orang bisa demo bayar sendiri-sendiri tanpa bentrok.
     *
     * IBR-2024-001 sengaja DILEWATI (dibiarkan apa adanya).
     * IBR-2024-006 dibuat otomatis kalau belum ada.
     *
     * Aman dijalankan ulang: tiap kali jalan, tagihan demo lama
     * (TGH-DEMO-xxx) + pembayarannya dihapus lalu dibuat fresh.
     * Jadi seeder ini sekaligus berfungsi sebagai tombol RESET demo.
     */
    public function run(): void
    {
        $periode    = 'Juni 2026';
        $jatuhTempo = '20 Jun 2026';

        // Desa untuk pelanggan yang perlu dibuat baru (mis. 006).
        $desa = Desa::where('nama', 'Ibru')->first() ?? Desa::first();

        // kode => data default (DIPAKAI HANYA kalau pelanggan belum ada)
        $pelangganDemo = [
            'IBR-2024-002' => ['nama' => 'Siti Maryam',   'pemakaian' => 18.2],
            'IBR-2024-003' => ['nama' => 'Hadi Susanto',  'pemakaian' => 42.8],
            'IBR-2024-004' => ['nama' => 'Rizky Pratama', 'pemakaian' => 31.7],
            'IBR-2024-005' => ['nama' => 'Dewi Lestari',  'pemakaian' => 15.3],
            'IBR-2024-006' => ['nama' => 'Budi Hartono',  'pemakaian' => 22.0],
        ];

        foreach ($pelangganDemo as $kode => $info) {
            // Pakai pelanggan yang sudah ada, atau buat baru (untuk 006).
            $pelanggan = Pelanggan::firstOrCreate(
                ['kode' => $kode],
                [
                    'nama'      => $info['nama'],
                    'desa_id'   => $desa?->id,
                    'wilayah'   => 'Dusun Tengah',
                    'kategori'  => 'Rumah Tangga',
                    'hp'        => '0812000000' . substr($kode, -2),
                    'pemakaian' => $info['pemakaian'],
                    'status'    => 'Aktif',
                ]
            );

            // Nomor tagihan mengikuti suffix ID: TGH-DEMO-002 .. TGH-DEMO-006
            $noTagihan = 'TGH-DEMO-' . substr($kode, -3);

            // RESET: hapus tagihan demo lama + pembayaran terkait.
            $lama = Tagihan::where('no_tagihan', $noTagihan)->first();
            if ($lama) {
                Pembayaran::where('tagihan_id', $lama->id)->delete();
                $lama->delete();
            }

            $pemakaian = (float) ($pelanggan->pemakaian ?: $info['pemakaian']);
            $jumlah    = (int) round($pemakaian * $pelanggan->tarif());

            Tagihan::create([
                'no_tagihan'    => $noTagihan,
                'pelanggan_id'  => $pelanggan->id,
                'periode'       => $periode,
                'pemakaian'     => $pemakaian,
                'jumlah'        => $jumlah,
                'jatuh_tempo'   => $jatuhTempo,
                'status'        => 'Belum Bayar',
                'tanggal_bayar' => null,
            ]);
        }
    }
}
