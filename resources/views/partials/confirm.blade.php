{{-- Modal konfirmasi serbaguna (dipakai untuk logout & hapus data) --}}
<div class="cmodal-bg" id="confirm-modal">
  <div class="cmodal">
    <div class="cm-body">
      <div class="cm-ic danger" id="confirm-ic"><i data-lucide="alert-triangle"></i></div>
      <h3 id="confirm-title">Konfirmasi</h3>
      <p id="confirm-text">Apakah Anda yakin?</p>
    </div>
    <div class="cm-foot">
      <button type="button" class="btn btn-outline-teal" onclick="closeConfirm()">Batal</button>
      <button type="button" class="btn btn-danger" id="confirm-ok">Ya, Lanjutkan</button>
    </div>
  </div>
</div>
