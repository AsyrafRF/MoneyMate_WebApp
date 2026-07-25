<!-- resources\views\layouts\home.blade.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoneyMate | @yield('title')</title>

    <!-- Icon untuk Browser (Favicon) -->
    <!-- Icon Standar Modern (Pengganti shortcut icon) -->
    <link rel="icon" type="image/png" href="{{ asset('icons/pwa-32x32.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ asset('icons/pwa-192x192.png') }}" sizes="192x192">
    <link rel="icon" type="image/png" href="{{ asset('icons/pwa-512x512.png') }}" sizes="512x512">

    <!-- Icon untuk iOS (Apple Touch Icon / Safari Shortcut) -->
    <!-- Apple Touch Icon untuk Shortcut Home Screen iOS -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icons/pwa-180x180.png') }}">
    <!-- Opsional: Menghindari efek kilau otomatis dari iOS lama -->
    <link rel="apple-touch-icon-precomposed" href="{{ asset('images/moneymate-original-notext.png') }}">

    <!-- Icon untuk Android Chrome & Windows Mobile -->
    <meta name="mobile-web-app-capable" content="yes">
    <!-- Agar web bisa berjalan fullscreen saat dibuka dari Home Screen iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="MoneyMate">

    <!-- Kontrol Status Bar iOS (Opsional, gunakan 'default' atau 'black-translucent') -->
    <meta name="apple-mobile-web-app-status-bar-style" content="default">

    <!-- Standar Modern: Mengubah warna bar browser di Android & iOS Safari Baru -->
    <meta name="theme-color" content="#1B94D7">
    <link rel="manifest" href="/build/manifest.webmanifest">
    
    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js']) 

    <!-- Stylesheets -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/home/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home/footer.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home/navbar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home/components/feedback.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home/beranda/premium-price.css') }}" rel="stylesheet">

    <!-- AOS Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- init js -->
    <script src="{{ asset('js/init.js') }}"></script>
    @stack('styles')
    @livewireStyles
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark custom-navbar sticky-top">
        <div class="container">
            <!-- Logo & Brand -->
            <a class="navbar-brand d-flex align-items-center" href="https://web.moneymate.id/">
                <img src="{{ asset('images/moneymate-white.png') }}" alt="Logo" class="logo me-2">
            </a>

            <!-- Hamburger -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-3"> <!-- ganti mx-auto jadi ms-3 -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('beranda') ? 'active' : '' }}"
                            href="{{ route('beranda') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tentang') ? 'active' : '' }}"
                            href="{{ route('tentang') }}">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('informasi') ? 'active' : '' }}"
                            href="{{ route('informasi') }}">Informasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('kontak') ? 'active' : '' }}"
                            href="{{ route('kontak') }}">Kontak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="https://blog.moneymate.id" 
                            target="_blank">Blog</a>
                    </li>
                </ul>

                <!-- tombol auth tetap di kanan -->
                <div class="d-flex ms-auto">
                    @auth
                        {{-- Jika user sudah login --}}
                        <a href="{{ url('/dashboard') }}" class="btn-auth btn-filled">
                            Dasbor
                        </a>
                    @else
                        {{-- Jika user belum login --}}
                        <a href="#" class="btn-auth btn-outline" data-bs-toggle="modal" data-bs-target="#loginModal">
                            Masuk
                        </a>
                        <a href="#" class="btn-auth btn-filled ms-2" data-bs-toggle="modal" data-bs-target="#registerModal">
                            Daftar Akun
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="footer-custom text-white pt-5">
        <div class="container">
            <div class="row">
                <!-- Kolom 1 -->
                <div class="col-md-3 mb-4">
                    <h5 class="footer-title">Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="/kontak">Kontak Kami</a></li>
                        <li><a href="https://support.moneymate.id/">Pusat Bantuan</a></li>
                        <li><a href="{{ route('premium.upgrade') }}">Daftar Harga</a></li>
                    </ul>
                    <div class="footer-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <p class="footer-desc">Akses cepat ke Dukungan Pelanggan.</p>
                </div>

                <!-- Kolom 2 -->
                <div class="col-md-3 mb-4">
                    <h5 class="footer-title">Developer</h5>
                    <ul class="list-unstyled">
                        <li><a href="/tentang">Tentang Kami</a></li>
                        <li><a href="https://moneymate.id/">Profile</a></li>
                        <li><a href="https://blog.moneymate.id/">Blog</a></li>
                    </ul>
                    <div class="footer-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <p class="footer-desc">Kenali lebih dekat perjalanan dan tim kami.</p>
                </div>

                <!-- Kolom 3 -->
                <div class="col-md-3 mb-4">
                    <h5 class="footer-title">Legal</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('legal.privacy') }}">Kebijakan Privasi</a></li>
                        <li><a href="{{ route('legal.terms') }}">Syarat & Ketentuan</a></li>
                        <li><a href="{{ route('legal.agreement') }}">EULA</a></li>
                    </ul>
                    <div class="footer-icon">
                        <i class="fas fa-balance-scale"></i>
                    </div>
                    <p class="footer-desc">Transparansi untuk keamanan & kenyamanan Anda.</p>
                </div>

                <!-- Kolom Kontak -->
                <div class="col-md-3 mb-4">
                    <h5 class="footer-title d-flex align-items-center">
                        <img src="{{ asset('images/moneymate-original.png') }}" alt="MoneyMate Logo" class="footer-logo me-2">
                        MoneyMate
                    </h5>
                    <p class="small">
                        Jl. Ahmad Yani, Tlk. Tering, Kec. Batam Kota<br>
                        Batam, Kepulauan Riau - Indonesia<br>
                        Telp: +62 813 65931021<br>
                        Email: support@moneymate.id
                    </p>
                    <div class="social-icons mt-2">
                        <a href="https://www.instagram.com/moneymate_id/" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://x.com/moneymateid" target="_blank"><i class="bi bi-twitter-x"></i></a>
                        <a href="https://discord.gg/Z9YxgFEVtG" target="_blank"><i class="fab fa-discord"></i></a>
                        <a href="https://github.com/MoneyMate-ID/MoneyMate_WebApp" target="_blank"><i class="fab fa-github"></i></a>
                        <a href="https://www.youtube.com/@MoneyMateOfficial-id" target="_blank"><i class="bi bi-youtube"></i></a>
                        <a href="https://www.tiktok.com/@moneymate.id" target="_blank"><i class="fa-brands fa-tiktok"></i></a>
                    </div>
                </div>
            </div>

            <hr class="footer-line">

            <!-- Bawah -->
            <div class="text-center small mt-3">
                <p>&copy; {{ date('Y') }} <strong>MoneyMate ID</strong>. Kelola keuangan & anggaran pribadi Anda.</p>
                <p>Didukung oleh <a href="https://www.polibatam.ac.id/" target="_blank"><span class="text-accent">Polibatam</span></a> & <span class="text-accent">PBL-TRPL621</span></p>
            </div>
        </div>
    </footer>

    <x-loading-overlay />
    <x-register-modal />
    <x-login-modal />
    <x-feedback-modal :show="session('show_feedback')" />
    @livewireScripts
    @stack('scripts')

    <script src="{{ asset('js/main.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
    </script>
</body>

</html>