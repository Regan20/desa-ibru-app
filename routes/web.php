<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\TagihanController as AdminTagihan;
use App\Http\Controllers\Admin\PembayaranController;
use App\Http\Controllers\Admin\PengaduanController as AdminPengaduan;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\KwitansiController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/cek-tagihan',  [TagihanController::class, 'cek'])->name('tagihan.cek');
    Route::post('/cek-tagihan', [TagihanController::class, 'cari'])->name('tagihan.cari');
    Route::get('/pembayaran/{tagihan}', [TagihanController::class, 'pembayaran'])->name('tagihan.pembayaran');
    Route::post('/pembayaran/{tagihan}', [TagihanController::class, 'bayar'])->name('tagihan.bayar');

    Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
    Route::get('/pengumuman/{berita}', [PengumumanController::class, 'show'])->name('pengumuman.show');

    Route::get('/pengaduan',  [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminDashboard::class, 'index'])->name('dashboard');

    Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
    Route::post('/pelanggan', [PelangganController::class, 'store'])->name('pelanggan.store');
    Route::put('/pelanggan/{pelanggan}', [PelangganController::class, 'update'])->name('pelanggan.update');
    Route::delete('/pelanggan/{pelanggan}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');

    Route::get('/tagihan', [AdminTagihan::class, 'index'])->name('tagihan.index');
    Route::post('/tagihan', [AdminTagihan::class, 'store'])->name('tagihan.store');
    Route::post('/tagihan/generate', [AdminTagihan::class, 'generate'])->name('tagihan.generate');
    Route::put('/tagihan/{tagihan}/status', [AdminTagihan::class, 'updateStatus'])->name('tagihan.status');

    Route::get('/kwitansi', [KwitansiController::class, 'index'])->name('kwitansi.index');
    Route::get('/kwitansi/{tagihan}/cetak', [KwitansiController::class, 'cetak'])->name('kwitansi.cetak');

    Route::get('/verifikasi', [PembayaranController::class, 'index'])->name('verifikasi.index');
    Route::put('/verifikasi/{pembayaran}', [PembayaranController::class, 'verifikasi'])->name('verifikasi.update');

    Route::get('/pengaduan', [AdminPengaduan::class, 'index'])->name('pengaduan.index');
    Route::post('/pengaduan/{pengaduan}/balas', [AdminPengaduan::class, 'balas'])->name('pengaduan.balas');
    Route::put('/pengaduan/{pengaduan}/status', [AdminPengaduan::class, 'updateStatus'])->name('pengaduan.status');

    Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
    Route::post('/berita', [BeritaController::class, 'store'])->name('berita.store');
    Route::put('/berita/{berita}', [BeritaController::class, 'update'])->name('berita.update');
    Route::delete('/berita/{berita}', [BeritaController::class, 'destroy'])->name('berita.destroy');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/pengaturan', [AdminDashboard::class, 'pengaturan'])->name('pengaturan');
    Route::put('/pengaturan/password', [AdminDashboard::class, 'updatePassword'])->name('pengaturan.password');
});

Route::get('/buat-akun-demo', function () {
    \Illuminate\Support\Facades\Artisan::call('db:seed', [
        '--class' => \Database\Seeders\DemoAkunSeeder::class,
        '--force' => true,
    ]);
    return 'Lima akun demo + admin siap. demo1..demo5 (password: demo12345), admin.bumdes/admin123. Hapus route ini.';
});
