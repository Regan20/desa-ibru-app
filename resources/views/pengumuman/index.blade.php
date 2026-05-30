@extends('layouts.app')
@section('title', 'Pengumuman Layanan Air — Desa Ibru')

@section('content')
<div class="page gray"><div class="container">
  <nav class="crumb"><a href="{{ route('home') }}" style="cursor:pointer">Desa Ibru</a><span>/</span><span class="on">Pengumuman Layanan Air</span></nav>
  <h1>Pengumuman Layanan Air</h1><p class="sub">Dapatkan informasi terkini tentang pemeliharaan, gangguan layanan, dan kebijakan baru untuk pelayanan air bersih di wilayah Desa Ibru.</p>

  @php $utama = $pengumuman->first(); @endphp
  @if($utama)
  <div class="alert-strip">
    <div class="ic">⚠️</div>
    <div><span class="badge" style="background:rgba(255,255,255,.3);color:#fff">PENGUMUMAN PENTING</span>
    <h3 style="font-size:1.25rem;margin:.5rem 0">{{ $utama->judul }}</h3>
    <p style="color:#fee2e2;margin-bottom:1rem">{{ \Illuminate\Support\Str::limit($utama->isi, 160) }}</p>
    <div style="display:flex;gap:1rem;align-items:center">
      <a class="btn btn-white" href="{{ route('pengumuman.show', $utama) }}">Lihat Detail</a>
      <span style="font-size:.85rem;color:#fecaca">Diposting {{ $utama->tanggal }}</span>
    </div></div>
  </div>
  @endif

  <div class="filterbar">
    <div class="chips" id="pchips"><span class="chip on">Semua</span><span class="chip">Jadwal Perbaikan</span><span class="chip">Informasi Gangguan</span><span class="chip">Kebijakan Baru</span></div>
    <div class="field" style="position:relative">
      <input id="search-pengumuman" placeholder="Cari Pengumuman..." style="padding-left:2.2rem;width:16rem" oninput="filterPengumuman()">
      <span style="position:absolute;left:.7rem;top:.65rem;color:var(--gray-400)">🔍</span>
    </div>
  </div>

  <div class="cols-3" style="grid-template-columns:2fr 1fr">
    <div>
      @foreach($pengumuman as $p)
        <div class="ann ann-item">
          <img src="{{ $p->gambar ? asset($p->gambar) : asset('assets/news-instalasi.png') }}" alt="{{ $p->judul }}">
          <div class="body">
            <div><span class="badge {{ $p->badge ?? 'badge-blue' }}">{{ strtoupper($p->kategori) }}</span> <span style="font-size:.85rem;color:var(--gray-500)">{{ $p->sub }}</span></div>
            <h3>{{ $p->judul }}</h3>
            <p>{{ \Illuminate\Support\Str::limit($p->isi, 150) }}</p>
            <div style="display:flex;justify-content:space-between">
              <span style="font-size:.85rem;color:var(--gray-500)">{{ $p->tanggal }}</span>
              <a style="color:var(--teal);font-weight:600;cursor:pointer" href="{{ route('pengumuman.show', $p) }}">Baca Selengkapnya →</a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <div><div class="card"><h3 style="margin-bottom:1rem">Statistik Layanan</h3>
      <div class="row"><span class="lbl">Pelanggan Aktif</span><b>1.234</b></div>
      <div class="row"><span class="lbl">Pengumuman Bulan Ini</span><b>{{ $pengumuman->count() }}</b></div>
      <div class="row"><span class="lbl">Layanan Tersedia</span><b style="color:var(--green-600)">100%</b></div>
    </div></div>
  </div>
</div></div>
@endsection
