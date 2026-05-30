@extends('layouts.app')
@section('title', 'Dashboard — Desa Ibru')

@section('content')
<div class="page gray"><div class="container">
  <div class="card">
    <div class="profile">
      <img src="{{ asset('assets/avatar-arman.jpg') }}" alt="{{ $user->name }}">
      <div>
        <h2 style="font-size:1.25rem">{{ $user->name }}</h2>
        <p style="color:var(--gray-600)">No. ID: {{ $pelanggan->kode ?? '-' }}</p>
      </div>
    </div>
    <div style="display:flex;gap:.5rem;align-items:center;font-size:.875rem;color:var(--gray-600)">📍 Desa {{ $pelanggan->desa->nama ?? 'Ibru' }} Kecamatan Mestong</div>
  </div>

  <div class="dash-grid">
    <div class="card">
      <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1rem">
        <div><h3>Statistik Penggunaan</h3><p style="font-size:.85rem;color:var(--gray-600)">Pantau penggunaan air Anda bulan ini.</p></div>
        <div class="stat-chip"><div class="n">Rp {{ number_format($tagihan->jumlah ?? 0, 0, ',', '.') }}</div><div style="font-size:.7rem">per Bulan</div></div>
      </div>
      <div class="chart-box"><canvas id="chartUsage"></canvas></div>
    </div>
    <div>
      @if($tagihan && $tagihan->status !== 'Lunas')
        <a class="qa" href="{{ route('tagihan.cek') }}" style="cursor:pointer"><div class="ic ic-blue">📄</div><div><h4>Tagihan Anda <span class="badge badge-redfill">{{ $tagihan->status }}</span></h4><p>Bayar/Cek Tagihan</p></div></a>
      @else
        <a class="qa" href="{{ route('tagihan.cek') }}" style="cursor:pointer"><div class="ic ic-green">📄</div><div><h4>Tagihan Anda <span class="badge badge-green">Lunas</span></h4><p>Cek Tagihan</p></div></a>
      @endif
      <div class="qa"><div class="ic ic-teal">💧</div><div><h4>Periksa Pipa</h4><p>Mengecek Keluhan pada Pipa</p></div></div>
      <div class="qa"><div class="ic ic-green">🔔</div><div><h4>Status Pembayaran</h4><p>Riwayat &amp; notifikasi pembayaran Anda.</p></div></div>
      <a class="btn btn-primary btn-block" style="margin-top:1rem;padding:.9rem" href="{{ route('pengaduan.index') }}">Kirimkan Pengaduan</a>
    </div>
  </div>

  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem"><h3>Berita Terkini Desa</h3><a style="color:var(--teal);font-size:.875rem;cursor:pointer" href="{{ route('pengumuman.index') }}">Lihat Selengkapnya →</a></div>
  <div class="grid-3">
    @foreach($berita as $b)
      <div class="news-card">
        <img src="{{ $b->gambar ? asset($b->gambar) : asset('assets/news-instalasi.png') }}" alt="{{ $b->judul }}">
        <div class="body">
          <h4>{{ $b->judul }}</h4>
          <p style="font-size:.85rem;color:var(--gray-600)">{{ \Illuminate\Support\Str::limit($b->isi, 90) }}</p>
          <div style="display:flex;justify-content:space-between;margin-top:.6rem">
            <span class="date">{{ $b->tanggal }}</span>
            <a style="color:var(--teal);font-size:.8rem;cursor:pointer" href="{{ route('pengumuman.show', $b) }}">Baca →</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div></div>

@push('scripts')
<script>
(function(){
  if (typeof Chart === 'undefined') return;
  Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
  Chart.defaults.color = '#6b7280';
  var cv = document.getElementById('chartUsage');
  if (!cv) return;
  var ctx = cv.getContext('2d');
  var grad = ctx.createLinearGradient(0, 0, 0, 240);
  grad.addColorStop(0, 'rgba(13,148,136,.35)');
  grad.addColorStop(1, 'rgba(13,148,136,0)');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul'],
      datasets: [{
        label: 'Pemakaian (m³)',
        data: [12, 15, 14, 18, 16, 21, 19],
        borderColor: '#0d9488', borderWidth: 3,
        backgroundColor: grad, fill: true, tension: .4,
        pointBackgroundColor: '#0d9488', pointRadius: 4, pointHoverRadius: 6
      }]
    },
    options: {
      responsive: true, maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: { callbacks: { label: function (c) { return c.parsed.y + ' m³'; } } }
      },
      scales: {
        y: { beginAtZero: true, grid: { color: '#eef2f5' }, ticks: { callback: function (v) { return v + ' m³'; } } },
        x: { grid: { display: false } }
      }
    }
  });
})();
</script>
@endpush
@endsection
