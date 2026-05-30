<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function index()
    {
        // Riwayat pengaduan terbaru (ditampilkan di bawah formulir)
        $riwayat = Pengaduan::with('balasans')->latest('id')->take(5)->get();

        return view('pengaduan.index', compact('riwayat'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'      => ['required', 'string', 'max:255'],
            'telp'      => ['required', 'string', 'max:20'],
            'alamat'    => ['nullable', 'string', 'max:255'],
            'kategori'  => ['required', 'string'],
            'deskripsi' => ['required', 'string'],
        ]);

        $data['kode']   = 'ADU-' . str_pad((string) (Pengaduan::count() + 1), 3, '0', STR_PAD_LEFT);
        $data['status'] = 'Pending';

        Pengaduan::create($data);

        return redirect()->route('pengaduan.index')
            ->with('success', 'Pengaduan berhasil dikirim! Tim akan menindaklanjuti dalam 24 jam.');
    }
}
