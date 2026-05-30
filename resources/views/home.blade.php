@extends('layouts.app')
@section('title', 'Desa Ibru — Layanan Air Bersih Desa Ibru')

@section('content')
<div class="hero" style="background-image:url('{{ asset('assets/hero-desa.png') }}')">
  <div class="overlay"></div>
  <div class="container">
    <div class="grid">
      <div>
        <span class="pill">Layanan Digital Desa</span>
        <h1>Layanan Air Bersih Desa Ibru yang Praktis dan Mudah.</h1>
        <p>Satu platform untuk mengelola pembayaran air, laporan penggunaan, dan pengaduan layanan dengan mudah dan transparan.</p>
        <div class="actions">
          @auth
            <a class="btn btn-white btn-lg" href="{{ route('tagihan.cek') }}">Cek Tagihan</a>
            <a class="btn btn-outline-white btn-lg" href="{{ route('dashboard') }}">Dashboard</a>
          @else
            <a class="btn btn-white btn-lg" href="{{ route('login') }}">Masuk untuk Cek Tagihan</a>
          @endauth
        </div>
      </div>
      <div class="logo-wrap"><div class="logo-ring"><div class="bg"></div><img src="{{ asset('assets/logo-ibru.jpeg') }}" alt="Logo Desa Ibru"></div></div>
    </div>
  </div>
</div>

<section class="section white">
  <div class="container">
    <div class="section-head"><h2>Mengapa Menggunakan Desa Ibru?</h2><p>Platform terpadu untuk semua kebutuhan layanan air bersih desa Anda</p></div>
    <div class="grid-3">
      <div class="feature"><div class="ic">📄</div><h3>Apa Itu Desa Ibru?</h3><p>Platform digital untuk mengelola pembayaran dan layanan air bersih desa secara online, transparan, dan mudah diakses.</p></div>
      <div class="feature"><div class="ic">🛡️</div><h3>Aman, Terpercaya</h3><p>Sistem keamanan berlapis dan enkripsi data untuk melindungi informasi dan transaksi Anda.</p></div>
      <div class="feature"><div class="ic">⏰</div><h3>Tepat Waktu</h3><p>Notifikasi otomatis dan reminder pembayaran agar tidak terlewat jatuh tempo tagihan air.</p></div>
    </div>
  </div>
</section>

<section class="band">
  <div class="container">
    <div class="section-head"><h2 style="color:#fff">Dashboard Pengguna</h2><p style="color:var(--teal-100)">Kelola penggunaan dan pembayaran air dengan mudah</p></div>
    <div class="grid-3">
      <div class="card"><div style="font-size:1.5rem">📈</div><h3>Statistik Real-time</h3></div>
      <div class="card"><div style="font-size:1.5rem">✅</div><h3>Riwayat Lengkap</h3></div>
      <div class="card"><div style="font-size:1.5rem">👥</div><h3>Dukungan 24/7</h3></div>
    </div>
  </div>
</section>

<section class="section white">
  <div class="container">
    <div class="section-head"><h2>Berita Desa &amp; Pengumuman</h2></div>
    <div class="grid-3">
      @forelse($berita as $b)
        <div class="news-card">
          <img src="{{ $b->gambar ? asset($b->gambar) : asset('assets/news-instalasi.png') }}" alt="{{ $b->judul }}">
          <div class="body"><div class="date">{{ $b->tanggal }}</div><h4>{{ $b->judul }}</h4></div>
        </div>
      @empty
        <p style="color:var(--gray-600)">Belum ada berita.</p>
      @endforelse
    </div>
  </div>
</section>

<section class="section gray">
  <div class="container">
    <div class="grid-4" style="text-align:center">
      <div><div class="stat-num">2.4k</div><div class="stat-lbl">Transaksi Selesai</div></div>
      <div><div class="stat-num">100%</div><div class="stat-lbl">Tingkat Kepuasan</div></div>
      <div><div class="stat-num">4.8</div><div class="stat-lbl">Rating Layanan</div></div>
      <div><div class="stat-num">1.2k</div><div class="stat-lbl">Warga Terdaftar</div></div>
    </div>
  </div>
</section>
@endsection
