@extends('layouts.app')
@section('title', 'Layanan Pengaduan — Desa Ibru')

@section('content')
<div class="pengaduan-hero"><div class="container">
  <div style="display:flex;gap:.75rem;align-items:center;margin-bottom:1rem"><div class="ic">💬</div><span class="badge" style="background:rgba(255,255,255,.2);color:#fff">Pusat Bantuan &amp; Pengaduan</span></div>
  <h1 style="color:#fff;font-size:1.875rem">Layanan Pengaduan &amp; Bantuan</h1>
  <p style="color:#ccfbf1;max-width:36rem;margin-top:.5rem">Sampaikan keluhan, pertanyaan, atau saran Anda terkait layanan air bersih di Desa Ibru. Kami siap membantu dan merespon dengan cepat.</p>
</div></div>
<div class="container">
  <div class="statbar">
    <div class="c"><div class="ic">⏱️</div><div class="n">24h</div><div class="l">Waktu Respon</div></div>
    <div class="c"><div class="ic">✅</div><div class="n">100%</div><div class="l">Tingkat Penyelesaian</div></div>
    <div class="c"><div class="ic">💬</div><div class="n">4.8</div><div class="l">Rating Layanan</div></div>
    <div class="c"><div class="ic">✔️</div><div class="n">1.2k</div><div class="l">Pengaduan Selesai</div></div>
  </div>
  <div class="cols-3" style="grid-template-columns:2fr 1fr">
    <div>
      <form class="card" method="POST" action="{{ route('pengaduan.store') }}">
        @csrf
        <h3>Formulir Pengaduan Digital</h3><p style="font-size:.85rem;color:var(--gray-600);margin-bottom:1rem">Isi formulir di bawah untuk menyampaikan keluhan atau saran</p>
        @if($errors->any())
          <div style="background:var(--red-100);color:var(--red-700);padding:.6rem .8rem;border-radius:.5rem;font-size:.8rem;margin-bottom:1rem">{{ $errors->first() }}</div>
        @endif
        <div class="grid-2"><div class="field"><label>Nama Lengkap *</label><input name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap"></div><div class="field"><label>Nomor Telepon *</label><input name="telp" value="{{ old('telp') }}" placeholder="08xx-xxxx-xxxx"></div></div>
        <div class="field" style="margin-top:1rem"><label>Alamat Lengkap</label><input name="alamat" value="{{ old('alamat') }}" placeholder="Jl. Contoh No. 123, RT/RW"></div>
        <div class="field" style="margin-top:1rem"><label>Kategori Pengaduan *</label>
          <select name="kategori">
            <option value="">Pilih kategori</option>
            <option>Air Mati / Tidak Mengalir</option>
            <option>Kebocoran Pipa</option>
            <option>Kualitas Air Buruk</option>
            <option>Meteran</option>
            <option>Pembayaran &amp; Denda</option>
            <option>Lainnya</option>
          </select>
        </div>
        <div class="field" style="margin-top:1rem"><label>Masalah yang Dialami *</label><textarea name="deskripsi" rows="4" placeholder="Jelaskan masalah Anda secara detail...">{{ old('deskripsi') }}</textarea></div>
        <div style="display:flex;gap:.75rem;margin-top:1.25rem"><button type="submit" class="btn btn-primary" style="flex:1">Kirim Pengaduan</button><button type="reset" class="btn btn-outline-teal">Reset</button></div>
      </form>

      <div class="card">
        <h3 style="margin-bottom:1rem">Riwayat Pengaduan Terbaru</h3>
        @forelse($riwayat as $a)
          @php
            $sc = $a->status === 'Selesai' ? 'badge-green' : ($a->status === 'Ditanggapi' ? 'badge-blue' : ($a->status === 'Proses' ? 'badge-blue' : 'badge-yellow'));
          @endphp
          <div class="aduan">
            <div style="display:flex;justify-content:space-between"><b>{{ $a->kategori }}</b><span class="badge {{ $sc }}">{{ $a->status }}</span></div>
            <div style="font-size:.78rem;color:var(--gray-500);margin:.2rem 0">{{ $a->kode }} · {{ $a->nama }} · {{ $a->created_at->format('d M Y, H:i') }}</div>
            <p style="font-size:.85rem;color:var(--gray-700)">{{ $a->deskripsi }}</p>
            @foreach($a->balasans as $b)
              <div class="reply"><b style="color:var(--teal-700)">↩ {{ $b->oleh }}</b><p style="margin-top:.3rem">{{ $b->isi }}</p></div>
            @endforeach
          </div>
        @empty
          <p style="color:var(--gray-600);font-size:.875rem">Belum ada pengaduan.</p>
        @endforelse
      </div>
    </div>
    <div>
      <div class="card" style="background:linear-gradient(135deg,#16a34a,#15803d);color:#fff">
        <h3 style="color:#fff">Chat Langsung</h3><p style="font-size:.85rem;color:#dcfce7;margin:.4rem 0 1rem">Hubungi customer service kami melalui WhatsApp untuk bantuan cepat.</p>
        <a href="https://wa.me/6282237937562" target="_blank" class="btn btn-white btn-block" style="display:block;text-align:center">💬 Chat via WhatsApp</a>
        <div style="font-size:.75rem;color:#dcfce7;margin-top:.6rem;text-align:center">0822-3793-7562 · Tersedia 24/7</div>
      </div>
      <div class="contact-card">
        <h3 style="margin-bottom:1rem">Jam Operasional</h3>
        <div class="row"><span class="lbl">Senin – Jumat</span><b>08:00 – 15:00</b></div>
        <div class="row"><span class="lbl">Sabtu</span><b>08:00 – 12:00</b></div>
        <div class="row"><span class="lbl">Minggu</span><b style="color:var(--red)">Tutup</b></div>
        <div class="divider"></div>
        <div class="line">📍 <div>Kantor Desa Ibru, Kecamatan Mestong, Kabupaten Muaro Jambi, Jambi</div></div>
        <div class="line">📞 <div>0822-3793-7562 (WhatsApp)</div></div>
        <div class="line">✉️ <div>layanan@desaibru.go.id</div></div>
      </div>
    </div>
  </div>
</div>
<div style="height:3rem"></div>
@endsection
