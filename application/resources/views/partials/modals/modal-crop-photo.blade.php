{{-- Modal Potong Foto --}}
<div class="modal fade" id="cropModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="cropModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-header-gradient text-white">
                <h5 class="modal-title" id="cropModalLabel"><i class="bi bi-crop"></i> Potong Foto Profil</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="preview" src="#" alt="Preview Gambar" style="max-width: 100%; border-radius: 10px;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="cropButton" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>