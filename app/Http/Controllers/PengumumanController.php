<?php

namespace App\Http\Controllers;

use App\Models\Berita;

class PengumumanController extends Controller
{
    public function index()
    {
        // Semua pengumuman yang sudah dipublikasi & punya gambar
        $pengumuman = Berita::dipublikasi()
            ->whereNotNull('gambar')
            ->latest('id')
            ->get();

        return view('pengumuman.index', compact('pengumuman'));
    }

    public function show(Berita $berita)
    {
        $berita->increment('views'); // tambah penghitung dibaca
        return view('pengumuman.detail', compact('berita'));
    }
}
