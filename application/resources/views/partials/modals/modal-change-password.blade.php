{{-- Modal Form Ganti Password --}}
<div class="modal fade" id="passwordModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" action="{{ route('profile.password') }}" method="POST" id="passwordForm">
            @csrf
            <div class="modal-header modal-header-gradient text-white">
                <h5 class="modal-title" id="passwordModalLabel">Ganti Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                {{-- Password Baru --}}
                <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                        <button type="button" class="btn btn-outline-secondary" id="toggleRegisterPassword">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <small class="form-text text-muted">
                        Minimal 8 karakter, mengandung huruf besar, huruf kecil, angka, dan simbol.
                    </small>
                    <div class="progress mt-2" style="height: 6px;">
                        <div id="passwordStrengthBar" class="progress-bar bg-secondary" style="width: 0%;"></div>
                    </div>
                    <small id="passwordError" class="text-danger"></small>
                </div>

                {{-- Konfirmasi Password --}}
                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="new_password_confirmation"
                            name="new_password_confirmation" required>
                        <button type="button" class="btn btn-outline-secondary" id="toggleConfirmPassword">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <small id="matchMessage" class="text-danger"></small>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" id="savePasswordBtn" disabled>Simpan Password</button>
            </div>
        </form>
    </div>
</div>
