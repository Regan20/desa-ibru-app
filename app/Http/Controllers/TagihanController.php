<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    /** Halaman form cek tagihan. */
    public function cek()
    {
        return view('tagihan.cek', ['tagihan' => null, 'pelanggan' => null]);
    }

    /** Cari tagihan berdasarkan No. Meter / ID Pelanggan. */
    public function cari(Request $request)
    {
        $data = $request->validate([
            'meter' => ['required', 'string'],
        ]);

        // Cari pelanggan berdasarkan kode (ID Pelanggan) atau no_meter
        $pelanggan = Pelanggan::where('kode', $data['meter'])
            ->orWhere('no_meter', $data['meter'])
            ->first();

        if (! $pelanggan) {
            return back()->withErrors(['meter' => 'Pelanggan tidak ditemukan. Coba ID: IBR-2024-001'])
                ->withInput();
        }

        $tagihan = $pelanggan->tagihans()->latest('id')->first();

        if (! $tagihan) {
            return back()->withErrors(['meter' => 'Belum ada tagihan untuk pelanggan ini.'])
                ->withInput();
        }

        return view('tagihan.cek', compact('tagihan', 'pelanggan'));
    }

    /** Halaman pembayaran sebuah tagihan. */
    public function pembayaran(Tagihan $tagihan)
    {
        $tagihan->load('pelanggan.desa');
        return view('tagihan.pembayaran', compact('tagihan'));
    }

    /** Simulasi bayar -> buat record pembayaran berstatus "Menunggu" verifikasi admin. */
    public function bayar(Request $request, Tagihan $tagihan)
    {
        $data = $request->validate([
            'metode' => ['required', 'string'],
        ]);

        Pembayaran::create([
            'pelanggan_id' => $tagihan->pelanggan_id,
            'tagihan_id'   => $tagihan->id,
            'jumlah'       => $tagihan->jumlah,
            'metode'       => $data['metode'],
            'status'       => 'Menunggu',
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Pembayaran berhasil! Menunggu verifikasi admin.');
    }
}
