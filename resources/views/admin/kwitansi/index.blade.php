@extends('layouts.admin')
@section('title', 'Kwitansi — Admin')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.5rem;flex-wrap:wrap;gap:.5rem">
  <div><nav class="crumb">Dashboard / Kwitansi</nav><h1 style="font-size:1.5rem">Cetak Kwitansi</h1></div>
  <span style="font-size:.82rem;color:var(--gray-500)">Semua tagihan tampil di sini — sudah bayar maupun belum — agar bisa dicetak &amp; diserahkan manual.</span>
</div>

<div class="kpis">
  <div class="kpi"><div class="cap">TOTAL TAGIHAN</div><div class="n">{{ $stat['total'] }}</div></div>
  <div class="kpi"><div class="cap">LUNAS</div><div class="n" style="color:var(--teal)">{{ $stat['lunas'] }}</div></div>
  <div class="kpi"><div class="cap">BELUM BAYAR</div><div class="n" style="color:var(--amber)">{{ $stat['belum'] }}</div></div>
  <div class="kpi"><div class="cap">TERLAMBAT</div><div class="n" style="color:var(--red)">{{ $stat['terlambat'] }}</div></div>
</div>

<div class="panel">
  <div class="filterbar" style="margin-bottom:1rem">
    <div class="chips">
      <a href="{{ route('admin.kwitansi.index') }}" class="chip {{ $status ? '' : 'on' }}">Semua</a>
      <a href="{{ route('admin.kwitansi.index', ['status' => 'Lunas']) }}" class="chip {{ $status === 'Lunas' ? 'on' : '' }}">Lunas</a>
      <a href="{{ route('admin.kwitansi.index', ['status' => 'Belum Bayar']) }}" class="chip {{ $status === 'Belum Bayar' ? 'on' : '' }}">Belum Bayar</a>
      <a href="{{ route('admin.kwitansi.index', ['status' => 'Terlambat']) }}" class="chip {{ $status === 'Terlambat' ? 'on' : '' }}">Terlambat</a>
    </div>
  </div>

  <table class="atable">
    <thead><tr><th>No. Tagihan</th><th>Pelanggan</th><th>Periode</th><th>Jumlah</th><th>Status</th><th>Kwitansi</th></tr></thead>
    <tbody>
      @forelse($tagihans as $t)
        @php $sc = $t->status === 'Lunas' ? 'badge-green' : ($t->status === 'Terlambat' ? 'badge-red' : 'badge-yellow'); @endphp
        <tr>
          <td>{{ $t->no_tagihan }}</td>
          <td>{{ $t->pelanggan->nama ?? '-' }}<div style="font-size:.7rem;color:var(--gray-500)">{{ $t->pelanggan->kode ?? '' }}</div></td>
          <td>{{ $t->periode }}</td>
          <td>Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
          <td><span class="badge {{ $sc }}">{{ $t->status }}</span></td>
          <td>
            <a href="{{ route('admin.kwitansi.cetak', $t) }}" target="_blank"
               class="btn btn-outline-teal" style="padding:.35rem .7rem;font-size:.74rem;gap:.35rem">
              <i data-lucide="printer" style="width:14px;height:14px"></i> Cetak
            </a>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" style="text-align:center;color:var(--gray-500);padding:1.5rem">Tidak ada tagihan untuk filter ini.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
