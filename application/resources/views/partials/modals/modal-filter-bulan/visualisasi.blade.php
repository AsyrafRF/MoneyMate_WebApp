<!-- Modal Filter Bulanan (Visualisasi / Laporan) -->
<div class="modal fade" id="modalFilterBulanan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <div class="modal-header bg-general-gradient text-white">
        <h5 class="modal-title">
          <i class="bi bi-calendar2-range"></i> Pilih Bulan
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form id="formFilterBulanan" action="{{ route('keuangan.laporan') }}" method="GET">
        <div class="modal-body">

            <!-- mode FIXED ke bulanan -->
            <input type="hidden" name="mode" value="bulanan">

            <!-- Input bulan -->
            <label class="form-label fw-semibold" for="inputMonth">Pilih Bulan</label>
            <input type="month" id="inputMonth" class="form-control" value="{{ now()->format('Y-m') }}" required>

            <!-- Hidden untuk periode (Y-m-d) -->
            <input type="hidden" name="periode" id="periodeHidden">

        </div>

        <div class="modal-footer">
          <button class="btn btn-primary bg-btn-gradient w-100 text-white fw-bold">
            Tampilkan Grafik
          </button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- Script untuk mengkonversi month → periode -->
<script>
document.getElementById('formFilterBulanan').addEventListener('submit', function(event) {
    const monthValue = document.getElementById('inputMonth').value; // YYYY-MM
    if (monthValue) {
        document.getElementById('periodeHidden').value = monthValue + '-01'; // → YYYY-MM-01
    }
});
</script>