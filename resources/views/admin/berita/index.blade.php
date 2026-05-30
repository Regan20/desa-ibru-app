@extends('layouts.admin')
@section('title', 'Kelola Berita — Admin')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.5rem">
  <div><nav class="crumb">Dashboard / Berita</nav><h1 style="font-size:1.5rem">Kelola Berita &amp; Pengumuman</h1></div>
  <button class="btn btn-primary" onclick="openBeritaCreate()">+ Buat Pengumuman</button>
</div>
<div class="kpis" style="grid-template-columns:repeat(3,1fr)">
  <div class="kpi"><div class="cap">TOTAL BERITA</div><div class="n">{{ $stat['total'] }}</div></div>
  <div class="kpi"><div class="cap">DIPUBLIKASI</div><div class="n" style="color:var(--teal)">{{ $stat['dipublikasi'] }}</div></div>
  <div class="kpi"><div class="cap">DRAFT</div><div class="n" style="color:var(--amber)">{{ $stat['draft'] }}</div></div>
</div>
<div class="panel">
  <table class="atable">
    <thead><tr><th>Judul Berita</th><th>Tanggal</th><th>Status</th><th>Views</th><th>Aksi</th></tr></thead>
    <tbody>
      @forelse($beritas as $b)
        @php
          $sc = $b->status === 'Dipublikasi' ? 'badge-green' : 'badge-yellow';
          $editData = ['id' => $b->id, 'judul' => $b->judul, 'sub' => $b->sub, 'kategori' => $b->kategori, 'status' => $b->status, 'isi' => $b->isi, 'gambar' => $b->gambar];
        @endphp
        <tr>
          <td>{{ $b->judul }}</td>
          <td>{{ $b->tanggal }}</td>
          <td><span class="badge {{ $sc }}">{{ $b->status }}</span></td>
          <td>{{ $b->views }}</td>
          <td>
            <span class="iconbtn" title="Edit"
                  onclick='openBeritaEdit(@json($editData))'><i data-lucide="pencil" style="width:15px;height:15px"></i></span>
            <form id="del-berita-{{ $b->id }}" action="{{ route('admin.berita.destroy', $b) }}" method="POST" style="display:inline">
              @csrf @method('DELETE')
              <button type="button" class="iconbtn" style="color:var(--red)" title="Hapus"
                      data-nama="{{ $b->judul }}"
                      onclick="confirmDelete('del-berita-{{ $b->id }}', this.dataset.nama)">
                <i data-lucide="trash-2" style="width:15px;height:15px"></i>
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="5" style="text-align:center;color:var(--gray-500);padding:1.5rem">Belum ada berita.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

