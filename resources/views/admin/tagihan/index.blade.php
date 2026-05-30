@extends('layouts.admin')
@section('title', 'Kelola Tagihan — Admin')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.5rem">
  <div><nav class="crumb">Dashboard / Tagihan</nav><h1 style="font-size:1.5rem">Kelola Tagihan</h1></div>
  <div style="display:flex;gap:.5rem;flex-wrap:wrap">
    <button class="btn btn-outline-teal" onclick="document.getElementById('modal-tagihan-manual').classList.add('open')">📝 Tagihan Manual</button>
    <button class="btn btn-primary" onclick="document.getElementById('modal-generate-tagihan').classList.add('open')">⚡ Generate Tagihan</button>
  </div>
</div>
<div class="kpis">
  <div class="kpi"><div class="cap">TOTAL TAGIHAN</div><div class="n">{{ $stat['total'] }}</div></div>
  <div class="kpi"><div class="cap">SUDAH DIBAYAR</div><div class="n" style="color:var(--green-600)">{{ $stat['lunas'] }}</div></div>
  <div class="kpi"><div class="cap">BELUM BAYAR</div><div class="n" style="color:var(--amber)">{{ $stat['belum'] }}</div></div>
  <div class="kpi"><div class="cap">TERLAMBAT</div><div class="n" style="color:var(--red)">{{ $stat['terlambat'] }}</div></div>
</div>
<div class="panel">
  <table class="atable">
    <thead><tr><th>No. Tagihan</th><th>Pelanggan</th><th>Pemakaian</th><th>Tagihan</th><th>Jatuh Tempo</th><th>Status</th><th>Kwitansi</th></tr></thead>
    <tbody>
      @forelse($tagihans as $t)
        <tr>
          <td>{{ $t->no_tagihan }}</td>
          <td>{{ $t->pelanggan->nama ?? '-' }}</td>
          <td>{{ $t->pemakaian }} m³</td>
          <td>Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
          <td>{{ $t->jatuh_tempo }}</td>
          <td>
            <form action="{{ route('admin.tagihan.status', $t) }}" method="POST">
              @csrf @method('PUT')
              <select name="status" onchange="this.form.submit()" style="font-size:.75rem;padding:.25rem .4rem;border-radius:.3rem;border:1px solid var(--gray-300)">
                @foreach(['Belum Bayar','Lunas','Terlambat'] as $s)
                  <option value="{{ $s }}" @selected($t->status === $s)>{{ $s }}</option>
                @endforeach
              </select>
            </form>
          </td>
          <td>
            <a class="btn btn-outline-teal" href="{{ route('admin.kwitansi.cetak', $t) }}" target="_blank"
               style="padding:.35rem .7rem;font-size:.74rem;gap:.35rem" title="Cetak kwitansi">
              <i data-lucide="printer" style="width:14px;height:14px"></i> Cetak
            </a>
          </td>
        </tr>
      @empty
        <tr><td colspan="7" style="text-align:center;color:var(--gray-500);padding:1.5rem">Belum ada tagihan.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

{{-- Modal Generate Tagihan --}}
<div class="modal-bg" id="modal-generate-tagihan">
  <div class="modal" style="max-width:26rem">
    <div class="modal-head"><div class="x" onclick="closeModal('modal-generate-tagihan')">✕</div><h2>Generate Tagihan</h2><p style="opacity:.88">Buat tagihan massal untuk semua pelanggan</p></div>
    <form method="POST" action="{{ route('admin.tagihan.generate') }}">
      @csrf
      <div class="modal-body">
        <div class="field"><label>Periode Tagihan *</label>
          <select name="periode" required>
            <option value="">Pilih periode</option>
            <option>November 2024</option>
            <option>Desember 2024</option>
            <option>Januari 2025</option>
          </select>
        </div>
        <p style="font-size:.8rem;color:var(--gray-500);margin-top:.75rem">Tagihan akan digenerate untuk semua pelanggan aktif dengan tarif sesuai desa masing-masing.</p>
      </div>
      <div class="modal-foot">
        <button type="button" class="btn btn-outline-teal" onclick="closeModal('modal-generate-tagihan')">Batal</button>
        <button type="submit" class="btn btn-primary">⚡ Generate</button>
      </div>
    </form>
  </div>
</div>

{{-- Modal Tagihan Manual --}}
<div class="modal-bg" id="modal-tagihan-manual">
  <div class="modal" style="max-width:28rem">
    <div class="modal-head"><div class="x" onclick="closeModal('modal-tagihan-manual')">✕</div><h2>Tagihan Manual</h2><p style="opacity:.88">Input tagihan untuk satu pelanggan</p></div>
    <form method="POST" action="{{ route('admin.tagihan.store') }}">
      @csrf
      <div class="modal-body">
        <div class="field"><label>Pelanggan *</label>
          <select name="pelanggan_id" required>
            <option value="">Pilih pelanggan</option>
            @foreach($pelanggans as $p)
              <option value="{{ $p->id }}">{{ $p->nama }} (Desa {{ $p->desa->nama }})</option>
            @endforeach
          </select>
        </div>
        <div class="field" style="margin-top:1rem"><label>Pemakaian (m³) *</label><input name="pemakaian" type="number" min="0" step="0.1" placeholder="Contoh: 25.5" required></div>
        <div class="field" style="margin-top:1rem"><label>Jatuh Tempo *</label><input name="jatuh_tempo" placeholder="Contoh: 20 Nov 2024" required></div>
      </div>
      <div class="modal-foot">
        <button type="button" class="btn btn-outline-teal" onclick="closeModal('modal-tagihan-manual')">Batal</button>
        <button type="submit" class="btn btn-primary">💾 Tambah Tagihan</button>
      </div>
    </form>
  </div>
</div>
@endsection
