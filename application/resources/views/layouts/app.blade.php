<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="user-id" content="{{ auth()->id() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="vapid-public-key" content="{{ config('services.vapid.public_key') }}">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-SEME808CZ1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-SEME808CZ1');
    </script>

    <!-- PWA -->
    <link rel="manifest" href="/build/manifest.webmanifest">
    <meta name="theme-color" content="#1B94D7">

    <title>@yield('title', $title ?? 'WebApp') - MoneyMate</title>

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Framework CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        
    <!-- Icon Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/@coreui/icons/css/all.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/app/app-layout.css?v=3') }}" rel="stylesheet">
    <link href="{{ asset('css/app/premium/profile-badge.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app/components/tom-select.css') }}" rel="stylesheet">
    
    
    <!-- Plugin CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">
    
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css">
    
    <!-- Lottie Player -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

    <!-- Tom Select -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
        
    @stack('styles')
    @livewireStyles
</head>

<body>
    <div class="app-container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <a href="/" class="logo-link">
                    <img src="{{ asset('images/moneymate-white.png') }}" alt="MoneyMate Logo" class="logo-image">
                </a>
            </div>
            
            <nav class="sidebar-nav">
                <div class="sidebar-title">
                    <i class="bi bi-grid-1x2-fill me-2 text-blue"></i>
                    <span>Menu</span>
                    <div class="sidebar-title-line"></div>
                </div>
                
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}" 
                           href="{{ route('dashboard.index') }}">
                            <img src="{{ asset('images/icon-dashboard.png') }}" alt="Pencatatan Icon">
                            <span>Dasbor</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('keuangan.index') ? 'active' : '' }}" 
                           href="{{ route('keuangan.index') }}">
                            <img src="{{ asset('images/icon-pencatatan-keuangan.png') }}" alt="Pencatatan Icon">
                            <span>Catatan Keuangan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('anggaran.index') ? 'active' : '' }}" 
                           href="{{ route('anggaran.index') }}">
                            <img src="{{ asset('images/icon-pengelolaan-anggaran.png') }}" alt="Anggaran Icon">
                            <span>Kelola Anggaran</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tujuan.index') ? 'active' : '' }}" 
                           href="{{ route('tujuan.index') }}">
                            <img src="{{ asset('images/icon-tujuan-finansial.png') }}" alt="Tujuan Icon">
                            <span>Tujuan Finansial</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('keuangan.laporan') ? 'active' : '' }}" 
                           href="{{ route('keuangan.laporan') }}">
                            <img src="{{ asset('images/icon-visualisasi-data.png') }}" alt="Visualisasi Icon">
                            <span>Visualisasi Laporan</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="px-3 mb-3">
                @if(Auth::user()->is_premium)
                    <div class="premium-status-card bg-gradient-primary p-2 rounded-3 text-white">
                        <div class="d-flex align-items-center small">
                            <i class="bi bi-patch-check-fill me-2"></i>
                            <div>
                                <div class="fw-bold">Premium {{ ucfirst(Auth::user()->subscription_plan) }}</div>
                                <div style="font-size: 10px; opacity: 0.8;">Sisa {{ Auth::user()->subscription_days_left }} Hari</div>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('premium.upgrade') }}" class="btn btn-sm btn-outline-primary w-100 py-2">
                        <i class="bi bi-lightning-charge-fill"></i> Upgrade Premium
                    </a>
                @endif
            </div>
            
            <div class="sidebar-footer">
                <p class="copyright">&copy; {{ date('Y') }} MoneyMate</p>
                <p class="version">Version 2.6.0</p>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Header -->
            <header class="app-header d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
                <h2 class="mb-0 fw-semibold">@yield('title', $title ?? 'MoneyMate Web')</h2>
                
                <div class="header-actions">
                    <!-- Notifications -->
                    <livewire:unread-notification-count :key="auth()->id()" />

                    <!-- User Profile -->
                    @auth
                    <div class="profile-dropdown">
                        <a href="#" 
                            class="profile-link position-relative d-inline-block"
                            data-bs-toggle="dropdown">

                            <!-- Avatar -->
                            <div class="profile-wrapper">
                                <img src="{{ Auth::user()->photo_url }}" 
                                    alt="Profile" 
                                    class="profile-avatar">
                            </div>

                            <!-- Premium Badge -->
                            @if(Auth::user()->is_premium)
                                <span class="premium-badge" data-bs-toggle="tooltip" title="Premium User">
                                    <i class="bi bi-gem"></i>
                                </span>
                            @endif

                        </a>

                        <div class="dropdown-menu dropdown-menu-end">
                            <div class="profile-info text-center">
                                <div class="position-relative d-inline-block">
                                    <img src="{{ Auth::user()->photo_url }}" alt="Profile" class="profile-picture">
                                    @if(Auth::user()->is_premium)
                                        <i class="bi bi-patch-check-fill text-primary position-absolute bottom-0 end-0 bg-white rounded-circle" style="font-size: 1.2rem;"></i>
                                    @endif
                                </div>                              
                                @if(Auth::user()->is_premium)
                                    <h6 class="mt-2">Hai, <span class="username-highlight">{{ Auth::user()->name }}</span></h6>
                                    <span class="badge bg-light text-primary border border-primary mb-2">Member Premium💎</span>
                                @else
                                    <h6 class="mt-2">Hai, {{ Auth::user()->name }}</h6>
                                    <p class="small text-muted">Paket Dasar📦</p>
                                @endif
                            </div>

                            <div class="profile-actions">
                                <a href="{{ route('profile.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-person-circle me-2"></i> Profil
                                </a>
                                <a href="{{ route('premium.history') }}" class="btn btn-outline-primary">
                                    <i class="bi bi-credit-card me-2"></i> Riwayat Premium
                                </a>
                                <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="d-grid">
                                    @csrf
                                    <button type="button" class="logout-button" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endauth
                </div>
            </header>

            <!-- Page Content -->
            <section class="content-area">
                @yield('content')

                {{ $slot ?? '' }} {{-- Tambahkan ini agar Livewire Full-page Component bisa muncul --}}
            </section>
        </main>
    </div>

    <!-- Mobile Navigation -->
    <nav class="mobile-nav">
        <a href="{{ route('keuangan.index') }}" 
           class="{{ request()->routeIs('keuangan.index') ? 'active' : '' }}">
            <i class="bi bi-journal-text"></i>
            <span>Pencatatan</span>
        </a>
        <a href="{{ route('anggaran.index') }}" 
           class="{{ request()->routeIs('anggaran.index') ? 'active' : '' }}">
            <i class="bi bi-wallet2"></i>
            <span>Anggaran</span>
        </a>

        <div class="mobile-nav-center-wrapper">
            <a href="{{ route('dashboard.index') }}" 
            class="nav-center {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                <div class="icon-box">
                    <i class="bi bi-house-door-fill"></i>
                </div>
                <span>Dashboard</span>
            </a>
        </div>

        <a href="{{ route('tujuan.index') }}" 
           class="{{ request()->routeIs('tujuan.index') ? 'active' : '' }}">
            <i class="bi bi-bullseye"></i>
            <span>Tujuan</span>
        </a>
        <a href="{{ route('keuangan.laporan') }}" 
           class="{{ request()->routeIs('keuangan.laporan') ? 'active' : '' }}">
            <i class="bi bi-graph-up"></i>
            <span>Laporan</span>
        </a>
    </nav>

    <!-- Modal Components -->
    <!-- Notification Popup Modal -->
    <div class="modal fade" id="popupNotif" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div id="popupAnimation"></div>
                    <h5 id="popupMessage"></h5>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.partials.modals.auth')

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/plugins/monthSelect/index.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/loadingtombolhandler.js') }}"></script>
    <script src="{{ asset('js/app/modals_queue.js') }}"></script>

    <script>
        window.userId = {{ auth()->id() }};
    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {

        // Popup session notifications
        @if (session('success'))
            showPopup("success", "{{ session('success') }}");
        @endif
        @if (session('warning'))
            showPopup("warning", "{{ session('warning') }}");
        @endif
        @if (session('error'))
            showPopup("error", `{!! session('error') !!}`);
        @endif
        @if (session('alert'))
            alertPopup("alert", `{!! session('alert') !!}`);
        @endif

        // Popup function (temp)
        function showPopup(type, message) {
            const animationUrls = {
                success: "https://assets9.lottiefiles.com/packages/lf20_jbrw3hcz.json",
                warning: "https://lottie.host/0fa01ca4-0702-4bcd-a6e1-c72e85047d67/QkMDyxsMB5.json",
                error: "https://lottie.host/8fd91a51-0ab6-4abb-a3e4-65f4f3974298/kerKvJmu1C.json"
            };
            document.getElementById("popupAnimation").innerHTML = `
                <lottie-player src="${animationUrls[type]}" background="transparent" speed="1" style="width:150px;height:150px;margin:auto;" autoplay></lottie-player>
            `;
            document.getElementById("popupMessage").innerHTML = message;
            const popup = new bootstrap.Modal(document.getElementById("popupNotif"));
            popup.show();
            setTimeout(() => popup.hide(), 2000);
        }

        // Popup function (no timeout)
        function alertPopup(type, message) {
            const animationUrls = {
                alert: "https://lottie.host/0fa01ca4-0702-4bcd-a6e1-c72e85047d67/QkMDyxsMB5.json",
            };
            document.getElementById("popupAnimation").innerHTML = `
                <lottie-player src="${animationUrls[type]}" background="transparent" speed="1" style="width:150px;height:150px;margin:auto;" autoplay></lottie-player>
            `;
            document.getElementById("popupMessage").innerHTML = message;
            modalQueue.show('popupNotif');
        }
    });
    </script>

    @include('layouts.partials.scripts.auth') {{-- Logika Logout & CSRF --}}
    @include('layouts.partials.scripts.notif-toast') {{-- InPage Toast Notification --}}

    @stack('scripts')
    @livewireScripts
    <x-loading-overlay />
    @livewire('notification-modal-global')
    <script src="{{ asset('js/app/notif_modal.js') }}"></script>

</body>
</html>