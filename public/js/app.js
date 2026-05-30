/* ============ DesaTirta — app.js (versi Laravel / multipage) ============
   Berisi hanya logika tampilan: grafik batang, modal, toast, toggle metode
   pembayaran, dan pencarian pengumuman. Routing & data sekarang ditangani
   Laravel (Blade + database), jadi tidak ada lagi array data atau fungsi go().
*/

/* ---------- TOAST ---------- */
var _t;
function toast(msg) {
  var t = document.getElementById('toast');
  if (!t || !msg) return;
  t.textContent = msg;
  t.classList.add('show');
  clearTimeout(_t);
  _t = setTimeout(function () { t.classList.remove('show'); }, 2800);
}

/* ---------- MODAL ---------- */
function closeModal(id) {
  var el = document.getElementById(id);
  if (el) el.classList.remove('open');
}
// klik area gelap menutup modal
document.addEventListener('click', function (e) {
  if (e.target.classList && (e.target.classList.contains('modal-bg') || e.target.classList.contains('cmodal-bg'))) {
    e.target.classList.remove('open');
  }
});

/* ---------- TOGGLE METODE PEMBAYARAN ---------- */
function selPay(m) {
  var qris = document.getElementById('pm-qris');
  var bank = document.getElementById('pm-bank');
  var qv = document.getElementById('qris-view');
  var bv = document.getElementById('bank-view');
  if (qris) qris.classList.toggle('sel', m === 'qris');
  if (bank) bank.classList.toggle('sel', m === 'bank');
  if (qv) qv.classList.toggle('hidden', m !== 'qris');
  if (bv) bv.classList.toggle('hidden', m === 'qris');
}

/* ---------- PENCARIAN PENGUMUMAN ---------- */
function filterPengumuman() {
  var input = document.getElementById('search-pengumuman');
  if (!input) return;
  var q = input.value.toLowerCase();
  document.querySelectorAll('.ann-item').forEach(function (item) {
    item.style.display = item.textContent.toLowerCase().indexOf(q) >= 0 ? '' : 'none';
  });
}

/* ---------- GRAFIK BATANG ---------- */
function showTrendTip(el) { var t = el.querySelector('.bar-tip'); if (t) t.style.display = 'block'; }
function hideTrendTip(el) { var t = el.querySelector('.bar-tip'); if (t) t.style.display = 'none'; }

// Grafik sederhana (dashboard pengguna): elemen dengan data-values="30,45,..."
function drawSimpleBars(el) {
  var vals = (el.dataset.values || '').split(',').map(Number).filter(function (n) { return !isNaN(n); });
  if (!vals.length) return;
  var max = Math.max.apply(null, vals);
  el.innerHTML = vals.map(function (v) {
    return '<div style="flex:1"><div class="bar" style="height:' + Math.round(v / max * 100) + '%"></div></div>';
  }).join('');
}

// Grafik dengan tooltip (admin): data-values, data-labels, data-unit
function drawTipBars(el) {
  var vals = (el.dataset.values || '').split(',').map(Number).filter(function (n) { return !isNaN(n); });
  if (!vals.length) return;
  var labels = (el.dataset.labels || '').split(',');
  var unit = el.dataset.unit || '';
  var max = Math.max.apply(null, vals);
  el.innerHTML = vals.map(function (v, i) {
    var pale = (i === vals.length - 1) ? '' : ' pale';
    var label = labels[i] || ('#' + (i + 1));
    return '<div class="trend-col" onmouseenter="showTrendTip(this)" onmouseleave="hideTrendTip(this)">' +
      '<div class="bar-tip">' + label + ': ' + v + unit + '</div>' +
      '<div class="bar' + pale + '" style="height:' + Math.round(v / max * 100) + '%;width:100%"></div>' +
      '</div>';
  }).join('');
}

/* ---------- KONFIRMASI (logout & hapus data) ---------- */
function askConfirm(opts){
  opts = opts || {};
  var m = document.getElementById('confirm-modal');
  if (!m) { if (opts.onConfirm) opts.onConfirm(); return; }
  document.getElementById('confirm-title').textContent = opts.title || 'Konfirmasi';
  document.getElementById('confirm-text').textContent  = opts.text  || 'Apakah Anda yakin?';
  var ic = document.getElementById('confirm-ic');
  if (ic) ic.className = 'cm-ic ' + (opts.icon || 'danger');
  var ok = document.getElementById('confirm-ok');
  ok.textContent = opts.confirmText || 'Ya, Lanjutkan';
  ok.className = 'btn ' + (opts.danger === false ? 'btn-primary' : 'btn-danger');
  ok.onclick = function () { closeConfirm(); if (opts.onConfirm) opts.onConfirm(); };
  m.classList.add('open');
}
function closeConfirm(){
  var m = document.getElementById('confirm-modal');
  if (m) m.classList.remove('open');
}
// keluar akun dengan konfirmasi
function askLogout(){
  askConfirm({
    title: 'Keluar dari Akun?',
    text: 'Anda akan keluar dari sesi ini dan kembali ke halaman utama.',
    confirmText: 'Ya, Keluar', icon: 'warn',
    onConfirm: function () {
      var f = document.getElementById('logout-form') || document.getElementById('admin-logout-form');
      if (f) f.submit();
    }
  });
}
// hapus data: submit form tertentu setelah dikonfirmasi
function confirmDelete(formId, nama){
  askConfirm({
    title: 'Hapus Data?',
    text: 'Data "' + (nama || '') + '" akan dihapus permanen dan tidak bisa dikembalikan.',
    confirmText: 'Ya, Hapus', icon: 'danger',
    onConfirm: function () {
      var f = document.getElementById(formId);
      if (f) f.submit();
    }
  });
}

/* ---------- INIT ---------- */
document.addEventListener('DOMContentLoaded', function () {
  // tampilkan toast bila ada flash message dari server
  var t = document.getElementById('toast');
  if (t && t.dataset.msg) toast(t.dataset.msg);

  // gambar semua grafik yang ada di halaman
  var simple = document.getElementById('dash-bars');
  if (simple) drawSimpleBars(simple);

  document.querySelectorAll('#adm-bars').forEach(drawTipBars);
});
