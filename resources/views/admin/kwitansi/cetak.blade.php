<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kwitansi {{ $tagihan->no_tagihan }} — Desa Ibru</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,700;12..96,800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/enhance.css') }}">
</head>
<body>
@php
  $lunas = $tagihan->status === 'Lunas';
@endphp
<div class="receipt-wrap">

  <div class="receipt">
    <div class="rcpt-top">
      <div class="brand-r">
        <div class="logo">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="#fff"><path d="M12 2.5C12 2.5 6 9 6 14a6 6 0 0012 0c0-5-6-11.5-6-11.5z"/></svg>
        </div>
        <div>
          <h1>Desa Ibru</h1>
          <small>Layanan Air Bersih · Desa Ibru, Kec. Mestong</small>
        </div>
      </div>
      <div class="rcpt-no">No. Kwitansi<b>{{ $tagihan->no_tagihan }}</b></div>
    </div>

    <div class="rcpt-title">
      <div class="t">Kwitansi</div>
      <div class="s">Bukti Pembayaran Tagihan Air</div>
    </div>

    <div class="rcpt-stamp {{ $lunas ? 'lunas' : 'belum' }}">{{ $lunas ? 'LUNAS' : 'BELUM LUNAS' }}</div>

    <div class="rcpt-meta">
      <div class="r"><span class="k">Nama Pelanggan</span><span class="v">{{ $tagihan->pelanggan->nama ?? '-' }}</span></div>
      <div class="r"><span class="k">ID Pelanggan</span><span class="v">{{ $tagihan->pelanggan->kode ?? '-' }}</span></div>
      <div class="r"><span class="k">Desa</span><span class="v">{{ $tagihan->pelanggan->desa->nama ?? '-' }}</span></div>
      <div class="r"><span class="k">Wilayah / Dusun</span><span class="v">{{ $tagihan->pelanggan->wilayah ?? '-' }}</span></div>
      <div class="r"><span class="k">Kategori</span><span class="v">{{ $tagihan->pelanggan->kategori ?? '-' }}</span></div>
      <div class="r"><span class="k">Periode</span><span class="v">{{ $tagihan->periode }}</span></div>
      <div class="r"><span class="k">Pemakaian</span><span class="v">{{ $tagihan->pemakaian }} m³</span></div>
      <div class="r"><span class="k">Tarif per m³</span><span class="v">Rp {{ number_format($tagihan->pelanggan?->tarif() ?? 0, 0, ',', '.') }}</span></div>
      <div class="r"><span class="k">Jatuh Tempo</span><span class="v">{{ $tagihan->jatuh_tempo }}</span></div>
      <div class="r"><span class="k">Tanggal Bayar</span><span class="v">{{ $tagihan->tanggal_bayar ?? '—' }}</span></div>
    </div>

    <div class="rcpt-amount">
      <div>
        <div class="lbl">Jumlah Tagihan</div>
        <div class="terbilang">Terbilang: {{ ucfirst($terbilang) }}</div>
      </div>
      <div class="val">Rp {{ number_format($tagihan->jumlah, 0, ',', '.') }}</div>
    </div>

    <div class="rcpt-foot">
      <div class="note">
        Kwitansi ini sah sebagai bukti pembayaran layanan air bersih Desa Ibru.
        Simpan sebagai arsip. Untuk pertanyaan hubungi 0822-3793-7562.
      </div>
      <div class="rcpt-sign">
        Muaro Jambi, {{ \Illuminate\Support\Carbon::now()->translatedFormat('d F Y') }}<br>
        Bendahara BUMDes
        <div class="line"></div>
        <div class="nm">( ........................... )</div>
      </div>
    </div>
  </div>

  <div class="rcpt-actions no-print">
    <button class="btn btn-primary" onclick="window.print()"><i data-lucide="printer"></i> Cetak / Simpan PDF</button>
    <button class="btn btn-outline-teal" onclick="window.close()">Tutup</button>
  </div>
</div>

<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
<script>window.lucide && lucide.createIcons();</script>
</body>
</html>
