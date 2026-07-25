@extends('layouts.guest')

@section('title', '419')

@section('content')
    <div class="text-center">
        <div id="lottie-error" style="width:200px; margin:auto;"></div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.9.6/lottie.min.js"></script>
        <script>
        lottie.loadAnimation({
            container: document.getElementById('lottie-error'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: '/lottie/404.json'
        });
        </script>
        <p class="text-muted mb-3">Halaman Kadaluwarsa</p>

        <p class="small text-muted">
            Halaman ini sudah tidak aktif karena sudah lama tidak digunakan. Jangan khawatir, silakan klik tombol di bawah untuk melanjutkan aktivitas Anda.
        </p>

        <button onclick="location.reload()" class="btn btn-secondary text-white">
            <i class="bi bi-arrow-clockwise"></i> Segarkan Halaman
        </button>

        <div class="d-flex justify-content-center gap-2 mt-4">
            <!-- Back -->
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>

            <!-- Home -->
            <a href="{{ route('beranda') }}" class="btn btn-primary">
                <i class="bi bi-house"></i> Ke Beranda
            </a>
        </div>
    </div>
@endsection