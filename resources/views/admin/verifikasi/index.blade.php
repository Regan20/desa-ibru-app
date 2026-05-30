@extends('layouts.admin')
@section('title', 'Verifikasi Pembayaran — Admin')

@section('content')
<nav class="crumb">Dashboard / Verifikasi Pembayaran</nav>
<h1 style="font-size:1.5rem">Verifikasi Pembayaran</h1>
<div style="background:var(--yellow-50);border:1px solid var(--yellow-200);color:var(--yellow-800);padding:.75rem 1rem;border-radius:.5rem;font-size:.85rem;margin:.9rem 0">
  ⏳ {{ $pembayarans->count() }} pembayaran menunggu verifikasi
</div>

@forelse($pembayarans as $bayar)
  <div class="verifc">
    <div style="display:flex;justify-content:space-between;align-items:center">
      <div><b>{{ $bayar->pelanggan->nama ?? 'Pelanggan' }}</b> <span class="badge badge-blue">{{ $bayar->pelanggan->kode ?? '-' }}</span></div>
      <div style="display:flex;gap:.5rem">
        <form action="{{ route('admin.verifikasi.update', $bayar) }}" method="POST">
          @csrf @method('PUT')
          <input type="hidden" name="aksi" value="terima">
          <button type="submit" class="btn" style="background:var(--green-100);color:#15803d;padding:.4rem .8rem;font-size:.8rem">✓ Verifikasi</button>
        </form>
        <form action="{{ route('admin.verifikasi.update', $bayar) }}" method="POST">
          @csrf @method('PUT')
          <input type="hidden" name="aksi" value="tolak">
          <button type="submit" class="btn" style="background:var(--red-100);color:var(--red-700);padding:.4rem .8rem;font-size:.8rem">✕ Tolak</button>
        </form>
      </div>
    </div>
    <div class="verifg">
      <div><div class="k">Jumlah</div><div class="v">Rp {{ number_format($bayar->jumlah, 0, ',', '.') }}</div></div>
      <div><div class="k">Metode</div><div class="v">{{ $bayar->metode }}</div></div>
      <div><div class="k">Waktu</div><div class="v">{{ $bayar->created_at->diffForHumans() }}</div></div>
      <div><div class="k">No. Tagihan</div><div class="v" style="color:var(--teal)">{{ $bayar->tagihan->no_tagihan ?? '-' }}</div></div>
    </div>
  </div>
@empty
  <div class="panel" style="text-align:center;color:var(--gray-500);padding:2rem">
    Tidak ada pembayaran yang menunggu verifikasi saat ini.<br>
    <span style="font-size:.85rem">Pembayaran akan muncul di sini setelah pengguna melakukan pembayaran tagihan.</span>
  </div>
@endforelse
@endsection
