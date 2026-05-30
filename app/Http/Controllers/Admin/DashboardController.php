<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Pengaduan;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class DashboardController extends Controller
{
    public function index()
    {
        $kpi = [
            'total_pelanggan' => Pelanggan::count(),
            'pemasukan'       => Tagihan::where('status', 'Lunas')->sum('jumlah'),
            'belum_bayar'     => Tagihan::where('status', 'Belum Bayar')->count(),
            'outstanding'     => Tagihan::where('status', '!=', 'Lunas')->sum('jumlah'),
            'pengaduan_aktif' => Pengaduan::whereIn('status', ['Pending', 'Proses'])->count(),
            'lunas'           => Tagihan::where('status', 'Lunas')->count(),
            'terlambat'       => Tagihan::where('status', 'Terlambat')->count(),
        ];

        return view('admin.dashboard', compact('kpi'));
    }

    public function pengaturan()
    {
        $admin = Auth::user();
        return view('admin.pengaturan.index', compact('admin'));
    }

    /** Ubah kata sandi admin yang sedang login (menu Pengaturan > Keamanan). */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
            'password.min'       => 'Kata sandi baru minimal 6 karakter.',
        ]);

        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini salah.']);
        }

        // Model User memakai cast 'hashed', jadi cukup berikan nilai mentahnya.
        $user->update(['password' => $request->password]);

        return back()->with('success', 'Kata sandi berhasil diperbarui.');
    }
}
