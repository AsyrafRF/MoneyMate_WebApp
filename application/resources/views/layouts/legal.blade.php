<!-- resources/views/layouts/legal.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- PWA -->
    <link rel="manifest" href="/build/manifest.webmanifest">
    <meta name="theme-color" content="#1B94D7">
    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title', 'Dokumen Hukum') — MoneyMate</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app/onboarding.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/legal/page-nav.css') }}">
    @stack('styles')
</head>
<body>
    <div class="onboarding-wrapper">

        {{-- Header --}}
        <header class="onboarding-header border-bottom">
            <div class="container-fluid d-flex align-items-center py-3">

                <div class="col-4 d-flex justify-content-start">
                    <a href="{{ route('beranda') }}" class="text-decoration-none d-flex align-items-center gap-2 text-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                        </svg>
                        <span class="d-none d-sm-inline fw-medium" style="font-size: 0.875rem;">Beranda</span>
                    </a>
                </div>

                <div class="col-4 text-center">
                    <a href="{{ route('beranda') }}" class="text-decoration-none">
                        <img src="{{ asset('images/moneymate-original.png') }}" alt="MoneyMate" style="height: 40px;">
                    </a>
                </div>

                <div class="col-4 d-flex justify-content-end">
                    <a href="{{ route('dashboard.index') }}" class="btn btn-outline-secondary btn-sm">Masuk</a>
                </div>

            </div>
        </header>

        {{-- Document Navigation --}}
        <nav class="legal-page-nav">
            <div class="container-fluid">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-center gap-1 gap-md-3 py-3">

                    <a href="{{ route('legal.terms') }}"
                       class="legal-nav-link @if(request()->is('legal/syarat-ketentuan*')) active @endif">
                        Syarat &amp; Ketentuan
                    </a>

                    <span class="d-none d-md-block text-secondary" style="font-size: 0.75rem;">•</span>

                    <a href="{{ route('legal.agreement') }}"
                       class="legal-nav-link @if(request()->is('legal/perjanjian-pengguna*')) active @endif">
                        Perjanjian Pengguna
                    </a>

                    <span class="d-none d-md-block text-secondary" style="font-size: 0.75rem;">•</span>

                    <a href="{{ route('legal.privacy') }}"
                       class="legal-nav-link @if(request()->is('legal/kebijakan-privasi*')) active @endif">
                        Kebijakan Privasi
                    </a>

                </div>
            </div>
        </nav>

        {{-- Content --}}
        @yield('content')

        {{-- Footer --}}
        <footer class="legal-page-footer border-top">
            <div class="container-fluid text-center py-3">
                <small class="text-secondary">
                    &copy; {{ date('Y') }} MoneyMate ID. Seluruh hak cipta dilindungi.
                </small>
            </div>
        </footer>

    </div>

    @stack('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var bottomNavs = document.querySelectorAll('.legal-page-bottom-nav');

        if (bottomNavs.length) {
            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.remove('visible');
                    } else {
                        entry.target.classList.add('visible');
                    }
                });
            }, { threshold: 0 });

            bottomNavs.forEach(function (nav) {
                observer.observe(nav);
            });
        }
    });
    </script>
</body>
</html>