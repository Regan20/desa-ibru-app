<?php

namespace Database\Seeders;

use App\Models\Desa;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoAkunSeeder extends Seeder
{
    /**
     * Membuat SEMUA yang dibutuhkan untuk demo lima orang dalam satu seeder:
     *   - 1 desa (kalau belum ada)
     *   - 1 akun admin  -> admin.bumdes / admin123   (untuk verifikasi pembayaran)
     *   - 5 akun pengguna -> demo1 .. demo5 / demo12345
     *   - 5 pelanggan (No. Meter 101 .. 105), tiap pelanggan terhubung ke 1 akun
     *   - 5 tagihan "Belum Bayar", satu untuk tiap pelanggan
     *
     * Aman dijalankan berulang (idempotent) — sekaligus berfungsi sebagai RESET demo.
     */
    public function run(): void
    {
        // 1) Desa (dipakai untuk menghitung tarif air pelanggan).
        $desa = Desa::firstOrCreate(['nama' => 'Ibru'], ['tarif_per_m3' => 3000]);

        // 2) Akun admin — wajib ada supaya pembayaran bisa diverifikasi.
        User::updateOrCreate(
            ['username' => 'admin.bumdes'],
            [
                'name'     => 'Admin BUMDes',
                'role'     => 'admin',
                'email'    => 'admin@desaibru.id',
                'password' => Hash::make('admin123'),
            ]
        );

        // 3) Lima akun pengguna, masing-masing dengan pelanggan + tagihannya sendiri.
        for ($i = 1; $i <= 6; $i++) {
            $username = 'demo' . $i;                 // demo1 .. demo5
            $noMeter  = (string) (100 + $i);         // 101 .. 105 (dipakai di "Cek Tagihan")
            $kode     = 'IBR-2024-10' . $i;          // ID pelanggan internal

            $user = User::updateOrCreate(
                ['username' => $username],
                [
                    'name'     => 'Anggota ' . $i,
                    'role'     => 'user',
                    'email'    => $username . '@desaibru.id',
                    'password' => Hash::make('demo12345'),
                ]
            );

            $pelanggan = Pelanggan::updateOrCreate(
                ['kode' => $kode],
                [
                    'nama'      => 'Anggota ' . $i,
                    'desa_id'   => $desa->id,
                    'wilayah'   => 'Dusun Tengah',
                    'kategori'  => 'Rumah Tangga',
                    'hp'        => '08120000' . str_pad((string) $i, 4, '0', STR_PAD_LEFT),
                    'no_meter'  => $noMeter,
                    'email'     => $username . '@desaibru.id',
                    'pemakaian' => 20,
                    'status'    => 'Aktif',
                    'user_id'   => $user->id,
                ]
            );

            // RESET: hapus tagihan + pembayaran lama pelanggan ini.
            $idsTagihan = $pelanggan->tagihans()->pluck('id');
            Pembayaran::whereIn('tagihan_id', $idsTagihan)->delete();
            $pelanggan->tagihans()->delete();

            // Buat satu tagihan baru berstatus "Belum Bayar".
            Tagihan::create([
                'no_tagihan'    => 'TGH-DEMO-10' . $i,
                'pelanggan_id'  => $pelanggan->id,
                'periode'       => 'Juni 2026',
                'pemakaian'     => 20,
                'jumlah'        => 20 * $desa->tarif_per_m3,   // 20 m3 x 3000 = 60.000
                'jatuh_tempo'   => '20 Jun 2026',
                'status'        => 'Belum Bayar',
                'tanggal_bayar' => null,
            ]);
        }
    }
}
