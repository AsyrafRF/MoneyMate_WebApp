@extends('layouts.guest')

@section('title', '403')

@section('content')
    <style>
    .btn-gradient {
        background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
        color: white;
        border: none;
        padding: clamp(0.5rem, 1.2vh, 0.65rem) clamp(1rem, 2vw, 1.5rem);
        border-radius: 12px;
        font-size: clamp(0.9rem, 1.3vw, 1rem);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        display: inline-flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
    }
    </style>

    <div class="text-center">
        <div id="lottie-error" style="width:200px; margin:auto;"></div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.9.6/lottie.min.js"></script>
        <script>
        lottie.loadAnimation({
            container: document.getElementById('lottie-error'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: '/lottie/locked.json'
        });
        </script>
        <p class="alert alert-danger mb-3">Anda tidak memiliki akses ke halaman ini.</p>

        <p class="small text-muted">
            😔 Ups… halaman ini cuma bisa diakses oleh pengguna Premium atau Admin ya.<br>
            ✨ Yuk upgrade ke Premium dulu biar bisa lanjut!<br>
            🔐 Kalau kamu admin, langsung login aja pakai akun admin.
        </p>

        <div class="d-flex justify-content-center gap-2 mt-4">
            <!-- login -->
            <a href="{{ route('login') }}" class="btn btn-primary">
                <i class="bi bi-box-arrow-in-right"></i> Login Admin
            </a>

            <!-- upgrade -->
            <a href="{{ route('premium.upgrade') }}" class="btn btn-gradient">
                <i class="bi bi-gem"></i> Upgrade Sekarang
            </a>
        </div>
    </div>
@endsection