<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function index()
    {
        $pengaduans = Pengaduan::with('balasans')->latest('id')->get();

        $stat = [
            'total'    => Pengaduan::count(),
            'menunggu' => Pengaduan::whereIn('status', ['Pending', 'Proses'])->count(),
            'selesai'  => Pengaduan::where('status', 'Selesai')->count(),
        ];

        return view('admin.pengaduan.index', compact('pengaduans', 'stat'));
    }

    public function balas(Request $request, Pengaduan $pengaduan)
    {
        $data = $request->validate([
            'isi' => ['required', 'string'],
        ]);

        $pengaduan->balasans()->create([
            'isi'  => $data['isi'],
            'oleh' => 'Admin BUMDes',
        ]);

        if ($pengaduan->status === 'Pending') {
            $pengaduan->update(['status' => 'Ditanggapi']);
        }

        return back()->with('success', 'Balasan terkirim.');
    }

    public function updateStatus(Request $request, Pengaduan $pengaduan)
    {
        $data = $request->validate([
            'status' => ['required', 'in:Pending,Proses,Ditanggapi,Selesai'],
        ]);

        $pengaduan->update(['status' => $data['status']]);

        return back()->with('success', 'Status pengaduan: ' . $data['status']);
    }
}
