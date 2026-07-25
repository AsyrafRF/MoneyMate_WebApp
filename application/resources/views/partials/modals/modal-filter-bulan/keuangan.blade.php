<!-- Modal Filter Bulanan (Riwayat) -->
<div class="modal fade" id="modalFilterBulanan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <div class="modal-header bg-general-gradient text-white">
        <h5 class="modal-title">
          <i class="bi bi-calendar2-range"></i> Pilih Bulan
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form action="{{ route('keuangan.index') }}" method="GET">
        <div class="modal-body">

            <input type="hidden" name="filter" value="monthly">

            <label class="form-label fw-semibold" for="inputMonth">Pilih Bulan</label>
            <input type="month" id="inputMonth" name="month" class="form-control" value="{{ now()->format('Y-m') }}" required>

        </div>
        <div class="modal-footer">
          <button class="btn btn-primary bg-btn-gradient w-100 text-white fw-bold">
            Tampilkan Riwayat
          </button>
        </div>
      </form>

    </div>
  </div>
</div>