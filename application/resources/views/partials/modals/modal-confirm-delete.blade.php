<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="bi bi-trash me-2"></i>
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <p class="mb-0 fs-5">
                    Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="modal-footer border-0 d-flex justify-content-center gap-2">
                {{-- Pembungkus Batal --}}
                <div class="flex-fill">
                    <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal" data-no-overlay="true">
                        Batal
                    </button>
                </div>

                {{-- Pembungkus Form Hapus --}}
                <form id="deleteForm" method="POST" class="flex-fill">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function prepareDelete(actionUrl) {
        // Ambil elemen form di dalam modal
        const form = document.getElementById('deleteForm');
        // Ubah attribute action-nya sesuai route item yang diklik
        form.setAttribute('action', actionUrl);
    }
</script>