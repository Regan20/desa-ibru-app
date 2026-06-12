<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt(['username' => $data['username'], 'password' => $data['password']])) {
            $request->session()->regenerate();

            // Admin diarahkan ke panel admin, pengguna ke dashboard
            return Auth::user()->role === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect()->route('dashboard');
        }

        return back()
            ->withErrors(['username' => 'Username atau kata sandi salah. Coba kredensial demo.'])
            ->withInput($request->only('username'));
    }

    public function showRegister()
    {
        $desas = Desa::all();
        return view('auth.register', compact('desas'));
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nama'     => ['required', 'string', 'max:255'],
            'no_meter' => ['required', 'string', 'max:50'],
            'desa'     => ['required', 'string'],
            'hp'       => ['required', 'string', 'max:20'],
            'email'    => ['nullable', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $desa = Desa::where('nama', $data['desa'])->firstOrFail();

        // Username = no. meter. Kolom ini UNIQUE di tabel users, jadi kalau
        // nomor meter sudah dipakai (sering terjadi saat banyak penguji
        // mengetik contoh "12345678" yang sama) tambahkan akhiran kecil
        // agar pendaftaran tidak gagal dengan error 500.
        $username = $data['no_meter'];
        while (User::where('username', $username)->exists()) {
            $username = $data['no_meter'] . '-' . substr(uniqid(), -4);
        }

        // Email juga UNIQUE di tabel users. Kalau bentrok, kosongkan saja.
        $email = $data['email'] ?? null;
        if ($email && User::where('email', $email)->exists()) {
            $email = null;
        }

        // Buat akun login (username pakai no. meter / id pelanggan)
        $user = User::create([
            'name'     => $data['nama'],
            'username' => $username,
            'role'     => 'user',
            'email'    => $email,
            'password' => Hash::make($data['password']),
        ]);

        // Buat data pelanggan terhubung ke akun
        Pelanggan::create([
            'kode'      => 'IBR-' . date('Y') . '-' . str_pad((string) (Pelanggan::count() + 1), 3, '0', STR_PAD_LEFT),
            'nama'      => $data['nama'],
            'desa_id'   => $desa->id,
            'wilayah'   => '-',
            'kategori'  => 'Rumah Tangga',
            'hp'        => $data['hp'],
            'no_meter'  => $data['no_meter'],
            'email'     => $data['email'] ?? null,
            'pemakaian' => 0,
            'status'    => 'Aktif',
            'user_id'   => $user->id,
        ]);

        return redirect()->route('login')
            ->with('success', 'Pendaftaran berhasil! Silakan masuk dengan akun Anda.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
