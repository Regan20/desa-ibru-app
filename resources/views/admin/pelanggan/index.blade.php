@extends('layouts.admin')
@section('title', 'Kelola Pelanggan — Admin')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.5rem">
  <div><nav class="crumb">Dashboard / Pelanggan</nav><h1 style="font-size:1.5rem">Kelola Pelanggan</h1></div>
  <button class="btn btn-primary" onclick="openPelangganCreate()">+ Tambah Pelanggan</button>
</div>
<div class="kpis">
  <div class="kpi"><div class="cap">TOTAL</div><div class="n">{{ $stat['total'] }}</div></div>
  <div class="kpi"><div class="cap">AKTIF</div><div class="n" style="color:var(--teal)">{{ $stat['aktif'] }}</div></div>
  <div class="kpi"><div class="cap">NONAKTIF</div><div class="n">{{ $stat['nonaktif'] }}</div></div>
  <div class="kpi"><div class="cap">TUNGGAKAN</div><div class="n" style="color:var(--red)">{{ $stat['tunggakan'] }}</div></div>
</div>
<div class="panel">
  <table class="atable">
    <thead><tr><th>ID Pelanggan</th><th>Nama</th><th>Wilayah</th><th>Kategori</th><th>Pemakaian</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
      @forelse($pelanggans as $p)
        @php
          $inits = collect(explode(' ', $p->nama))->take(2)->map(fn($w) => substr($w,0,1))->implode('');
          $sc = $p->status === 'Aktif' ? 'badge-green' : ($p->status === 'Tunggakan' ? 'badge-orange' : 'badge-red');
          $editData = ['id' => $p->id, 'kode' => $p->kode, 'nama' => $p->nama, 'desa_id' => $p->desa_id, 'wilayah' => $p->wilayah, 'kategori' => $p->kategori, 'hp' => $p->hp, 'status' => $p->status];
        @endphp
        <tr>
          <td>{{ $p->kode }}</td>
          <td><span class="miniava" style="background:var(--teal)">{{ strtoupper($inits) }}</span>{{ $p->nama }}</td>
          <td>{{ $p->wilayah }}</td>
          <td><span class="badge badge-blue">{{ $p->kategori }}</span></td>
          <td>{{ $p->pemakaian }} m³</td>
          <td><span class="badge {{ $sc }}">{{ $p->status }}</span></td>
          <td>
            <span class="iconbtn" title="Edit"
                  onclick='openPelangganEdit(@json($editData))'><i data-lucide="pencil" style="width:15px;height:15px"></i></span>
            <form id="del-pelanggan-{{ $p->id }}" action="{{ route('admin.pelanggan.destroy', $p) }}" method="POST" style="display:inline">
              @csrf @method('DELETE')
              <button type="button" class="iconbtn" style="color:var(--red)" title="Hapus"
                      data-nama="{{ $p->nama }}"
                      onclick="confirmDelete('del-pelanggan-{{ $p->id }}', this.dataset.nama)">
                <i data-lucide="trash-2" style="width:15px;height:15px"></i>
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="7" style="text-align:center;color:var(--gray-500);padding:1.5rem">Belum ada pelanggan.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

