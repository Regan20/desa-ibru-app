<?php

namespace Database\Seeders;

use App\Models\Berita;
use Illuminate\Database\Seeder;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        // ===== PENGUMUMAN (tampil di sisi pengguna, sudah dipublikasi, punya gambar) =====
        $pengumuman = [
            [
                'judul'    => 'Pemeliharaan Pipa Distribusi Dusun Krajan',
                'kategori' => 'Pemeliharaan', 'badge' => 'badge-red', 'sub' => 'Pembayaran & Denda',
                'tanggal'  => 'Sabtu, 23 Oktober 2024', 'gambar' => 'assets/ann-pemeliharaan.jpg',
                'status'   => 'Dipublikasi', 'views' => 312,
                'isi'      => 'Akan mengadakan kegiatan pembersihan pipa distribusi air untuk meningkatkan kualitas air. Kegiatan ini akan dilaksanakan pada hari Kamis, 25 Oktober 2024. Selama kegiatan berlangsung, pasokan air akan dihentikan sementara dari pukul 08:00 hingga 16:00. Warga dimohon untuk menyiapkan cadangan air yang cukup sebelum kegiatan dimulai. Mohon maaf atas ketidaknyamanan yang ditimbulkan.',
            ],
            [
                'judul'    => 'Pemberitahuan Pinjaman Baru Untuk Blok A',
                'kategori' => 'Info', 'badge' => 'badge-blue', 'sub' => 'Jadwal Perbaikan',
                'tanggal'  => 'Rabu, 20 Oktober 2024', 'gambar' => 'assets/ann-pinjaman.jpeg',
                'status'   => 'Dipublikasi', 'views' => 187,
                'isi'      => 'Akan dilakukan penggantian pipa lama di wilayah RT 3. Mohon pengertian warga untuk sementara menyiapkan cadangan air. Pipa baru yang akan dipasang memiliki kapasitas yang lebih besar dan kualitas yang lebih baik untuk mendukung kebutuhan warga jangka panjang. Pengerjaan diperkirakan berlangsung selama 2 hari.',
            ],
            [
                'judul'    => 'Perlanjutan Jadwal Baru Ke Wilayah Pabejalan',
                'kategori' => 'Penting', 'badge' => 'badge-orange', 'sub' => 'Informasi Gangguan',
                'tanggal'  => 'Sabtu, 15 Oktober 2024', 'gambar' => 'assets/ann-perluasan.png',
                'status'   => 'Dipublikasi', 'views' => 240,
                'isi'      => 'Perluasan jaringan pipa air bersih ke wilayah baru untuk meningkatkan jangkauan layanan ke seluruh warga desa. Wilayah Pabejalan akan segera mendapat akses layanan air bersih yang telah lama dinantikan. Proses pendaftaran pelanggan baru di wilayah ini akan dibuka mulai 1 November 2024.',
            ],
            [
                'judul'    => 'Pembayaran Atas Kru Biru Lamat Wilayah Desa',
                'kategori' => 'Info', 'badge' => 'badge-blue', 'sub' => 'Kegiatan Rutin',
                'tanggal'  => 'Senin, 10 Oktober 2024', 'gambar' => 'assets/ann-pembayaran.jpg',
                'status'   => 'Dipublikasi', 'views' => 156,
                'isi'      => 'Info terkait pembayaran dan pendistribusian untuk wilayah desa yang telah terdaftar dalam sistem. Semua warga yang terdaftar akan mendapat notifikasi pembayaran setiap awal bulan. Pembayaran dapat dilakukan secara langsung di kantor desa atau melalui transfer bank.',
            ],
        ];

        // ===== BERITA tambahan (dikelola admin) =====
        $berita = [
            ['judul' => 'Peningkatan Instalasi Air Desa', 'kategori' => 'Info',        'badge' => 'badge-blue', 'sub' => null, 'tanggal' => '25 Okt 2024', 'gambar' => 'assets/news-instalasi.png', 'status' => 'Dipublikasi', 'views' => 245, 'isi' => 'Peningkatan instalasi air di seluruh desa untuk meningkatkan kualitas layanan.'],
            ['judul' => 'Sosialisasi Hemat Air',          'kategori' => 'Info',        'badge' => 'badge-blue', 'sub' => null, 'tanggal' => '15 Okt 2024', 'gambar' => 'assets/news-hemat.jpg',     'status' => 'Draft',       'views' => 0,   'isi' => 'Tips dan cara hemat air untuk warga desa.'],
            ['judul' => 'Tips Hemat Air Untuk Musim Kemarau', 'kategori' => 'Kegiatan', 'badge' => 'badge-blue', 'sub' => null, 'tanggal' => '02 Okt 2024', 'gambar' => 'assets/news-tips.jpeg',    'status' => 'Draft',       'views' => 0,   'isi' => 'Ikuti tips hemat air untuk musim kemarau yang akan datang.'],
        ];

        foreach (array_merge($pengumuman, $berita) as $row) {
            Berita::create($row);
        }
    }
}
