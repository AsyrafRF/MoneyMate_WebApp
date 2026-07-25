<x-guest-layout>
    <div class="mb-4 text-muted" data-aos="fade-down">
        {{ __('Lupa kata sandi? Tidak masalah. Cukup beri tahu kami alamat email Anda, dan kami akan mengirimkan tautan pengaturan ulang kata sandi melalui email agar Anda dapat memilih kata sandi baru.') }}
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="animate__animated animate__fadeInUp" data-aos="zoom-in">
        @csrf

        <!-- Email Address -->
        <div class="mb-3 text-start">
            <label for="email" class="form-label fw-semibold">{{ __('Email') }}</label>
            <input 
                id="email" 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                required 
                autofocus 
                class="form-control form-control-lg shadow-sm"
                placeholder="Masukkan alamat email Anda"
            >
            @error('email')
                <div class="text-danger small mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-center mt-4">
            <button type="submit" class="btn btn-primary px-4 py-2">
                <i class="bi bi-envelope-fill me-1"></i> 
                {{ __('Kirim Tautan Reset Password') }}
            </button>
        </div>
    </form>
</x-guest-layout>
