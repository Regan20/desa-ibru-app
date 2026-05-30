@extends('layouts.admin')
@section('title', 'Pengaturan — Admin')

@section('content')
<nav class="crumb">Dashboard / Pengaturan</nav>
<h1 style="font-size:1.5rem">Pengaturan</h1>

<div class="set-grid">
  <div class="set-nav">
    <div class="si on" data-pane="profil" onclick="setTab('profil', this)"><i data-lucide="user"></i> Profil Akun</div>
    <div class="si" data-pane="keamanan" onclick="setTab('keamanan', this)"><i data-lucide="shield"></i> Keamanan</div>
    <div class="si" data-pane="notifikasi" onclick="setTab('notifikasi', this)"><i data-lucide="bell"></i> Notifikasi</div>
  </div>

  <div>
    {{-- ===== PROFIL AKUN ===== --}}
    <div class="set-pane on" id="pane-profil">
      <div class="panel">
        <div style="display:flex;gap:1rem;align-items:center;margin-bottom:1.25rem">
          <div class="set-avatar">{{ strtoupper(substr($admin->name, 0, 1)) }}</div>
          <div>
            <h3 style="font-size:1.15rem">{{ $admin->name }}</h3>
            <p style="font-size:.8rem;color:var(--gray-500)">{{ '@' . $admin->username }} · <span class="badge badge-teal">{{ ucfirst($admin->role) }}</span></p>
          </div>
        </div>
        <p style="font-size:.75rem;color:var(--gray-500);margin-bottom:1rem">Informasi akun admin yang sedang login (data dari database).</p>
        <div class="grid-2">
          <div class="field"><label>Nama Lengkap</label>
            <div class="input-ic"><i data-lucide="user"></i><input value="{{ $admin->name }}" readonly></div>
          </div>
          <div class="field"><label>Username</label>
            <div class="input-ic"><i data-lucide="at-sign"></i><input value="{{ $admin->username }}" readonly></div>
          </div>
        </div>
        <div class="grid-2" style="margin-top:1rem">
          <div class="field"><label>Email</label>
            <div class="input-ic"><i data-lucide="mail"></i><input value="{{ $admin->email ?? '-' }}" readonly></div>
          </div>
          <div class="field"><label>Role</label>
            <div class="input-ic"><i data-lucide="shield"></i><input value="{{ ucfirst($admin->role) }}" readonly></div>
          </div>
        </div>
        <div class="divider"></div>
        <div class="grid-2">
          <div class="row"><span class="lbl">Terdaftar Sejak</span><b>{{ $admin->created_at->translatedFormat('d M Y') }}</b></div>
          <div class="row"><span class="lbl">Status</span><span class="badge badge-green">Aktif</span></div>
        </div>
      </div>
    </div>

    {{-- ===== KEAMANAN ===== --}}
    <div class="set-pane" id="pane-keamanan">
      <div class="panel" style="max-width:34rem">
        <h3>Ubah Kata Sandi</h3>
        <p style="font-size:.75rem;color:var(--gray-500);margin-bottom:1rem">Gunakan kata sandi yang kuat dan tidak dipakai di tempat lain.</p>
        @if ($errors->any())
          <div class="info-box" style="margin-bottom:1rem;background:#fee2e2;border-color:#fecaca">
            <i data-lucide="alert-circle" style="width:16px;height:16px;flex:none;color:#b91c1c"></i>
            <span style="color:#b91c1c">{{ $errors->first() }}</span>
          </div>
        @endif
        <form method="POST" action="{{ route('admin.pengaturan.password') }}">
          @csrf @method('PUT')
          <div class="field"><label>Kata Sandi Saat Ini *</label>
            <div class="input-ic"><i data-lucide="lock"></i><input type="password" name="current_password" placeholder="••••••••" required></div>
          </div>
          <div class="field" style="margin-top:1rem"><label>Kata Sandi Baru *</label>
            <div class="input-ic"><i data-lucide="key-round"></i><input type="password" name="password" placeholder="Minimal 6 karakter" required></div>
          </div>
          <div class="field" style="margin-top:1rem"><label>Konfirmasi Kata Sandi Baru *</label>
            <div class="input-ic"><i data-lucide="key-round"></i><input type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru" required></div>
          </div>
          <button type="submit" class="btn btn-primary" style="margin-top:1.25rem">
            <i data-lucide="save" style="width:16px;height:16px"></i> Simpan Kata Sandi
          </button>
        </form>
      </div>
    </div>

    {{-- ===== NOTIFIKASI ===== --}}
    <div class="set-pane" id="pane-notifikasi">
      <div class="panel" style="max-width:38rem">
        <h3>Preferensi Notifikasi</h3>
        <p style="font-size:.75rem;color:var(--gray-500);margin-bottom:.5rem">Atur jenis notifikasi yang ingin Anda terima.</p>
        <div class="notif-pref">
          <div style="flex:1"><b style="font-size:.88rem">Tagihan Baru</b><p style="font-size:.74rem;color:var(--gray-500)">Pemberitahuan saat tagihan baru dibuat.</p></div>
          <label class="toggle-switch"><input type="checkbox" checked onchange="notifToast()"><span class="slider-btn"></span></label>
        </div>
        <div class="notif-pref">
          <div style="flex:1"><b style="font-size:.88rem">Pembayaran Masuk</b><p style="font-size:.74rem;color:var(--gray-500)">Saat ada pembayaran yang perlu diverifikasi.</p></div>
          <label class="toggle-switch"><input type="checkbox" checked onchange="notifToast()"><span class="slider-btn"></span></label>
        </div>
        <div class="notif-pref">
          <div style="flex:1"><b style="font-size:.88rem">Pengaduan Baru</b><p style="font-size:.74rem;color:var(--gray-500)">Saat warga mengirim pengaduan baru.</p></div>
          <label class="toggle-switch"><input type="checkbox" checked onchange="notifToast()"><span class="slider-btn"></span></label>
        </div>
        <div class="notif-pref" style="border-bottom:none">
          <div style="flex:1"><b style="font-size:.88rem">Ringkasan Email Mingguan</b><p style="font-size:.74rem;color:var(--gray-500)">Laporan ringkas tiap minggu via email.</p></div>
          <label class="toggle-switch"><input type="checkbox" onchange="notifToast()"><span class="slider-btn"></span></label>
        </div>
        <p class="hint" style="margin-top:1rem">Catatan: preferensi ini bersifat tampilan untuk demo dan belum disimpan ke server.</p>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  function setTab(name, el){
    document.querySelectorAll('.set-pane').forEach(function (p) { p.classList.remove('on'); });
    document.querySelectorAll('.set-nav .si').forEach(function (s) { s.classList.remove('on'); });
    var pane = document.getElementById('pane-' + name);
    if (pane) pane.classList.add('on');
    if (el) el.classList.add('on');
  }
  function notifToast(){ if (typeof toast === 'function') toast('Preferensi notifikasi diperbarui'); }
  @if ($errors->any())
    document.addEventListener('DOMContentLoaded', function () {
      setTab('keamanan', document.querySelector('.set-nav .si[data-pane="keamanan"]'));
    });
  @endif
</script>
@endpush
@endsection
