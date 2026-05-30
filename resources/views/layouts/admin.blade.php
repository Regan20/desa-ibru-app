<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Admin Panel — Desa Ibru')</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,600;12..96,700;12..96,800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/enhance.css') }}">
</head>
<body>

<div id="admin-app" class="active">
  <aside class="aside" id="aside">
    <div class="logo"><span class="m"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.5C12 2.5 6 9 6 14a6 6 0 0012 0c0-5-6-11.5-6-11.5z"/></svg></span><div><b>Desa Ibru</b><small>Admin Panel</small></div></div>
    <div class="cap">MENU UTAMA</div>
    <a class="amenu {{ request()->routeIs('admin.dashboard') ? 'on' : '' }}" href="{{ route('admin.dashboard') }}"><i data-lucide="layout-dashboard"></i> Dashboard</a>
    <a class="amenu {{ request()->routeIs('admin.pelanggan.*') ? 'on' : '' }}" href="{{ route('admin.pelanggan.index') }}"><i data-lucide="users"></i> Pelanggan</a>
    <a class="amenu {{ request()->routeIs('admin.tagihan.*') ? 'on' : '' }}" href="{{ route('admin.tagihan.index') }}"><i data-lucide="receipt-text"></i> Tagihan</a>
    <a class="amenu {{ request()->routeIs('admin.verifikasi.*') ? 'on' : '' }}" href="{{ route('admin.verifikasi.index') }}"><i data-lucide="credit-card"></i> Verifikasi</a>
    <a class="amenu {{ request()->routeIs('admin.pengaduan.*') ? 'on' : '' }}" href="{{ route('admin.pengaduan.index') }}"><i data-lucide="message-square"></i> Pengaduan</a>
    <a class="amenu {{ request()->routeIs('admin.berita.*') ? 'on' : '' }}" href="{{ route('admin.berita.index') }}"><i data-lucide="newspaper"></i> Berita &amp; Pengumuman</a>
    <a class="amenu {{ request()->routeIs('admin.laporan.*') ? 'on' : '' }}" href="{{ route('admin.laporan.index') }}"><i data-lucide="bar-chart-3"></i> Laporan Keuangan</a>
    <div class="cap">PENGATURAN</div>
    <a class="amenu {{ request()->routeIs('admin.pengaturan') ? 'on' : '' }}" href="{{ route('admin.pengaturan') }}"><i data-lucide="settings"></i> Pengaturan</a>
    <a class="amenu" style="cursor:pointer" onclick="askLogout()"><i data-lucide="log-out"></i> Keluar</a>
  </aside>
  <main class="amain">
    <div class="atop">
      <button class="menu-btn" onclick="document.getElementById('aside').classList.toggle('open')">☰</button>
      <div class="hello"><small>Selamat datang kembali,</small><br><b>{{ auth()->user()->name }}</b> <span style="font-size:.72rem;color:var(--gray-500)">· Admin BUMDes</span></div>
      <div class="search"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4-4"/></svg><input placeholder="Cari pelanggan, tagihan..."></div>
      <div class="ava">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
    </div>
    <div class="abody">
      @yield('content')
    </div>
  </main>
</div>

<form id="admin-logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>

@include('partials.confirm')

<div class="toast" id="toast"
     data-msg="{{ session('success') ?? ($errors->any() ? $errors->first() : '') }}"></div>

<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script>window.lucide && lucide.createIcons();</script>
@stack('scripts')
</body>
</html>
