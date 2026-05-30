<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Desa Ibru — Layanan Air Bersih')</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,600;12..96,700;12..96,800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/enhance.css') }}">
</head>
<body>

<div id="user-app">
  <header class="uheader">
    <div class="container inner">
      <a class="brand" href="{{ route('home') }}" style="cursor:pointer">
        <span class="mark"><svg width="18" height="18" viewBox="0 0 24 24" fill="#fff"><path d="M12 2.5C12 2.5 6 9 6 14a6 6 0 0012 0c0-5-6-11.5-6-11.5z"/></svg></span>
        <span class="name">Desa Ibru</span>
      </a>
      <nav class="unav" id="unav">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
        @auth
          <a href="{{ route('tagihan.cek') }}" class="{{ request()->routeIs('tagihan.*') ? 'active' : '' }}">Pembayaran Air</a>
          <a href="{{ route('pengumuman.index') }}" class="{{ request()->routeIs('pengumuman.*') ? 'active' : '' }}">Pengumuman Layanan Air</a>
          <a href="{{ route('pengaduan.index') }}" class="{{ request()->routeIs('pengaduan.*') ? 'active' : '' }}">Laporkan Sekarang</a>
          <a class="btn btn-primary" style="color:#fff" href="{{ route('dashboard') }}">Dashboard</a>
          <a class="btn btn-outline-teal" style="cursor:pointer" onclick="askLogout()">Logout</a>
        @else
          <a class="btn btn-primary" style="color:#fff" href="{{ route('login') }}">Masuk</a>
        @endauth
      </nav>
      <button class="menu-btn" onclick="document.getElementById('unav').classList.toggle('open')">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
      </button>
    </div>
  </header>

  @yield('content')

  <footer class="footer"><div class="container inner">
    <div><div class="name">Desa Ibru</div><p>© {{ date('Y') }} Pemerintah Desa Ibru. Seluruh Hak Cipta Dilindungi.</p></div>
    <div class="links"><a>Kontak Layanan</a><a>Kebijakan Privasi</a><a>Syarat &amp; Ketentuan</a></div>
  </div></footer>
</div>

{{-- Form logout tersembunyi (POST + CSRF) --}}
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>

{{-- Modal konfirmasi global (logout & hapus) --}}
@include('partials.confirm')

{{-- Toast notifikasi: diisi dari flash message / error --}}
<div class="toast" id="toast"
     data-msg="{{ session('success') ?? ($errors->any() ? $errors->first() : '') }}"></div>

<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script>window.lucide && lucide.createIcons();</script>
@stack('scripts')
</body>
</html>
