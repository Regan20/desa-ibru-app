@extends('layouts.app')
@section('title', $berita->judul . ' — Desa Ibru')

@section('content')
<div class="page gray"><div class="container">
  <nav class="crumb"><a href="{{ route('home') }}" style="cursor:pointer">Beranda</a><span>/</span><a href="{{ route('pengumuman.index') }}" style="cursor:pointer">Pengumuman</a><span>/</span><span class="on">Detail</span></nav>
  <div style="max-width:50rem;margin:0 auto">
    <div class="card" style="padding:0;overflow:hidden">
      <img src="{{ $berita->gambar ? asset($berita->gambar) : asset('assets/news-instalasi.png') }}" alt="{{ $berita->judul }}" style="width:100%;max-height:20rem;object-fit:cover">
      <div style="padding:1.75rem">
        <div style="margin-bottom:.75rem"><span class="badge {{ $berita->badge ?? 'badge-blue' }}">{{ strtoupper($berita->kategori) }}</span></div>
        <h1 style="font-size:1.5rem;margin-bottom:.5rem">{{ $berita->judul }}</h1>
        <div style="font-size:.875rem;color:var(--gray-500);margin-bottom:1.25rem">{{ $berita->tanggal }} · {{ $berita->views }} kali dibaca</div>
        <p style="color:var(--gray-700);line-height:1.8;font-size:.95rem">{{ $berita->isi }}</p>
        <div style="margin-top:1.5rem;padding-top:1.25rem;border-top:1px solid var(--gray-200)">
          <a class="btn btn-outline-teal" href="{{ route('pengumuman.index') }}">← Kembali ke Pengumuman</a>
        </div>
      </div>
    </div>
  </div>
</div></div>
@endsection
