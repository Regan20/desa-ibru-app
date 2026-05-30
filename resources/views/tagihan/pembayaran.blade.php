@extends('layouts.app')
@section('title', 'Pembayaran — Desa Ibru')

@section('content')
<div class="page gray"><div class="container">
  <nav class="crumb"><a href="{{ route('home') }}" style="cursor:pointer">Desa Ibru</a><span>/</span><span class="on">Pembayaran Air</span></nav>
  <h1>Pembayaran Tagihan Air</h1><p class="sub">Simulasi pembayaran bulanan warga Desa Ibru secara praktis dan aman.</p>
  <div class="pay-grid">
    <div>
      <div class="card">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem"><h3>Ringkasan Tagihan</h3><span class="badge badge-teal">Periode {{ $tagihan->periode }}</span></div>
        <div class="row"><span class="lbl">Pemakaian ({{ $tagihan->pemakaian }} m³ × Rp {{ number_format($tagihan->pelanggan->tarif(), 0, ',', '.') }})</span><span class="val">Rp {{ number_format($tagihan->jumlah, 0, ',', '.') }}</span></div>
        <div class="divider" style="display:flex;justify-content:space-between"><span style="font-weight:600">Total Pembayaran</span><span style="font-size:1.5rem;font-weight:700;color:var(--teal)">Rp {{ number_format($tagihan->jumlah, 0, ',', '.') }}</span></div>
      </div>
      <div class="card">
        <h3 style="margin-bottom:1rem">Pilih Metode Pembayaran</h3>
        <div class="pay-methods">
          <button type="button" class="pay-method sel" id="pm-qris" onclick="selPay('qris')"><div class="ic">▦</div><div style="font-weight:600">QRIS</div><div style="font-size:.72rem;color:var(--gray-500)">Gopay, OVO, Dana, LinkAja</div><div class="dot"></div></button>
          <button type="button" class="pay-method" id="pm-bank" onclick="selPay('bank')"><div class="ic">🏦</div><div style="font-weight:600">Transfer Bank</div><div style="font-size:.72rem;color:var(--gray-500)">BRI, BNI, Mandiri</div><div class="dot"></div></button>
        </div>
      </div>
      <div class="info-box info-teal">ℹ️<div>Pembayaran Anda akan diverifikasi secara otomatis dalam 5-10 menit setelah transaksi berhasil.</div></div>
    </div>
    <div>
      {{-- QRIS --}}
      <form method="POST" action="{{ route('tagihan.bayar', $tagihan) }}" class="qris" id="qris-view">
        @csrf
        <input type="hidden" name="metode" value="QRIS">
        <h3 style="font-size:1.25rem;margin-bottom:.5rem">Simulasi QRIS</h3>
        <p style="font-size:.85rem;color:var(--teal-100)">Pindai kode di bawah untuk membayar</p>
        <div class="qrbox"><img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=DesaIbru-{{ $tagihan->no_tagihan }}-Rp{{ $tagihan->jumlah }}" alt="QRIS"></div>
        <div class="row" style="color:#fff"><span style="color:var(--teal-100)">Merchant:</span><b>Tirta Desa Ibru</b></div>
        <div class="row" style="color:#fff"><span style="color:var(--teal-100)">ID Transaksi:</span><b>{{ $tagihan->no_tagihan }}</b></div>
        <button type="submit" class="btn btn-white btn-block" style="margin-top:1rem">✓ Saya Sudah Bayar (Simulasi)</button>
      </form>
      {{-- Transfer Bank --}}
      <form method="POST" action="{{ route('tagihan.bayar', $tagihan) }}" class="card hidden" id="bank-view">
        @csrf
        <input type="hidden" name="metode" value="Transfer Bank">
        <h3 style="margin-bottom:1rem">Transfer Bank</h3>
        <div class="bankrow"><div style="font-size:.85rem;color:var(--gray-600)">Bank BRI</div><div class="num">1234-5678-9012-3456</div><div style="font-size:.85rem;color:var(--gray-600)">a.n. Bendahara Desa Ibru</div></div>
        <div class="bankrow"><div style="font-size:.85rem;color:var(--gray-600)">Bank BNI</div><div class="num">9876-5432-1098-7654</div><div style="font-size:.85rem;color:var(--gray-600)">a.n. Bendahara Desa Ibru</div></div>
        <div class="bankrow"><div style="font-size:.85rem;color:var(--gray-600)">Bank Mandiri</div><div class="num">1111-2222-3333-4444</div><div style="font-size:.85rem;color:var(--gray-600)">a.n. Bendahara Desa Ibru</div></div>
        <div style="background:var(--yellow-50);border:1px solid var(--yellow-200);border-radius:.5rem;padding:.75rem;margin-top:1rem;font-size:.75rem;color:var(--yellow-800)">Setelah transfer, mohon konfirmasi pembayaran melalui WhatsApp ke 0822-3793-7562</div>
        <button type="submit" class="btn btn-primary btn-block" style="margin-top:1rem">✓ Konfirmasi Pembayaran (Simulasi)</button>
      </form>
    </div>
  </div>
</div></div>
@endsection
