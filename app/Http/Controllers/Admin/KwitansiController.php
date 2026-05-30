<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use Illuminate\Http\Request;

class KwitansiController extends Controller
{
    /** Daftar SEMUA tagihan (sudah bayar maupun belum) untuk dicetak manual. */
    public function index(Request $request)
    {
        $status = $request->query('status'); // null | Lunas | Belum Bayar | Terlambat

        $query = Tagihan::with('pelanggan.desa')->latest('id');
        if (in_array($status, ['Lunas', 'Belum Bayar', 'Terlambat'])) {
            $query->where('status', $status);
        }
        $tagihans = $query->get();

        $stat = [
            'total'     => Tagihan::count(),
            'lunas'     => Tagihan::where('status', 'Lunas')->count(),
            'belum'     => Tagihan::where('status', 'Belum Bayar')->count(),
            'terlambat' => Tagihan::where('status', 'Terlambat')->count(),
        ];

        return view('admin.kwitansi.index', compact('tagihans', 'stat', 'status'));
    }

    /** Halaman kwitansi siap cetak untuk satu tagihan. */
    public function cetak(Tagihan $tagihan)
    {
        $tagihan->load('pelanggan.desa');
        $terbilang = $this->terbilang((int) $tagihan->jumlah) . ' rupiah';

        return view('admin.kwitansi.cetak', compact('tagihan', 'terbilang'));
    }

    /** Ubah angka menjadi kata (Bahasa Indonesia) untuk kwitansi. */
    private function terbilang(int $n): string
    {
        $n = abs($n);
        $huruf = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];

        if ($n < 12) {
            $hasil = $huruf[$n];
        } elseif ($n < 20) {
            $hasil = $this->terbilang($n - 10) . ' belas';
        } elseif ($n < 100) {
            $hasil = $this->terbilang(intdiv($n, 10)) . ' puluh ' . $this->terbilang($n % 10);
        } elseif ($n < 200) {
            $hasil = 'seratus ' . $this->terbilang($n - 100);
        } elseif ($n < 1000) {
            $hasil = $this->terbilang(intdiv($n, 100)) . ' ratus ' . $this->terbilang($n % 100);
        } elseif ($n < 2000) {
            $hasil = 'seribu ' . $this->terbilang($n - 1000);
        } elseif ($n < 1000000) {
            $hasil = $this->terbilang(intdiv($n, 1000)) . ' ribu ' . $this->terbilang($n % 1000);
        } elseif ($n < 1000000000) {
            $hasil = $this->terbilang(intdiv($n, 1000000)) . ' juta ' . $this->terbilang($n % 1000000);
        } else {
            $hasil = $this->terbilang(intdiv($n, 1000000000)) . ' miliar ' . $this->terbilang($n % 1000000000);
        }

        return trim(preg_replace('/\s+/', ' ', $hasil));
    }
}
