<x-guest-layout>
    <div class="mb-4 text-muted text-center animate__animated animate__fadeInDown" data-aos="fade-down">
        {{ __('Harap konfirmasi kata sandi lama Anda sebelum mengganti kata sandi baru.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm.change') }}" 
          class="animate__animated animate__fadeInUp" 
          data-aos="zoom-in">
        @csrf

        <!-- Password -->
        <div class="mb-4 text-start">
            <label for="password" class="form-label fw-semibold">
                <i class="bi bi-lock-fill me-1 text-primary"></i> {{ __('Kata Sandi') }}
            </label>

            <input 
                id="password" 
                type="password" 
                name="password" 
                required 
                autocomplete="current-password"
                class="form-control form-control-lg shadow-sm"
                placeholder="Masukkan kata sandi anda saat ini..."
            >

            @error('password')
                <div class="text-danger small mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-center gap-2">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary px-4 py-2">
                <i class="bi bi-x-circle me-1"></i> {{ __('Batal') }}
            </a>

            <button type="submit" class="btn btn-primary px-4 py-2">
                <i class="bi bi-check-circle me-1"></i> {{ __('Konfirmasi') }}
            </button>
        </div>
    </form>
</x-guest-layout>
