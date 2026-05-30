<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pelanggan = $user->pelanggan; // data pelanggan milik user yang login (bisa null)

        // tagihan terakhir yang belum dibayar (kalau ada)
        $tagihan = $pelanggan
            ? $pelanggan->tagihans()->latest('id')->first()
            : null;

        $berita = Berita::dipublikasi()->latest('id')->take(3)->get();

        return view('dashboard', compact('user', 'pelanggan', 'tagihan', 'berita'));
    }
}