{{-- Modal Berita --}}
<div class="modal-bg" id="modal-berita">
  <div class="modal" style="max-width:48rem">
    <div class="modal-head modal-head-lg">
      <div class="x" onclick="closeModal('modal-berita')">✕</div>
      <div class="mh-ic"><i data-lucide="newspaper"></i></div>
      <h2 id="modal-berita-title">Buat Pengumuman Baru</h2>
      <p>Tulis berita atau pengumuman layanan air untuk warga</p>
    </div>
    <form id="form-berita" method="POST" action="{{ route('admin.berita.store') }}" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="_method" id="fb-method" value="POST">
      <div class="modal-body">
        <div class="berita-grid">
          <div>
            <div class="field"><label>Judul *</label>
              <div class="input-ic"><i data-lucide="type"></i><input name="judul" id="fb-judul" placeholder="Contoh: Pemeliharaan Jaringan Pipa Zona A" required></div>
            </div>
            <div class="field" style="margin-top:1rem"><label>Ringkasan Singkat</label>
              <div class="input-ic"><i data-lucide="text"></i><input name="sub" id="fb-sub" placeholder="Kalimat ringkas di bawah judul"></div>
            </div>
            <div class="grid-2" style="margin-top:1rem">
              <div class="field"><label>Kategori</label>
                <div class="input-ic"><i data-lucide="folder"></i>
                  <select name="kategori" id="fb-kategori"><option>Info</option><option>Pemeliharaan</option><option>Penting</option><option>Kegiatan</option></select>
                </div>
              </div>
              <div class="field"><label>Status</label>
                <div class="input-ic"><i data-lucide="eye"></i>
                  <select name="status" id="fb-status"><option value="Draft">Draft</option><option value="Dipublikasi">Dipublikasi</option></select>
                </div>
              </div>
            </div>
            <div class="field" style="margin-top:1rem"><label>Isi Berita</label>
              <textarea name="isi" id="fb-isi" rows="7" placeholder="Tulis isi lengkap berita atau pengumuman di sini..."></textarea>
            </div>
          </div>
          <div>
            <label style="display:block;font-size:.875rem;color:var(--gray-700);margin-bottom:.5rem;font-weight:500">Gambar / Poster</label>
            <label for="fb-gambar" class="img-drop" id="fb-drop">
              <img id="fb-preview" class="hidden" alt="Pratinjau gambar">
              <div class="img-drop-ph" id="fb-drop-ph">
                <i data-lucide="image-plus"></i>
                <span>Klik untuk unggah gambar</span>
                <small>JPG, PNG, atau WEBP — maks 2MB</small>
              </div>
            </label>
            <input type="file" id="fb-gambar" name="gambar" accept="image/jpeg,image/png,image/webp" class="hidden" onchange="previewBerita(this)">
            <span class="hint" id="fb-current"></span>
            <div class="info-box info-teal" style="margin-top:.8rem;font-size:.74rem">
              <i data-lucide="info" style="width:16px;height:16px;flex:none"></i>
              <span>Gambar tampil di kartu berita halaman Pengumuman. Disarankan rasio 16:9.</span>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-foot">
        <button type="button" class="btn btn-outline-teal" onclick="closeModal('modal-berita')">Batal</button>
        <button type="submit" class="btn btn-primary"><i data-lucide="save" style="width:16px;height:16px"></i> Simpan Berita</button>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
  var fb = document.getElementById('form-berita');
  var beritaStore = "{{ route('admin.berita.store') }}";
  var assetBase = "{{ asset('') }}";

  function previewBerita(input){
    var img = document.getElementById('fb-preview');
    var ph  = document.getElementById('fb-drop-ph');
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e){
        img.src = e.target.result;
        img.classList.remove('hidden');
        ph.classList.add('hidden');
      };
      reader.readAsDataURL(input.files[0]);
    }
  }
  function resetBeritaImage(){
    var img = document.getElementById('fb-preview');
    var ph  = document.getElementById('fb-drop-ph');
    img.src = '';
    img.classList.add('hidden');
    ph.classList.remove('hidden');
    document.getElementById('fb-current').textContent = '';
    document.getElementById('fb-gambar').value = '';
  }
  function openBeritaCreate(){
    document.getElementById('modal-berita-title').textContent = 'Buat Pengumuman Baru';
    fb.action = beritaStore;
    document.getElementById('fb-method').value = 'POST';
    fb.reset();
    resetBeritaImage();
    document.getElementById('modal-berita').classList.add('open');
  }
  function openBeritaEdit(data){
    document.getElementById('modal-berita-title').textContent = 'Edit Berita';
    fb.action = beritaStore.replace(/\/berita$/, '/berita/') + data.id;
    document.getElementById('fb-method').value = 'PUT';
    document.getElementById('fb-judul').value = data.judul || '';
    document.getElementById('fb-sub').value = data.sub || '';
    document.getElementById('fb-kategori').value = data.kategori || 'Info';
    document.getElementById('fb-status').value = data.status || 'Draft';
    document.getElementById('fb-isi').value = data.isi || '';
    resetBeritaImage();
    if (data.gambar) {
      var img = document.getElementById('fb-preview');
      var ph  = document.getElementById('fb-drop-ph');
      img.src = assetBase + data.gambar;
      img.classList.remove('hidden');
      ph.classList.add('hidden');
      document.getElementById('fb-current').textContent = 'Gambar saat ini — unggah baru untuk mengganti.';
    }
    document.getElementById('modal-berita').classList.add('open');
  }
</script>
@endpush
@endsection
