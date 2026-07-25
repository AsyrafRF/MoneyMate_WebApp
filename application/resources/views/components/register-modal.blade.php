{{-- =============== MODAL REGISTER =============== --}}
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-4">

                <div class="text-center mb-3">
                    <img src="{{ asset('images/moneymate-original.png') }}" alt="MoneyMate Logo" style="width: 70px;">
                </div>

                <h4 class="text-center mb-4">Daftar Akun Baru</h4>

                <form action="{{ route('register.post') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="register_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="register_email" name="email" autocomplete="email" required>
                    </div>

                    {{-- PASSWORD --}}
                    <div class="mb-3 position-relative">
                        <label for="register_password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="register_password" name="password" required>
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
                        <small id="strengthText" class="small text-muted"></small>
                    </div>

                    {{-- KONFIRMASI PASSWORD --}}
                    <div class="mb-3 position-relative">
                        <label for="register_password_confirmation" class="form-label">Konfirmasi Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="register_password_confirmation" name="password_confirmation" required>
                            <button type="button" class="btn btn-outline-secondary" id="toggleConfirmPassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <small id="matchMessage" class="text-danger"></small>
                    </div>

                    <button type="submit" class="btn btn-primary bg-btn-gradient w-100 mb-2">Daftar</button>
                </form>

                <p class="text-center my-2">atau</p>

                <a href="{{ route('login.google') }}" 
                    id="loadingBtn" 
                    class="btn btn-outline-secondary w-100">
                    <img src="https://www.google.com/favicon.ico" alt="Google Logo" class="me-2" style="height: 1.25rem;">
                    Daftar dengan Google
                </a>

                <div class="text-center mt-3">
                    <p class="small">
                        Sudah punya akun?
                        <a href="#" class="text-primary fw-bold" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">
                            Masuk
                        </a>
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/button-loading.js') }}"></script>