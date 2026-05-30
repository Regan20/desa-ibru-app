@extends('layouts.admin')
@section('title', 'Kelola Pengaduan — Admin')

@section('content')
<nav class="crumb">Dashboard / Pengaduan</nav>
<h1 style="font-size:1.5rem">Kelola Pengaduan</h1>
<div class="kpis" style="grid-template-columns:repeat(3,1fr);margin-top:.9rem">
  <div class="kpi"><div class="cap">TOTAL</div><div class="n">{{ $stat['total'] }}</div></div>
  <div class="kpi"><div class="cap">MENUNGGU</div><div class="n" style="color:var(--amber)">{{ $stat['menunggu'] }}</div></div>
  <div class="kpi"><div class="cap">SELESAI</div><div class="n" style="color:var(--green-600)">{{ $stat['selesai'] }}</div></div>
</div>
<div class="panel">
  @forelse($pengaduans as $a)
    <div class="aduan">
      <div style="display:flex;justify-content:space-between;align-items:center">
        <b>{{ $a->kategori }}</b>
        <form action="{{ route('admin.pengaduan.status', $a) }}" method="POST">
          @csrf @method('PUT')
          <select name="status" onchange="this.form.submit()" style="font-size:.75rem;padding:.25rem .5rem;border-radius:.3rem;border:1px solid var(--gray-300)">
            @foreach(['Pending','Proses','Ditanggapi','Selesai'] as $s)
              <option value="{{ $s }}" @selected($a->status === $s)>{{ $s }}</option>
            @endforeach
          </select>
        </form>
      </div>
      <div style="font-size:.78rem;color:var(--gray-500);margin:.25rem 0">{{ $a->kode }} · {{ $a->nama }} · {{ $a->id_pelanggan }} · {{ $a->created_at->diffForHumans() }}</div>
      <p style="font-size:.85rem;color:var(--gray-700)">{{ $a->deskripsi }}</p>
      @foreach($a->balasans as $b)
        <div class="reply"><b style="color:var(--teal-700)">↩ {{ $b->oleh }}</b><p style="margin-top:.3rem">{{ $b->isi }}</p></div>
      @endforeach
      <form action="{{ route('admin.pengaduan.balas', $a) }}" method="POST" style="display:flex;gap:.5rem;margin-top:.75rem;align-items:flex-end">
        @csrf
        <textarea name="isi" rows="2" placeholder="Tulis balasan..." style="flex:1;padding:.5rem;border:1px solid var(--gray-300);border-radius:.4rem;font-size:.8rem;font-family:inherit;resize:vertical;min-height:52px"></textarea>
        <button type="submit" class="btn btn-primary" style="font-size:.78rem;padding:.45rem .8rem">Kirim</button>
      </form>
    </div>
  @empty
    <p style="text-align:center;color:var(--gray-500);padding:1.5rem">Belum ada pengaduan.</p>
  @endforelse
</div>
@endsection
