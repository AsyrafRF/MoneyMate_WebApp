<!-- Modal Preview Bukti -->
<div class="modal fade" id="previewBuktiModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow">
      <div class="modal-header modal-header-gradient text-white border-0">
        <h5 class="modal-title">
          <i class="bi bi-image"></i>
          Pratinjau Bukti
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <img id="previewBuktiImage" src="" alt="Pratinjau Bukti" class="img-fluid rounded shadow">
      </div>
    </div>
  </div>
</div>

<!-- Script untuk ganti gambar di modal preview -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  const previewModal = document.getElementById('previewBuktiModal');
  const previewImage = document.getElementById('previewBuktiImage');

  previewModal.addEventListener('show.bs.modal', function (event) {
    const trigger = event.relatedTarget;
    const imageSrc = trigger.getAttribute('data-bukti');
    previewImage.src = imageSrc;
  });
});
</script>