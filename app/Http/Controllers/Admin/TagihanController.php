<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Tagihan;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    public function index()
    {
        $tagihans = Tagihan::with('pelanggan')->latest('id')->get();
        $pelanggans = Pelanggan::with('desa')->get();

        $stat = [
            'total'     => Tagihan::count(),
            'lunas'     => Tagihan::where('status', 'Lunas')->count(),
            'belum'     => Tagihan::where('status', 'Belum Bayar')->count(),
            'terlambat' => Tagihan::where('status', 'Terlambat')->count(),
        ];

        return view('admin.tagihan.index', compact('tagihans', 'pelanggans', 'stat'));
    }

    /** Tagihan manual untuk satu pelanggan. */
    public function store(Request $request)
    {
        $data = $request->validate([
            'pelanggan_id' => ['required', 'exists:pelanggans,id'],
            'pemakaian'    => ['required', 'numeric', 'min:0'],
            'jatuh_tempo'  => ['required', 'string', 'max:50'],
        ]);

        $pelanggan = Pelanggan::findOrFail($data['pelanggan_id']);

        Tagihan::create([
            'no_tagihan'   => 'TGH-MNL-' . substr((string) time(), -5),
            'pelanggan_id' => $pelanggan->id,
            'periode'      => 'Manual',
            'pemakaian'    => $data['pemakaian'],
            'jumlah'       => (int) round($data['pemakaian'] * $pelanggan->tarif()),
            'jatuh_tempo'  => $data['jatuh_tempo'],
            'status'       => 'Belum Bayar',
        ]);

        return back()->with('success', 'Tagihan manual ditambahkan.');
    }

    /** Generate tagihan massal untuk semua pelanggan aktif. */
    public function generate(Request $request)
    {
        $data = $request->validate([
            'periode' => ['required', 'string'],
        ]);

        $pelanggans = Pelanggan::where('status', '!=', 'Nonaktif')->get();

        foreach ($pelanggans as $p) {
            $m3 = round((mt_rand(100, 350) / 10), 1); // 10.0 - 35.0 m3
            Tagihan::create([
                'no_tagihan'   => 'TGH-' . substr((string) (time() + $p->id), -6),
                'pelanggan_id' => $p->id,
                'periode'      => $data['periode'],
                'pemakaian'    => $m3,
                'jumlah'       => (int) round($m3 * $p->tarif()),
                'jatuh_tempo'  => '20 ' . $data['periode'],
                'status'       => 'Belum Bayar',
            ]);
        }

        return back()->with('success', "Tagihan untuk {$data['periode']} digenerate ({$pelanggans->count()} tagihan).");
    }

    public function updateStatus(Request $request, Tagihan $tagihan)
    {
        $data = $request->validate([
            'status' => ['required', 'in:Belum Bayar,Lunas,Terlambat'],
        ]);

        $tagihan->status = $data['status'];
        if ($data['status'] === 'Lunas' && ! $tagihan->tanggal_bayar) {
            $tagihan->tanggal_bayar = now()->translatedFormat('d M Y');
        }
        $tagihan->save();

        return back()->with('success', 'Status tagihan diperbarui: ' . $data['status']);
    }
}
