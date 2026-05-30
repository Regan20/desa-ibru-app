@extends('layouts.app')
@section('title', 'Daftar — Desa Ibru')

@section('content')
<div style="min-height:100vh;background:#E5E9EE;display:grid;place-items:center;padding:2.5rem 1rem">
  <div style="max-width:36rem;width:100%">
    <div style="background:#fff;border-radius:1.25rem;overflow:hidden;box-shadow:var(--shadow-lg)">
      <div style="background:linear-gradient(150deg,var(--teal-600),var(--teal-800));color:#fff;padding:2rem">
        <div style="font-size:1.5rem;margin-bottom:.25rem">💧</div>
        <h2 style="font-size:1.3rem">Daftar Akun Baru</h2>
        <p style="font-size:.875rem;opacity:.9;margin-top:.4rem">Buat akun untuk mengakses layanan air bersih Desa Ibru</p>
      </div>
      <form method="POST" action="{{ route('register.post') }}" style="padding:2rem">
        @csrf
        @if($errors->any())
          <div style="background:var(--red-100);color:var(--red-700);padding:.6rem .8rem;border-radius:.5rem;font-size:.8rem;margin-bottom:1rem">
            <ul style="margin:0;padding-left:1.1rem">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
          </div>
        @endif
        <div class="grid-2">
          <div class="field"><label>Nama Lengkap *</label><input name="nama" value="{{ old('nama') }}" placeholder="Nama lengkap Anda"></div>
          <div class="field"><label>No. Meter / ID Pelanggan *</label><input name="no_meter" value="{{ old('no_meter') }}" placeholder="Contoh: 12345678"></div>
        </div>
        <div class="field" style="margin-top:1rem"><label>Desa *</label>
          <select name="desa">
            @foreach($desas as $d)
              <option value="{{ $d->nama }}">Desa {{ $d->nama }} (Rp {{ number_format($d->tarif_per_m3, 0, ',', '.') }}/m³)</option>
            @endforeach
          </select>
        </div>
        <div class="field" style="margin-top:1rem"><label>Nomor HP (WhatsApp) *</label><input name="hp" value="{{ old('hp') }}" placeholder="08xx-xxxx-xxxx"></div>
        <div class="field" style="margin-top:1rem"><label>Email <span style="color:var(--gray-400);font-weight:400">(opsional)</span></label><input name="email" type="email" value="{{ old('email') }}" placeholder="email@contoh.com"></div>
        <div class="grid-2" style="margin-top:1rem">
          <div class="field"><label>Kata Sandi *</label><input name="password" type="password" placeholder="Minimal 8 karakter"></div>
          <div class="field"><label>Konfirmasi Kata Sandi *</label><input name="password_confirmation" type="password" placeholder="Ulangi kata sandi"></div>
        </div>
        <button type="submit" class="btn btn-primary btn-block" style="margin-top:1.25rem">✓ Daftar Sekarang</button>
        <p style="text-align:center;font-size:.85rem;color:var(--gray-500);margin-top:.9rem">Sudah punya akun? <a style="color:var(--teal);font-weight:600;cursor:pointer" href="{{ route('login') }}">Masuk di sini</a></p>
      </form>
    </div>
    <div style="text-align:center;margin-top:1rem"><a style="font-size:.85rem;color:var(--gray-500);cursor:pointer" href="{{ route('home') }}">← Kembali ke Beranda</a></div>
  </div>
</div>
@endsection
