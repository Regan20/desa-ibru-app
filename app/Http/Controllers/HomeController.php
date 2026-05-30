<?php

namespace App\Http\Controllers;

use App\Models\Berita;

class HomeController extends Controller
{
    public function index()
    {
        // 3 berita terbaru yang sudah dipublikasi untuk bagian "Berita Desa & Pengumuman"
        $berita = Berita::dipublikasi()->latest('id')->take(3)->get();

        return view('home', compact('berita'));
    }
}
