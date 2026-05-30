@extends('layouts.admin')
@section('title', 'Dashboard Admin — Desa Ibru')

@section('content')
<div class="kpis">
  <div class="kpi"><div class="cap">TOTAL PELANGGAN 👥</div><div class="n">{{ number_format($kpi['total_pelanggan'], 0, ',', '.') }}</div><div class="c up">Data dari database</div></div>
  <div class="kpi"><div class="cap">PEMASUKAN (LUNAS) 💰</div><div class="n">Rp {{ number_format($kpi['pemasukan'], 0, ',', '.') }}</div><div class="c up">Total tagihan lunas</div></div>
  <div class="kpi"><div class="cap">TAGIHAN BELUM BAYAR ⚠️</div><div class="n" style="color:#D85A30">{{ $kpi['belum_bayar'] }}</div><div class="c down">Rp {{ number_format($kpi['outstanding'], 0, ',', '.') }} outstanding</div></div>
  <div class="kpi"><div class="cap">PENGADUAN AKTIF 💬</div><div class="n" style="color:var(--amber)">{{ $kpi['pengaduan_aktif'] }}</div><div class="c warn">Perlu ditindaklanjuti</div></div>
</div>
<div class="acols">
  <div class="chart-card">
    <div class="ch-head">
      <div><h3>Pendapatan &amp; Target</h3><div class="ch-sub">6 bulan terakhir (dalam juta Rupiah)</div></div>
    </div>
    <div class="chart-box"><canvas id="chartPendapatan"></canvas></div>
  </div>
  <div class="chart-card">
    <div class="ch-head"><div><h3>Status Pembayaran</h3><div class="ch-sub">Distribusi status tagihan saat ini</div></div></div>
    <div class="chart-box sm"><canvas id="chartStatus"></canvas></div>
    <div class="chart-legend">
      <span><i style="background:#16a34a"></i> Lunas ({{ $kpi['lunas'] }})</span>
      <span><i style="background:#f59e0b"></i> Belum Bayar ({{ $kpi['belum_bayar'] }})</span>
      <span><i style="background:#ef4444"></i> Terlambat ({{ $kpi['terlambat'] }})</span>
    </div>
    <div style="font-weight:700;font-size:.85rem;margin-top:1.25rem">Aksi Cepat</div>
    <div class="actgrid" style="margin-top:.6rem">
      <a class="actbtn" href="{{ route('admin.tagihan.index') }}"><div class="ic"><i data-lucide="receipt-text"></i></div><div><h4>Kelola Tagihan</h4><p>Generate / manual</p></div></a>
      <a class="actbtn" href="{{ route('admin.pelanggan.index') }}"><div class="ic"><i data-lucide="user-plus"></i></div><div><h4>Tambah Pelanggan</h4><p>Pendaftaran baru</p></div></a>
      <a class="actbtn" href="{{ route('admin.tagihan.index') }}"><div class="ic"><i data-lucide="printer"></i></div><div><h4>Cetak Kwitansi</h4><p>Lewat menu Tagihan</p></div></a>
      <a class="actbtn" href="{{ route('admin.laporan.index') }}"><div class="ic"><i data-lucide="bar-chart-3"></i></div><div><h4>Laporan</h4><p>Keuangan</p></div></a>
    </div>
  </div>
</div>

@push('scripts')
<script>
(function(){
  if (typeof Chart === 'undefined') return;
  Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
  Chart.defaults.color = '#6b7280';

  // --- Grafik Pendapatan (batang + garis target) ---
  var cv = document.getElementById('chartPendapatan');
  if (cv) {
    var ctx = cv.getContext('2d');
    var grad = ctx.createLinearGradient(0, 0, 0, 280);
    grad.addColorStop(0, 'rgba(13,148,136,.95)');
    grad.addColorStop(1, 'rgba(13,148,136,.35)');
    new Chart(ctx, {
      data: {
        labels: ['Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt'],
        datasets: [
          {
            type: 'bar', label: 'Pendapatan',
            data: [95, 110, 125, 105, 135, 142],
            backgroundColor: grad, borderRadius: 8, maxBarThickness: 38, order: 2
          },
          {
            type: 'line', label: 'Target',
            data: [100, 110, 120, 120, 130, 140],
            borderColor: '#f59e0b', borderWidth: 2, borderDash: [6, 5],
            pointRadius: 0, tension: .35, order: 1
          }
        ]
      },
      options: {
        responsive: true, maintainAspectRatio: false,
        plugins: {
          legend: { display: true, position: 'bottom', labels: { boxWidth: 12, usePointStyle: true } },
          tooltip: { callbacks: { label: function (c) { return c.dataset.label + ': Rp ' + c.parsed.y + ' jt'; } } }
        },
        scales: {
          y: { beginAtZero: true, grid: { color: '#eef2f5' }, ticks: { callback: function (v) { return v + ' jt'; } } },
          x: { grid: { display: false } }
        }
      }
    });
  }

  // --- Grafik Status Pembayaran (donat) ---
  var cd = document.getElementById('chartStatus');
  if (cd) {
    new Chart(cd, {
      type: 'doughnut',
      data: {
        labels: ['Lunas', 'Belum Bayar', 'Terlambat'],
        datasets: [{
          data: [{{ $kpi['lunas'] }}, {{ $kpi['belum_bayar'] }}, {{ $kpi['terlambat'] }}],
          backgroundColor: ['#16a34a', '#f59e0b', '#ef4444'],
          borderWidth: 0, hoverOffset: 6
        }]
      },
      options: {
        responsive: true, maintainAspectRatio: false, cutout: '64%',
        plugins: { legend: { display: false } }
      }
    });
  }
})();
</script>
@endpush
@endsection