{{-- Modal Tambah/Edit Pelanggan --}}
<div class="modal-bg" id="modal-pelanggan">
  <div class="modal">
    <div class="modal-head modal-head-lg">
      <div class="x" onclick="closeModal('modal-pelanggan')">✕</div>
      <div class="mh-ic"><i data-lucide="user-plus"></i></div>
      <h2 id="modal-pelanggan-title">Tambah Pelanggan Baru</h2>
      <p id="modal-pelanggan-sub">Lengkapi data pelanggan layanan air bersih</p>
    </div>
    <form id="form-pelanggan" method="POST" action="{{ route('admin.pelanggan.store') }}">
      @csrf
      <input type="hidden" name="_method" id="fp-method" value="POST">
      <div class="modal-body">
        <div class="form-section"><i data-lucide="id-card" style="width:14px;height:14px"></i> Identitas Pelanggan</div>
        <div class="grid-2">
          <div class="field"><label>Nama Lengkap *</label>
            <div class="input-ic"><i data-lucide="user"></i><input name="nama" id="fp-nama" placeholder="Contoh: Budi Santoso" required></div>
          </div>
          <div class="field"><label>ID Pelanggan *</label>
            <div class="input-ic"><i data-lucide="hash"></i><input name="kode" id="fp-kode" placeholder="IBR-2024-006" required></div>
            <span class="hint">Format: IBR-TAHUN-xxx (lanjutkan dari kode terakhir)</span>
          </div>
        </div>

        <div class="form-section" style="margin-top:1.3rem"><i data-lucide="map-pin" style="width:14px;height:14px"></i> Lokasi &amp; Kategori</div>
        <div class="grid-2">
          <div class="field"><label>Desa *</label>
            <div class="input-ic"><i data-lucide="map-pin"></i>
              <select name="desa_id" id="fp-desa">
                @foreach($desas as $d)
                  <option value="{{ $d->id }}">{{ $d->nama }} (Rp {{ number_format($d->tarif_per_m3, 0, ',', '.') }}/m³)</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="field"><label>Wilayah / Dusun</label>
            <div class="input-ic"><i data-lucide="map"></i><input name="wilayah" id="fp-wilayah" placeholder="Contoh: Dusun Tengah"></div>
          </div>
        </div>
        <div class="grid-2" style="margin-top:1rem">
          <div class="field"><label>Kategori</label>
            <div class="input-ic"><i data-lucide="tag"></i>
              <select name="kategori" id="fp-kategori"><option>Rumah Tangga</option><option>Usaha Kecil</option><option>Sosial</option></select>
            </div>
          </div>
          <div class="field"><label>No. HP</label>
            <div class="input-ic"><i data-lucide="phone"></i><input name="hp" id="fp-hp" placeholder="0812-xxxx-xxxx"></div>
          </div>
        </div>

        <div class="form-section" style="margin-top:1.3rem"><i data-lucide="activity" style="width:14px;height:14px"></i> Status Keanggotaan</div>
        <div class="field">
          <div class="input-ic"><i data-lucide="badge-check"></i>
            <select name="status" id="fp-status"><option>Aktif</option><option>Nonaktif</option><option>Tunggakan</option></select>
          </div>
        </div>
      </div>
      <div class="modal-foot">
        <button type="button" class="btn btn-outline-teal" onclick="closeModal('modal-pelanggan')">Batal</button>
        <button type="submit" class="btn btn-primary"><i data-lucide="save" style="width:16px;height:16px"></i> Simpan Pelanggan</button>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
  var fp = document.getElementById('form-pelanggan');
  var storeUrl = "{{ route('admin.pelanggan.store') }}";
  function openPelangganCreate(){
    document.getElementById('modal-pelanggan-title').textContent = 'Tambah Pelanggan Baru';
    document.getElementById('modal-pelanggan-sub').textContent = 'Lengkapi data pelanggan layanan air bersih';
    fp.action = storeUrl;
    document.getElementById('fp-method').value = 'POST';
    fp.reset();
    document.getElementById('modal-pelanggan').classList.add('open');
  }
  function openPelangganEdit(data){
    document.getElementById('modal-pelanggan-title').textContent = 'Edit Data Pelanggan';
    document.getElementById('modal-pelanggan-sub').textContent = 'Perbarui informasi pelanggan ' + (data.nama || '');
    fp.action = storeUrl.replace(/\/pelanggan$/, '/pelanggan/') + data.id;
    document.getElementById('fp-method').value = 'PUT';
    document.getElementById('fp-nama').value = data.nama || '';
    document.getElementById('fp-kode').value = data.kode || '';
    document.getElementById('fp-desa').value = data.desa_id || '';
    document.getElementById('fp-wilayah').value = data.wilayah || '';
    document.getElementById('fp-kategori').value = data.kategori || 'Rumah Tangga';
    document.getElementById('fp-hp').value = data.hp || '';
    document.getElementById('fp-status').value = data.status || 'Aktif';
    document.getElementById('modal-pelanggan').classList.add('open');
  }
</script>
@endpush
@endsection
