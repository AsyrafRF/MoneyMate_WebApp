@extends('layouts.app')
@section('title', 'Profil Pengguna')

@section('content')
<div class="content">
    @include('partials.styles.profile.components')

    {{-- Alert --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('google_email_mismatch'))
        @php $mismatch = session('google_email_mismatch'); @endphp
        <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
            ⚠️ Email akun Google Anda (<strong>{{ $mismatch['google_email'] }}</strong>)
            berbeda dengan email utama akun ini (<strong>{{ $mismatch['user_email'] }}</strong>).
            <br>
            <small>Anda tetap bisa login menggunakan Google, tetapi email utama tidak akan diganti.</small>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- ❌ Pesan Error --}}
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
            {!! session('error') !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('confirm'))
            <div class="toast-container position-fixed top-0 end-0 p-3">
                <div id="liveToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">{{ session('confirm') }}</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif

    {{-- Form Profil --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-general-gradient text-white fw-bold">
            <i class="bi bi-person-vcard-fill"></i> Data Profil
        </div>
        <div class="card-body">
            <form action="{{ route('profile.perbarui') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="text-center mb-4">
                    <!-- Foto Profil -->
                    <div class="position-relative d-inline-block">
                        <img src="{{ $user->photo_url }}" 
                            alt="Foto Profil"
                            class="rounded-circle shadow-sm border border-3 border-light"
                            width="120"
                            height="120"
                            style="object-fit: cover;">
                        <!-- Badge Paket -->
                        <div class="mt-2">
                            @if($user->is_premium)
                                <span class="badge rounded-pill px-3 py-2 badge-gradient">
                                    <i class="bi bi-gem me-1"></i>
                                    Member Premium
                                </span>
                            @else
                                <span class="badge rounded-pill px-3 py-2 bg-secondary">
                                    <i class="bi bi-box me-1"></i>
                                    Paket Freemium
                                </span>
                            @endif
                        </div>
                    </div>
                    <!-- Tombol Upload -->
                    <div class="mt-3">
                        <label for="profile_photo" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                            <i class="bi bi-camera me-1"></i>
                            Ubah Foto
                        </label>
                        <input 
                            type="file"
                            id="profile_photo"
                            name="profile_photo"
                            class="d-none"
                            accept="image/*">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" value="{{ $user->email }}" disabled title="Hubungi admin untuk mengubah email">
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah Saldo</label>
                    <input type="text" class="form-control" disabled value="{{ $user->saldo_rupiah }}">
                </div>

                <div class="d-flex justify-content-center mt-3">
                    <button type="submit" class="btn btn-gradient px-4">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Profil Info & Status Premium --}}
    <div class="card shadow-sm mb-4 border-0 overflow-hidden">
        <div class="card-header bg-general-gradient text-white fw-bold py-3">
            <i class="bi bi-shield-check me-2"></i> Detail Informasi & Status Akun
        </div>
        <div class="card-body p-4">
            <div class="row g-4 align-items-center">
                
                {{-- Kolom Kiri: Informasi Integrasi & Email --}}
                <div class="col-md-7 border-end-md">
                    <h5 class="text-secondary fw-semibold mb-3">Integrasi Akun</h5>
                    
                    <!-- Email Utama Card -->
                    <div class="d-flex align-items-center p-3 mb-3 bg-light rounded-3 border-start-gradient shadow-sm">
                        <div class="bg-general-gradient text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="bi bi-envelope-paper-fill fs-5"></i>
                        </div>
                        <div class="flex-grow-1">
                            <small class="text-muted d-block uppercase tracking-wider fw-bold" style="font-size: 0.75rem;">EMAIL UTAMA</small>
                            <span class="text-dark fw-medium">{{ $user->email }}</span>
                        </div>
                    </div>

                    <!-- Google Account Card -->
                    <div class="d-flex align-items-center p-3 bg-light rounded-3 border-start-google shadow-sm">
                        <div class="bg-icon-google text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="bi bi-google fs-5"></i>
                        </div>
                        <div class="flex-grow-1">
                            <small class="text-muted d-block uppercase tracking-wider fw-bold" style="font-size: 0.75rem;">AKUN GOOGLE</small>
                            <span class="text-dark fw-medium">{{ $user->google_email ?? 'Belum tertaut' }}</span>
                        </div>
                        <div>
                            @if($user->google_id)
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                                    <i class="bi bi-check-circle-fill me-1"></i> Terhubung
                                </span>
                            @else
                                <a href="{{ route('login.google') }}" class="btn btn-sm btn-outline-danger px-3 rounded-pill fw-semibold shadow-sm transition-all">
                                    <i class="bi bi-link-45deg me-1"></i> Tautkan
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Status Premium (Donut-style Chart via CSS SVG) --}}
                <div class="col-md-5 text-center">
                    <h5 class="text-secondary fw-semibold mb-3 text-start text-md-center">Status Langganan</h5>
                    
                    @if($user->is_premium)
                        {{-- Hitung persentase durasi jika ada data (asumsi batas max display 30 hari untuk visualisasi ring) --}}
                        @php
                            $daysLeft = $user->subscription_days_left;
                            $maxDays = 30; // Batas referensi lingkaran penuh
                            $percentage = $user->subscription_until ? min(100, max(0, ($daysLeft / $maxDays) * 100)) : 100;
                            $strokeDashoffset = 251.2 - (251.2 * $percentage) / 100;
                        @endphp

                        <div class="position-relative d-inline-flex align-items-center justify-content-center mb-2">
                            <!-- Visual Ring Chart -->
                            <!-- Bungkus dengan DIV yang memutar -->
                            <div class="transform-rotate-minus-90">
                                <svg width="120" height="120">
                                    <defs>
                                        <linearGradient id="ringGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#74b9ff" />
                                            <stop offset="100%" stop-color="#0984e3" />
                                        </linearGradient>
                                    </defs>
                                    <circle cx="60" cy="60" r="40" stroke="#f3f4f6" stroke-width="10" fill="transparent" />
                                    <circle cx="60" cy="60" r="40" stroke="url(#ringGradient)" stroke-width="10" fill="transparent"
                                            stroke-dasharray="251.2" stroke-dashoffset="{{ $strokeDashoffset }}" stroke-linecap="round" />
                                </svg>
                            </div>
                            <!-- Text Tengah Ring -->
                            <div class="position-absolute text-center">
                                <span class="fs-3 fw-bold text-dark block">{{ $user->subscription_until ? $daysLeft : '∞' }}</span>
                                <small class="text-muted d-block" style="font-size: 0.7rem; margin-top: -5px;">{{ $user->subscription_until ? 'Hari Lagi' : 'Aktif' }}</small>
                            </div>
                        </div>

                        <div class="mt-2">
                            <span class="badge bg-general-gradient text-white px-3 py-2 fs-6 fw-bold rounded-pill shadow-sm animate-pulse-custom mb-1">
                                <i class="bi bi-crown-fill me-1"></i> Premium Member
                            </span>
                            @if($user->subscription_plan)
                                <p class="text-muted small mt-1 mb-0">Paket: <strong class="text-dark">{{ ucfirst($user->subscription_plan) }}</strong></p>
                            @endif
                            @if($user->subscription_until)
                                <p class="text-muted style-italic" style="font-size: 0.8rem;">Berlaku hingga: {{ $user->subscription_until->translatedFormat('d F Y') }}</p>
                            @endif
                        </div>
                    @else
                        {{-- Tampilan jika masih Free Tier --}}
                        <div class="p-4 rounded-3 bg-light border border-dashed text-center shadow-inner">
                            <div class="text-muted mb-2">
                                <i class="bi bi-award fs-1 text-secondary opacity-50"></i>
                            </div>
                            <span class="badge bg-secondary px-3 py-2 rounded-pill fw-semibold mb-2">Free Account</span>
                            <p class="text-muted small px-2">Nikmati fitur pencatatan tanpa batas dan analisis cerdas dengan beralih ke Premium.</p>
                            <a href="{{ route('premium.upgrade') }}" class="btn btn-sm btn-warning fw-bold px-4 py-2 rounded-pill shadow-sm w-100 mt-1">
                                <i class="bi bi-lightning-charge-fill me-1"></i> Upgrade Ke Premium
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    {{-- Card Redeem Code --}}
    <div class="card shadow-sm mb-4 border-0 overflow-hidden">
        <div class="card-header bg-general-gradient text-white fw-bold py-3">
            <i class="bi bi-gift-fill me-2"></i> Kode Promo & Redeem
        </div>
        <div class="card-body p-4">
            <p class="text-muted small mb-3">
                Punya kode kupon? Masukkan kode di bawah ini untuk mendapatkan akses Premium gratis atau perpanjangan masa aktif.
            </p>
            
            <form action="{{ route('profile.redeem') }}" method="POST" class="row g-2">
                @csrf
                
                <div class="col-md-8">
                    <input type="text" 
                           name="code" 
                           class="form-control form-control-lg text-uppercase" 
                           placeholder="Masukkan Kode (cth: FREEMONTH)" 
                           required
                           style="letter-spacing: 1px;">
                    @error('code')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4">
                    <button type="submit" class="btn btn-outline-primary w-100 h-100 fw-bold">
                        <i class="bi bi-check-lg me-1"></i> Redeem
                    </button>
                </div>
            </form>
            
            @if(session('success_redeem'))
                <div class="alert alert-success mt-3 mb-0 py-2 small">
                    <i class="bi bi-check-circle-fill me-1"></i> {{ session('success_redeem') }}
                </div>
            @endif
        </div>
    </div>

    {{-- Preferensi Notifikasi --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-general-gradient text-white fw-bold">
            <i class="bi bi-bell-fill"></i> Preferensi Notifikasi
        </div>
        <div class="card-body">
            <!-- 1. Pilihan Notifikasi Browser (Push) -->
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                <div>
                    <h6 class="mb-1 fw-semibold">Notifikasi Browser (Push)</h6>
                    <small class="text-muted">Aktifkan untuk mendapatkan notifikasi transaksi dan pengingat langsung di browser ini.</small>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span id="notif-status" class="badge bg-secondary">Nonaktif</span>
                    <div class="form-check form-switch fs-4 m-0 p-0 ps-5">
                        <input class="form-check-input style-switch-pointer" type="checkbox" id="pushToggle">
                    </div>
                </div>
            </div>

            <!-- 2. Pilihan Langganan Email MoneyMate (Integrasi Database & Brevo) -->
            <form action="{{ route('email.preference.update') }}" method="POST">
                @csrf
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1 fw-semibold">Langganan Email MoneyMate</h6>
                        <small class="text-muted d-block">Dapatkan laporan keuangan bulanan, tips finansial, serta pembaruan info promo akun Anda.</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge {{ $user->is_subscribed ? 'bg-success' : 'bg-danger' }}">
                            {{ $user->is_subscribed ? 'Aktif' : 'Unsubscribed' }}
                        </span>
                        <div class="form-check form-switch fs-4 m-0 p-0 ps-5">
                            <input class="form-check-input style-switch-pointer" type="checkbox" name="is_subscribed" value="1" id="emailToggle" 
                                   {{ $user->is_subscribed ? 'checked' : '' }} onchange="this.form.submit()">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Profil Settings --}}
    <div class="card shadow-sm overflow-hidden">
        <div class="card-header bg-general-gradient text-white fw-bold">
            <i class="bi bi-person-fill-gear"></i>
            Akun & Keamanan
        </div>
        <div class="card-body p-4">
            <!-- Title & Subtitle -->
            <h5 class="fw-bold text-dark mb-1">Keamanan Akun</h5>
            <p class="text-muted small mb-4">Kelola opsi keamanan untuk melindungi akun Anda.</p>
            
            <!-- Menu List -->
            <div class="d-flex flex-column gap-3">
                
                <!-- Item 1: Sesi Login -->
                <a href="{{ route('sesi.index') }}" class="menu-finance-item d-flex align-items-center justify-content-between p-3 rounded-3 text-decoration-none text-dark">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-wrapper bg-info-subtle text-info rounded-3 d-flex align-items-center justify-content-center">
                            <i class="bi bi-sliders fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-semibold mb-0">Atur Sesi Login</h6>
                            <small class="text-muted text-xs">Lihat dan kelola perangkat yang sedang masuk</small>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right text-muted"></i>
                </a>

                <!-- Item 2: Ubah Password -->
                <a href="{{ route('password.confirm.change') }}" class="menu-finance-item d-flex align-items-center justify-content-between p-3 rounded-3 text-decoration-none text-dark">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-wrapper bg-warning-subtle text-warning rounded-3 d-flex align-items-center justify-content-center">
                            <i class="bi bi-shield-lock fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-semibold mb-0">Ubah Password</h6>
                            <small class="text-muted text-xs">Ganti kata sandi Anda secara berkala</small>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right text-muted"></i>
                </a>

                <!-- Item 3: Pengaturan Akun -->
                <button type="button" data-bs-toggle="modal" data-bs-target="#pengaturanModal" class="menu-finance-item w-100 border-0 bg-transparent d-flex align-items-center justify-content-between p-3 rounded-3 text-start text-dark">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-wrapper bg-secondary-subtle text-secondary rounded-3 d-flex align-items-center justify-content-center">
                            <i class="bi bi-gear-fill fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-semibold mb-0">Pengaturan Akun</h6>
                            <small class="text-muted text-xs">Hubungkan Google atau hapus akun Anda</small>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right text-muted"></i>
                </button>

            </div>
        </div>
    </div>

    @include('partials.modals.modal-account-settings')
    @include('partials.modals.modal-confirm-delacc')
    @include('partials.modals.modal-crop-photo')
    @include('partials.modals.modal-change-password')

    @include('partials.scripts.profile.inside')
</div>
@endsection

@push('scripts')
@include('partials.scripts.profile.outside')
@endpush
