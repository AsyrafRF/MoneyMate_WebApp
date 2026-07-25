@extends('layouts.guest')

@section('title', '404')

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
        <p class="text-muted mb-3">Halaman tidak ditemukan</p>

        <p class="small text-muted">
            URL yang kamu akses mungkin salah atau sudah tidak tersedia.
        </p>

        <div class="d-flex justify-content-center gap-2 mt-4">
            <!-- Back -->
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>

            <!-- Home -->
            <a href="{{ route('beranda') }}" class="btn btn-primary">
                <i class="bi bi-house"></i> Ke Home
            </a>
        </div>
    </div>
@endsection