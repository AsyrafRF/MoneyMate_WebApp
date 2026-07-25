{{-- Modal Konfirmasi Hapus Akun (static) --}}
<div class="modal fade" id="hapusAkunModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="hapusAkunModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="hapusAkunModalLabel">
                    <i class="fa-solid fa-user-xmark"></i>
                    Konfirmasi Hapus Akun
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-center text-muted">
                    Masukkan password Anda untuk mengonfirmasi penghapusan akun.
                </p>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="alert alert-warning small">
                    <i class="bi bi-info-circle"></i> Semua data akan terhapus permanen dan tidak dapat
                    dikembalikan.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Hapus Akun</button>
            </div>
        </form>
    </div>
</div>
