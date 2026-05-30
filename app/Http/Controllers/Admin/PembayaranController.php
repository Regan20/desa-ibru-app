<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayarans = Pembayaran::with('pelanggan', 'tagihan')
            ->where('status', 'Menunggu')
            ->latest('id')
            ->get();

        return view('admin.verifikasi.index', compact('pembayarans'));
    }

    public function verifikasi(Request $request, Pembayaran $pembayaran)
    {
        $data = $request->validate([
            'aksi' => ['required', 'in:terima,tolak'],
        ]);

        if ($data['aksi'] === 'terima') {
            $pembayaran->status = 'Diverifikasi';
            // tandai tagihan terkait jadi Lunas
            if ($pembayaran->tagihan) {
                $pembayaran->tagihan->update([
                    'status'        => 'Lunas',
                    'tanggal_bayar' => now()->translatedFormat('d M Y'),
                ]);
            }
            $pesan = 'Pembayaran diverifikasi.';
        } else {
            $pembayaran->status = 'Ditolak';
            $pesan = 'Pembayaran ditolak.';
        }

        $pembayaran->save();

        return back()->with('success', $pesan);
    }
}
