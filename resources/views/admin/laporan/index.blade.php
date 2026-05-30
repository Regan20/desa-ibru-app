@extends('layouts.admin')
@section('title', 'Laporan Keuangan — Admin')

@section('content')
@php
  $labels      = array_map(fn($r) => $r['bulan'], $ringkasan);
  $pendapatan  = array_map(fn($r) => round($r['pendapatan']  / 1000000, 1), $ringkasan);
  $pengeluaran = array_map(fn($r) => round($r['pengeluaran'] / 1000000, 1), $ringkasan);
  $keuntungan  = array_map(fn($r) => round(($r['pendapatan'] - $r['pengeluaran']) / 1000000, 1), $ringkasan);
  $donut       = [(int) $pemasukanReal, (int) $piutang];
@endphp

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.5rem">
  <div><nav class="crumb">Dashboard / Laporan Keuangan</nav><h1 style="font-size:1.5rem">Laporan Keuangan &amp; Statistik</h1></div>
</div>

<div class="kpis">
  <div class="kpi"><div class="cap">PEMASUKAN (DB)</div><div class="n" style="color:var(--teal)">Rp {{ number_format($pemasukanReal, 0, ',', '.') }}</div><div class="c up">Dari tagihan lunas</div></div>
  <div class="kpi"><div class="cap">PIUTANG (DB)</div><div class="n" style="color:var(--amber)">Rp {{ number_format($piutang, 0, ',', '.') }}</div><div class="c">Tagihan belum lunas</div></div>
  <div class="kpi"><div class="cap">PENDAPATAN BLN INI</div><div class="n" style="color:var(--teal)">Rp 142,5jt</div><div class="c up">↑ 5,2%</div></div>
  <div class="kpi"><div class="cap">KEUNTUNGAN BERSIH</div><div class="n" style="color:var(--teal)">Rp 123,2jt</div><div class="c">Margin 86,5%</div></div>
</div>

<div class="acols" style="margin-top:1rem">
  <div class="chart-card">
    <div class="ch-head"><div><h3>Pendapatan vs Pengeluaran</h3><div class="ch-sub">6 bulan terakhir (dalam juta Rupiah)</div></div></div>
    <div class="chart-box"><canvas id="chartKeuangan"></canvas></div>
  </div>
  <div class="chart-card">
    <div class="ch-head"><div><h3>Pemasukan vs Piutang</h3><div class="ch-sub">Berdasarkan status tagihan (data nyata)</div></div></div>
    <div class="chart-box sm"><canvas id="chartPiutang"></canvas></div>
    <div class="chart-legend">
      <span><i style="background:#0d9488"></i> Lunas (Rp {{ number_format($pemasukanReal, 0, ',', '.') }})</span>
      <span><i style="background:#f59e0b"></i> Piutang (Rp {{ number_format($piutang, 0, ',', '.') }})</span>
    </div>
  </div>
</div>

<div class="panel" style="margin-top:1rem">
  <h3 style="margin-bottom:.8rem">Ringkasan 6 Bulan Terakhir</h3>
  <table class="atable">
    <thead><tr><th>Bulan</th><th>Pendapatan</th><th>Pengeluaran</th><th>Keuntungan</th></tr></thead>
    <tbody>
      @foreach($ringkasan as $r)
        <tr>
          <td>{{ $r['bulan'] }}</td>
          <td>Rp {{ number_format($r['pendapatan'], 0, ',', '.') }}</td>
          <td>Rp {{ number_format($r['pengeluaran'], 0, ',', '.') }}</td>
          <td>Rp {{ number_format($r['pendapatan'] - $r['pengeluaran'], 0, ',', '.') }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

@push('scripts')
<script>
(function(){
  if (typeof Chart === 'undefined') return;
  Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
  Chart.defaults.color = '#6b7280';

  var ck = document.getElementById('chartKeuangan');
  if (ck) {
    new Chart(ck, {
      data: {
        labels: @json($labels),
        datasets: [
          { type: 'bar',  label: 'Pendapatan',  data: @json($pendapatan),  backgroundColor: '#0d9488', borderRadius: 6, maxBarThickness: 20 },
          { type: 'bar',  label: 'Pengeluaran', data: @json($pengeluaran), backgroundColor: '#f59e0b', borderRadius: 6, maxBarThickness: 20 },
          { type: 'line', label: 'Keuntungan',  data: @json($keuntungan),  borderColor: '#0f766e', borderWidth: 3, tension: .35, pointRadius: 3, fill: false }
        ]
      },
      options: {
        responsive: true, maintainAspectRatio: false,
        plugins: {
          legend: { position: 'bottom', labels: { boxWidth: 12, usePointStyle: true } },
          tooltip: { callbacks: { label: function (c) { return c.dataset.label + ': Rp ' + c.parsed.y + ' jt'; } } }
        },
        scales: {
          y: { beginAtZero: true, grid: { color: '#eef2f5' }, ticks: { callback: function (v) { return v + ' jt'; } } },
          x: { grid: { display: false } }
        }
      }
    });
  }

  var cp = document.getElementById('chartPiutang');
  if (cp) {
    new Chart(cp, {
      type: 'doughnut',
      data: {
        labels: ['Lunas', 'Piutang'],
        datasets: [{ data: @json($donut), backgroundColor: ['#0d9488', '#f59e0b'], borderWidth: 0, hoverOffset: 6 }]
      },
      options: {
        responsive: true, maintainAspectRatio: false, cutout: '64%',
        plugins: {
          legend: { display: false },
          tooltip: { callbacks: { label: function (c) { return c.label + ': Rp ' + c.parsed.toLocaleString('id-ID'); } } }
        }
      }
    });
  }
})();
</script>
@endpush
@endsection
