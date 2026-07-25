{{-- =============== MODAL LOGIN =============== --}}
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-4">

                <div class="text-center mb-3">
                    <img src="{{ asset('images/moneymate-original.png') }}" alt="MoneyMate Logo" style="width: 70px;">
                </div>

                <h4 class="text-center mb-4">Masuk ke Akun</h4>

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="login_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="login_email" name="email" autocomplete="email" required>
                    </div>

                    <div class="mb-3 position-relative">
                        <label for="login_password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="login_password" name="password" required>
                            <button type="button" class="btn btn-outline-secondary" id="toggleLoginPassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary bg-btn-gradient w-100 mb-3">Masuk</button>
                </form>

                <p class="text-center my-2">atau</p>

                <livewire:google />

                <div class="text-center mt-3">
                    {{-- AWAL KODE DROPDOWN BARU --}}
                    <div class="dropdown d-inline-block mt-2">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Tidak bisa login?
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('password.request') }}">
                                    Lupa Password
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">
                                    Daftar Akun Baru
                                </a>
                            </li>
                        </ul>
                    </div>
                    {{-- AKHIR KODE DROPDOWN BARU --}}

                </div>

            </div>
        </div>
    </div>
</div>