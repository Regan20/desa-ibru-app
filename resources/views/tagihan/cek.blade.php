@extends('layouts.app')
@section('title', 'Cek Tagihan Air — Desa Ibru')

@section('content')
<div class="page gray"><div class="container">
  <nav class="crumb">
    <a href="{{ route('home') }}">Beranda</a><span>/</span><span class="on">Pembayaran Air</span>
  </nav>
  <h1>Cek Tagihan Air</h1>
  <p class="sub">Masukkan nomor meter atau ID pelanggan untuk melihat tagihan Anda.</p>

  <div style="display:grid;grid-template-columns:360px 1fr;gap:1.5rem;align-items:start">

    {{-- ---- KOLOM KIRI: FORM ---- --}}
    <div>
      <div class="card">
        <h3 style="margin-bottom:1rem">Cari Pelanggan</h3>
        <form method="POST" action="{{ route('tagihan.cari') }}">
          @csrf
          <div class="field">
            <label>Nomor Meter / ID Pelanggan</label>
            <input name="meter" value="{{ old('meter', 'IBR-2024-001') }}" placeholder="Contoh: IBR-2024-001">
          </div>
          @error('meter')
            <div style="color:var(--red-700,#b91c1c);font-size:.78rem;margin-top:.4rem">{{ $message }}</div>
          @enderror
          <button type="submit" class="btn btn-primary btn-block" style="margin-top:1rem">Cek Sekarang</button>
        </form>
      </div>

      <div class="card" style="margin-top:1rem;background:var(--teal-50,#f0fdfa);border:1px solid var(--teal-200,#99f6e4)">
        <div style="display:flex;gap:.75rem;align-items:flex-start">
          <div style="width:2rem;height:2rem;border-radius:.5rem;background:var(--teal,#0d9488);display:grid;place-items:center;flex:none">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
          </div>
          <div>
            <div style="font-size:.82rem;font-weight:700;color:var(--teal-800,#115e59);margin-bottom:.3rem">Informasi Pembayaran</div>
            <p style="font-size:.78rem;color:var(--teal-700,#0f766e);line-height:1.5;margin:0">Pembayaran dapat dilakukan melalui Kantor Desa, Transfer Bank, atau E-Wallet yang tersedia hingga tanggal 20 setiap bulannya.</p>
          </div>
        </div>
      </div>
    </div>

    {{-- ---- KOLOM KANAN: TAGIHAN ---- --}}
    @if($tagihan)
      <div style="display:flex;flex-direction:column;gap:1rem">

        {{-- Kartu tagihan utama --}}
        <div class="card" style="border-top:4px solid {{ $tagihan->status === 'Lunas' ? '#16a34a' : ($tagihan->status === 'Terlambat' ? '#ef4444' : '#f59e0b') }}">
          {{-- Header --}}
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
            <div>
              <div style="font-size:.75rem;color:var(--gray-500);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.2rem">Tagihan Periode</div>
              <div style="font-size:1rem;font-weight:700">{{ $tagihan->periode }}</div>
            </div>
            @php
              $statusColor = $tagihan->status === 'Lunas' ? 'badge-green' : ($tagihan->status === 'Terlambat' ? 'badge-red' : 'badge-yellow');
            @endphp
            <span class="badge {{ $statusColor }}" style="font-size:.8rem;padding:.35rem .8rem">{{ $tagihan->status }}</span>
          </div>

          {{-- Jumlah besar --}}
          <div style="background:var(--gray-50,#f9fafb);border-radius:.75rem;padding:1rem 1.25rem;margin-bottom:1rem">
            <div style="font-size:.75rem;color:var(--gray-500);margin-bottom:.25rem">Total Tagihan</div>
            <div style="font-size:2rem;font-weight:800;color:var(--teal,#0d9488);font-family:'Bricolage Grotesque',sans-serif;line-height:1">
              Rp {{ number_format($tagihan->jumlah, 0, ',', '.') }}
            </div>
            <div style="font-size:.78rem;color:var(--gray-500);margin-top:.4rem">
              Jatuh tempo: <strong>{{ $tagihan->jatuh_tempo }}</strong>
            </div>
          </div>

          {{-- Rincian --}}
          <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--gray-400);margin-bottom:.6rem">Rincian</div>
          <div style="display:flex;flex-direction:column;gap:.5rem">
            <div style="display:flex;justify-content:space-between;align-items:center;font-size:.875rem;padding:.5rem 0;border-bottom:1px solid var(--gray-100,#f3f4f6)">
              <span style="color:var(--gray-600)">Nama Pelanggan</span>
              <span style="font-weight:600">{{ $pelanggan->nama }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;font-size:.875rem;padding:.5rem 0;border-bottom:1px solid var(--gray-100,#f3f4f6)">
              <span style="color:var(--gray-600)">ID Pelanggan</span>
              <span style="font-weight:600">{{ $pelanggan->kode }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;font-size:.875rem;padding:.5rem 0;border-bottom:1px solid var(--gray-100,#f3f4f6)">
              <span style="color:var(--gray-600)">Desa</span>
              <span style="font-weight:600">{{ $pelanggan->desa->nama ?? '-' }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;font-size:.875rem;padding:.5rem 0;border-bottom:1px solid var(--gray-100,#f3f4f6)">
              <span style="color:var(--gray-600)">Pemakaian</span>
              <span style="font-weight:600">{{ $tagihan->pemakaian }} m³</span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;font-size:.875rem;padding:.5rem 0;border-bottom:1px solid var(--gray-100,#f3f4f6)">
              <span style="color:var(--gray-600)">Tarif per m³</span>
              <span style="font-weight:600">Rp {{ number_format($pelanggan->tarif(), 0, ',', '.') }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;font-size:.95rem;padding:.6rem 0;font-weight:700">
              <span>Total</span>
              <span style="color:var(--teal,#0d9488)">Rp {{ number_format($tagihan->jumlah, 0, ',', '.') }}</span>
            </div>
          </div>
        </div>

        {{-- Kartu penggunaan volume --}}
        <div class="card" style="background:linear-gradient(135deg,#0d9488,#0f766e);color:#fff;display:flex;gap:1rem;align-items:center">
          <div style="width:3rem;height:3rem;border-radius:.75rem;background:rgba(255,255,255,.2);display:grid;place-items:center;flex:none">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="#fff"><path d="M12 2.5C12 2.5 6 9 6 14a6 6 0 0012 0c0-5-6-11.5-6-11.5z"/></svg>
          </div>
          <div style="flex:1">
            <div style="font-size:.75rem;opacity:.8;margin-bottom:.2rem">Kategori: {{ $pelanggan->kategori }}</div>
            <div style="font-size:.85rem;font-weight:600;opacity:.9">Volume Penggunaan Bulan Ini</div>
            <div style="font-size:1.75rem;font-weight:800;font-family:'Bricolage Grotesque',sans-serif;line-height:1.1">{{ $tagihan->pemakaian }} m³</div>
          </div>
        </div>

        {{-- Tombol bayar --}}
        @if($tagihan->status !== 'Lunas')
          <a class="btn btn-primary btn-lg" href="{{ route('tagihan.pembayaran', $tagihan) }}"
             style="text-align:center;display:block">
            Lanjut ke Pembayaran →
          </a>
        @else
          <div class="card" style="background:#f0fdf4;border:1px solid #86efac;text-align:center;padding:1rem">
            <div style="font-size:1.5rem;margin-bottom:.4rem">✓</div>
            <div style="font-weight:700;color:#15803d">Tagihan Sudah Lunas</div>
            <div style="font-size:.8rem;color:#166534;margin-top:.25rem">Dibayar: {{ $tagihan->tanggal_bayar ?? '-' }}</div>
          </div>
        @endif

      </div>
    @else
      {{-- Placeholder saat belum ada hasil --}}
      <div class="card" style="text-align:center;padding:2.5rem 1rem;border:2px dashed var(--gray-200,#e5e7eb)">
        <div style="width:3.5rem;height:3.5rem;border-radius:50%;background:var(--gray-100,#f3f4f6);display:grid;place-items:center;margin:0 auto .9rem">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--gray-400)" stroke-width="1.5"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/><line x1="9" y1="12" x2="15" y2="12"/><line x1="9" y1="16" x2="13" y2="16"/></svg>
        </div>
        <div style="font-weight:600;color:var(--gray-700);margin-bottom:.35rem">Belum ada data tagihan</div>
        <div style="font-size:.82rem;color:var(--gray-500)">Masukkan nomor meter atau ID pelanggan di sebelah kiri untuk melihat tagihan.</div>
      </div>
    @endif

  </div>
</div></div>

@push('scripts')
<script>
// Auto-focus input saat halaman dimuat (hanya bila belum ada hasil)
document.addEventListener('DOMContentLoaded', function () {
  @if(!$tagihan)
    var inp = document.querySelector('input[name="meter"]');
    if (inp) inp.select();
  @endif
});
</script>
@endpush
@endsection
