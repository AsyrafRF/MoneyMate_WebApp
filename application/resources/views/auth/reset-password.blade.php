<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}" class="animate__animated animate__fadeInUp" data-aos="zoom-in">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="mb-3 text-start">
            <label for="email" class="form-label fw-semibold">
                <i class="bi bi-envelope-at me-1 text-primary"></i> {{ __('Email') }}
            </label>
            <input 
                id="email" 
                type="email" 
                name="email" 
                value="{{ old('email', $request->email) }}" 
                required 
                autofocus 
                autocomplete="username" 
                class="form-control form-control-lg shadow-sm"
                placeholder="Masukkan alamat email Anda"
            >
            @error('email')
                <div class="text-danger small mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3 text-start">
            <label for="password" class="form-label fw-semibold">
                <i class="bi bi-lock-fill me-1 text-primary"></i> {{ __('Kata Sandi Baru') }}
            </label>
            <div class="input-group input-group-lg">
                <input type="password" class="form-control" id="register_password" name="password" placeholder="Minimal 8 karakter" required>
                <button type="button" class="btn btn-outline-secondary" id="toggleRegisterPassword" title="Lihat Password">
                    <i class="bi bi-eye"></i>
                </button>
            </div>

            {{-- Progress bar strength --}}
            <div class="progress mt-2" style="height: 6px;">
                <div id="passwordStrengthBar" class="progress-bar bg-secondary" style="width: 0%;"></div>
            </div>
            <small id="strengthText" class="text-muted"></small>
            @error('password')
                <div class="text-danger small mt-2">{{ $message }}</div>
            @enderror
        </div>

        <small class="form-text text-muted">
            Minimal 8 karakter, mengandung huruf besar, huruf kecil, angka, dan simbol.
        </small>

        <!-- Confirm Password -->
        <div class="mb-4 text-start">
            <label for="password_confirmation" class="form-label fw-semibold">
                <i class="bi bi-shield-check me-1 text-primary"></i> {{ __('Konfirmasi Kata Sandi') }}
            </label>
            <input 
                id="password_confirmation" 
                type="password" 
                name="password_confirmation" 
                required 
                autocomplete="new-password" 
                class="form-control form-control-lg shadow-sm"
                placeholder="Ulangi kata sandi baru"
            >
            @error('password_confirmation')
                <div class="text-danger small mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary px-4 py-2">
                <i class="bi bi-arrow-repeat me-1"></i> {{ __('Reset Password') }}
            </button>
        </div>
    </form>
</x-guest-layout>
