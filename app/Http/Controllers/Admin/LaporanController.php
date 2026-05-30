<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;

class LaporanController extends Controller
{
    public function index()
    {
        // Ringkasan 6 bulan (data contoh statis untuk laporan keuangan)
        $ringkasan = [
            ['bulan' => 'Mei 2024', 'pendapatan' => 95_000_000,  'pengeluaran' => 15_000_000],
            ['bulan' => 'Jun 2024', 'pendapatan' => 110_000_000, 'pengeluaran' => 18_000_000],
            ['bulan' => 'Jul 2024', 'pendapatan' => 125_000_000, 'pengeluaran' => 20_000_000],
            ['bulan' => 'Agt 2024', 'pendapatan' => 105_000_000, 'pengeluaran' => 16_000_000],
            ['bulan' => 'Sep 2024', 'pendapatan' => 135_000_000, 'pengeluaran' => 22_000_000],
            ['bulan' => 'Okt 2024', 'pendapatan' => 142_000_000, 'pengeluaran' => 19_000_000],
        ];

        // Angka real dari database (pemasukan dari tagihan lunas)
        $pemasukanReal = Tagihan::where('status', 'Lunas')->sum('jumlah');
        $piutang       = Tagihan::where('status', '!=', 'Lunas')->sum('jumlah');

        return view('admin.laporan.index', compact('ringkasan', 'pemasukanReal', 'piutang'));
    }
}
