@extends('layouts.app')
@section('title', 'Masuk — Desa Ibru')

@section('content')
<div style="min-height:100vh;background:#E5E9EE;display:grid;place-items:center;padding:2.5rem 1rem">
  <div style="max-width:48rem;width:100%">
    <div style="display:flex;justify-content:center;margin-bottom:1.5rem">
      <div style="background:#fff;border-radius:.75rem;padding:.4rem;box-shadow:var(--shadow);display:inline-flex;gap:.5rem">
        <button type="button" id="tab-user" class="btn" onclick="setRole('user')" style="background:var(--teal);color:#fff">👤 Login Pengguna</button>
        <button type="button" id="tab-admin" class="btn" onclick="setRole('admin')" style="color:var(--gray-600)">🛡️ Login Admin</button>
      </div>
    </div>

    <form method="POST" action="{{ route('login.post') }}" style="display:grid;grid-template-columns:1fr 1fr;background:#fff;border-radius:1.25rem;overflow:hidden;box-shadow:var(--shadow-lg)" class="login-card">
      @csrf
      <div style="background:linear-gradient(150deg,var(--teal-600),var(--teal-800));color:#fff;padding:2.25rem;position:relative;overflow:hidden">
        <span class="pill" style="position:relative">💧 Layanan Digital Desa</span>
        <h2 style="font-size:1.5rem;margin:1rem 0 .75rem" id="aside-title">Desa Ibru</h2>
        <p style="font-size:.9rem;opacity:.9">Akses dashboard Anda untuk melihat tagihan, riwayat pembayaran, dan mengelola layanan air bersih dengan mudah.</p>
      </div>
      <div style="padding:2.25rem">
        <h2 id="login-title" style="font-size:1.3rem">Masuk ke Akun Anda</h2>
        <p style="font-size:.85rem;color:var(--gray-500);margin-bottom:1.25rem">Gunakan username dan password Anda</p>
        @if($errors->any())
          <div style="background:var(--red-100);color:var(--red-700);padding:.6rem .8rem;border-radius:.5rem;font-size:.8rem;margin-bottom:.9rem">{{ $errors->first() }}</div>
        @endif
        <div class="field" style="margin-bottom:.9rem"><label>Username</label><input name="username" id="login-user" value="{{ old('username', 'demo1') }}"></div>
        <div class="field" style="margin-bottom:.9rem"><label>Kata Sandi</label><input name="password" id="login-pass" type="password" value="demo12345"></div>
        <button type="submit" class="btn btn-primary btn-block">➜ Masuk ke Dashboard</button>
        <p id="daftar-link" style="text-align:center;font-size:.85rem;color:var(--gray-500);margin-top:.9rem">Belum punya akun? <a style="color:var(--teal);font-weight:600;cursor:pointer" href="{{ route('register') }}">Daftar sekarang</a></p>
      </div>
    </form>

    <div style="background:#fff;border-radius:.9rem;padding:1.1rem;box-shadow:var(--shadow);margin-top:1rem;font-size:.8rem">
      <b style="color:var(--green)">● Demo Login</b> — gunakan kredensial ini:
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-top:.5rem">
        <div><div style="font-weight:700;color:var(--teal-700);margin-bottom:.25rem">👤 Pengguna</div><div class="row"><span>Username</span><b>demo1</b></div><div class="row"><span>Password</span><b>demo12345</b></div></div>
        <div><div style="font-weight:700;color:var(--teal-700);margin-bottom:.25rem">🛡️ Admin</div><div class="row"><span>Username</span><b>admin.bumdes</b></div><div class="row"><span>Password</span><b>admin123</b></div></div>
      </div>
    </div>
    <div style="text-align:center;margin-top:1rem"><a style="font-size:.85rem;color:var(--gray-500);cursor:pointer" href="{{ route('home') }}">← Kembali ke Beranda</a></div>
  </div>
</div>

@push('scripts')
<script>
  function setRole(r){
    var tu=document.getElementById('tab-user'), ta=document.getElementById('tab-admin');
    tu.style.background = r==='user'?'var(--teal)':'transparent';
    tu.style.color = r==='user'?'#fff':'var(--gray-600)';
    ta.style.background = r==='admin'?'var(--admin-accent)':'transparent';
    ta.style.color = r==='admin'?'#fff':'var(--gray-600)';
    document.getElementById('login-user').value = r==='admin'?'admin.bumdes':'user123';
    document.getElementById('login-pass').value = r==='admin'?'admin123':'password123';
    document.getElementById('login-title').textContent = r==='admin'?'Masuk Panel Admin':'Masuk ke Akun Anda';
    document.getElementById('aside-title').textContent = r==='admin'?'Panel Admin Desa Ibru':'Desa Ibru';
    var d=document.getElementById('daftar-link'); if(d) d.style.display = r==='admin'?'none':'';
  }
</script>
@endpush
@endsection
