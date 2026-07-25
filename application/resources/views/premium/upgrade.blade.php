@extends('layouts.home')

@section('title', 'Pilih Paket')

@push('styles')
<link href="{{ asset('css/home/upgrade/style.css') }}" rel="stylesheet">
<!-- AOS CSS -->
<!-- <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" /> -->
@endpush

@section('content')
<div class="price-page">

    <!-- ===== HERO SECTION ===== -->
    <section class="hero-price">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 text-center">
                    <div class="hero-badge" data-aos="fade-down" data-aos-duration="800">
                        <i class="bi bi-lightning-charge-fill"></i>
                        <span>Fitur Premium Baru Tersedia</span>
                    </div>
                    <h1 class="hero-title" data-aos="fade-up" data-aos-delay="200" data-aos-duration="800">
                        Investasi Kecil,<br>
                        <span class="gradient-text">Kontrol Keuangan Maksimal</span>
                    </h1>
                    <p class="hero-desc" data-aos="fade-up" data-aos-delay="400" data-aos-duration="800">
                        Bergabunglah dengan barisan pengguna pertama kami. Mulai dari Rp9.900/bulan — lebih murah dari secangkir kopi.
                    </p>

                    <!-- Social Proof Mini -->
                    <div class="trust-row" data-aos="fade-up" data-aos-delay="600" data-aos-duration="800">
                        <div class="trust-avatars">
                            <div class="avatar-circle" style="background:#4f46e5;"><i class="fas fa-shield-alt"></i></div>
                            <div class="avatar-circle" style="background:#059669;"><i class="fas fa-bolt"></i></div>
                            <div class="avatar-circle" style="background:#0891b2;"><i class="fas fa-check"></i></div>
                        </div>
                        <div class="trust-text">
                            <div class="trust-stars">★★★★★</div>
                            <span>Prioritas pada <strong>Keamanan & Kecepatan</strong></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Decorative Blobs -->
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
    </section>

    <!-- ===== PRICING CARDS ===== -->
    <section class="pricing-section">
        <div class="container">
            @php
                $user = auth()->user();
                // Cek apakah user berada di paket yearly berdasarkan request atau plan aslinya
                $isYearlyActive = request()->get('yearly') || ($user && $user->is_premium && $user->subscription_plan === 'yearly');
            @endphp

            <div class="pricing-toggle-wrap" data-aos="fade-up" data-aos-duration="600">
                <span class="toggle-label {{ !$isYearlyActive ? 'active' : '' }}" id="labelBulanan">Bulanan</span>
                <label class="pricing-toggle">
                    <input type="checkbox" id="toggleYearly" {{ $isYearlyActive ? 'checked' : '' }}>
                    <span class="toggle-slider"></span>
                </label>
                <span class="toggle-label {{ $isYearlyActive ? 'active' : '' }}" id="labelTahunan">
                    Tahunan
                    <span class="save-tag">Hemat 8%</span>
                </span>
            </div>

            <div class="row justify-content-center g-4">

                <!-- Starter Card (Fade dari Kiri) -->
                <div class="col-lg-4 col-md-5" data-aos="fade-right" data-aos-delay="200" data-aos-duration="800">
                    <div class="price-card price-card-free">
                        <div class="card-top">
                            <div class="card-icon">
                                <i class="bi bi-box"></i>
                            </div>
                            <span class="card-tier">Starter</span>
                        </div>
                        <div class="card-price">
                            <span class="currency">Rp</span>
                            <span class="amount">0</span>
                            <span class="period">/selamanya</span>
                        </div>
                        <p class="card-subtitle">Cocok untuk yang baru mulai mencatat keuangan.</p>

                        @if(!$user || !$user->is_premium)
                            <button class="btn-card btn-card-free disabled" disabled>
                                Paket Saat Ini
                            </button>
                        @else
                            <button class="btn-card btn-card-free disabled" disabled>
                                Paket Dasar
                            </button>
                        @endif

                        <div class="card-features">
                            <div class="feature-item">
                                <i class="bi bi-check2"></i>
                                <span>1 Tujuan Finansial</span>
                            </div>
                            <div class="feature-item">
                                <i class="bi bi-check2"></i>
                                <span>Kategori Standar</span>
                            </div>
                            <div class="feature-item">
                                <i class="bi bi-check2"></i>
                                <span>Batas Saldo Rp 6.000.000</span>
                            </div>
                            <div class="feature-item disabled">
                                <i class="bi bi-x"></i>
                                <span>Kategori Kustom</span>
                            </div>
                            <div class="feature-item disabled">
                                <i class="bi bi-x"></i>
                                <span>Fitur Premium</span>
                            </div>
                            <div class="feature-item disabled">
                                <i class="bi bi-x"></i>
                                <span>Prioritas Support</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Premium Card (Zoom In & Sedikit Delay agar Menjadi Sorotan Utama) -->
                <div class="col-lg-4 col-md-5" data-aos="zoom-in" data-aos-delay="400" data-aos-duration="800">
                    <div class="price-card price-card-premium">
                        <div class="popular-badge">
                            <i class="bi bi-stars"></i> Paling Populer
                        </div>

                        <div class="card-top">
                            <div class="card-icon icon-premium">
                                <i class="bi bi-gem"></i>
                            </div>
                            <span class="card-tier">Premium</span>
                        </div>

                        <div class="discount-banner">
                            <i class="bi bi-tag-fill"></i>
                            <span>Diskon 50% untuk bulan pertama</span>
                        </div>

                        <div class="card-price {{ $isYearlyActive ? 'hidden' : '' }}" id="premiumPriceBulanan">
                            <span class="currency">Rp</span>
                            <span class="amount">9.900</span>
                            <span class="period">/bulan</span>
                            <span class="original-price">Rp19.900</span>
                        </div>

                        <div class="card-price {{ !$isYearlyActive ? 'hidden' : '' }}" id="premiumPriceTahunan">
                            <span class="currency">Rp</span>
                            <span class="amount">219.900</span>
                            <span class="period">/tahun</span>
                            <span class="original-price">Rp238.800</span>
                            <span class="save-badge">Hemat Rp18.900</span>
                        </div>

                        <p class="card-subtitle">Untuk yang serius mengelola keuangan secara menyeluruh.</p>

                        @if($user && $user->is_premium)
                            
                            @if($user->subscription_plan === 'trial')
                                <div class="text-center text-warning fw-bold p-1 mb-1 small">
                                    <i class="bi bi-clock-history"></i> Anda dalam masa Uji Coba ({{ $user->subscription_days_left }} hari lagi)
                                </div>
                                <a href="{{ route('premium.checkout', ['plan' => $isYearlyActive ? 'yearly' : 'monthly']) }}" class="btn-card btn-card-premium" id="btnCheckoutTrial">
                                    <span>Pilih Paket Ini</span>
                                    <i class="bi bi-arrow-right"></i>
                                </a>

                            @elseif($user->subscription_plan === 'monthly')
                                <div class="monthly-user-view {{ $isYearlyActive ? 'hidden' : '' }} text-center badge bg-success-subtle text-success border border-success p-2 mb-2" id="currentPlanMonthlyText">
                                    <i class="bi bi-check-circle-fill"></i> <strong>Paket Aktif Anda (Bulanan)</strong>
                                </div>
                                <a href="{{ route('premium.checkout', ['plan' => 'yearly']) }}" class="btn-card btn-card-premium {{ !$isYearlyActive ? 'hidden' : '' }}" id="btnCheckoutYearly">
                                    <span>Upgrade ke Tahunan</span>
                                    <i class="bi bi-arrow-right"></i>
                                </a>

                            @elseif($user->subscription_plan === 'yearly')
                                <div class="yearly-user-view {{ !$isYearlyActive ? 'hidden' : '' }} text-center badge bg-success-subtle text-success border border-success p-2 mb-2" id="currentPlanYearlyText">
                                    <i class="bi bi-check-circle-fill"></i> <strong>Paket Aktif Anda (Tahunan)</strong>
                                </div>
                                <div class="monthly-user-view {{ $isYearlyActive ? 'hidden' : '' }} text-center badge bg-secondary-subtle text-muted border border-secondary p-2 mb-2" id="downgradeText">
                                    Anda berlangganan paket Tahunan
                                </div>
                            @endif

                        @else
                            <a href="{{ route('premium.checkout', ['plan' => $isYearlyActive ? 'yearly' : 'monthly']) }}" class="btn-card btn-card-premium" id="btnCheckout">
                                <span>Upgrade Sekarang</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        @endif
                        <div class="guarantee-row">
                            <i class="bi bi-shield-check"></i>
                            <span>Garansi uang kembali 7 hari</span>
                        </div>

                        <div class="card-features">
                            <div class="feature-item highlight">
                                <i class="bi bi-infinity"></i>
                                <span><strong>Tanpa Batas</strong> Tujuan Finansial</span>
                            </div>
                            <div class="feature-item highlight">
                                <i class="bi bi-check2-circle"></i>
                                <span>Kategori Kustom</span>
                            </div>
                            <div class="feature-item highlight">
                                <i class="bi bi-check2-circle"></i>
                                <span>Saldo > Rp 6.000.000</span>
                            </div>
                            <div class="feature-item highlight">
                                <i class="bi bi-check2-circle"></i>
                                <span>Prioritas Support 24/7</span>
                            </div>
                            <div class="feature-item highlight">
                                <i class="bi bi-check2-circle"></i>
                                <span>Akses fitur baru lebih dulu</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ===== COMPARISON TABLE ===== -->
    <section class="compare-section">
        <div class="container" data-aos="fade-up" data-aos-duration="800">
            <h2 class="section-title text-center mb-2">Bandingkan Fitur Lengkapnya</h2>
            <p class="section-subtitle text-center mb-5">Lihat apa saja yang kamu dapatkan di setiap paket.</p>

            <div class="table-wrap">
                <table class="compare-table">
                    <thead>
                        <tr>
                            <th>Fitur</th>
                            <th class="text-center">Starter</th>
                            <th class="text-center th-premium">Premium</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Tujuan Finansial</td>
                            <td class="text-center"><span class="val-limit">Maks. 1</span></td>
                            <td class="text-center"><span class="val-unlimited">Tanpa Batas</span></td>
                        </tr>
                        <tr>
                            <td>Batas Saldo</td>
                            <td class="text-center"><span class="val-limit">Rp 6 Juta</span></td>
                            <td class="text-center"><span class="val-unlimited">Unlimited</span></td>
                        </tr>
                        <tr>
                            <td>Kategori Transaksi</td>
                            <td class="text-center"><span class="val-limit">Standar</span></td>
                            <td class="text-center"><span class="val-unlimited">Kustom</span></td>
                        </tr>
                        <tr>
                            <td>Ekspor Laporan PDF</td>
                            <td class="text-center"><span class="val-limit">1 bulan</span></td>
                            <td class="text-center"><span class="val-unlimited">Multi-bulan</span></td>
                        </tr>
                        <tr>
                            <td>Grafik & Analitik</td>
                            <td class="text-center"><span class="val-limit">Dasar</span></td>
                            <td class="text-center"><span class="val-unlimited">Lengkap</span></td>
                        </tr>
                        <tr>
                            <td>Support</td>
                            <td class="text-center"><span class="val-limit">Email</span></td>
                            <td class="text-center"><span class="val-unlimited">Prioritas 24/7</span></td>
                        </tr>
                        <tr>
                            <td>Akses Fitur Baru</td>
                            <td class="text-center"><i class="bi bi-x-circle text-danger"></i></td>
                            <td class="text-center"><i class="bi bi-check-circle-fill text-success"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- ===== TESTIMONIALS ===== -->
    <section class="testi-section">
        <div class="container">
            <h2 class="section-title text-center mb-2" data-aos="fade-up" data-aos-duration="600">Suara Anda Adalah Prioritas Kami</h2>
            <p class="section-subtitle text-center mb-5" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">MoneyMate baru saja diluncurkan! Jadilah orang pertama yang memberikan masukan.</p>

            <div class="row justify-content-center">
                <div class="col-lg-8" data-aos="zoom-in" data-aos-duration="800">
                    <div class="testi-card text-center p-5" style="border: solid #0984e3; background: #f8fafc;">
                        <div class="mb-3" style="font-size: 2rem;">🚀</div>
                        <h3 class="h5 fw-bold">Belum Ada Review</h3>
                        <p class="text-muted mb-4">
                            Kami sedang mencari 100 pengguna pertama untuk mencoba MoneyMate secara Eksklusif. 
                            Pengalaman dan masukan Anda sangat berarti bagi perkembangan aplikasi ini.
                        </p>
                        <a href="https://polibatam.id/moneymate-feedback" class="btn btn-card-premium px-4 py-2" style="border-radius: 50px;">
                            Coba Sekarang & Beri Masukan
                        </a>
                        
                        <div class="mt-4 pt-3 border-top">
                            <small class="text-muted italic">"Kritik Anda hari ini adalah fitur kami hari esok."</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== FAQ ===== -->
    <section class="faq-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <h2 class="section-title text-center mb-2" data-aos="fade-up" data-aos-duration="600">Pertanyaan Umum</h2>
                    <p class="section-subtitle text-center mb-5" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">Belum yakin? Baca dulu FAQ-nya.</p>

                    <div class="accordion" id="faqAccordion" data-aos="fade-up" data-aos-duration="800">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    Apakah bisa cancel kapan saja?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Bisa! Kamu bisa berhenti berlangganan kapan saja tanpa penalti. Setelah berhenti, akunmu otomatis kembali ke paket Dasar dan data tetap aman.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    Bagaimana cara pembayarannya?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Untuk menjaga keamanan dan eksklusivitas layanan Premium, pembayaran dilakukan melalui transfer ke rekening atau e-wallet resmi admin. Setiap transaksi diverifikasi secara langsung oleh tim kami untuk memastikan aktivasi akun Anda berjalan lancar dan aman.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Apakah data keuangan saya aman?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Keamanan adalah prioritas utama kami. Semua data dienkripsi end-to-end, server berada di data center berstandar ISO 27001, dan kami tidak pernah membagikan data ke pihak ketiga.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    Garansi uang kembali bagaimana?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Jika dalam 7 hari pertama kamu merasa fitur Premium tidak sesuai ekspektasi, hubungi kami dan kami akan mengembalikan 100% pembayaranmu — tanpa pertanyaan.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                    Bedanya paket bulanan dan tahunan apa?
                                </button>
                            </h2>
                            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Fitur-nya sama persis. Perbedaannya hanya di harga: paket tahunan lebih hemat Rp18.900 per tahun dibanding bayar bulanan. Cocok untuk yang sudah yakin pakai jangka panjang.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== FINAL CTA ===== -->
    <section class="cta-section">
        <div class="container" data-aos="zoom-in" data-aos-duration="800">
            <div class="cta-box">
                <div class="cta-glow"></div>
                <h2 class="cta-title">Siap Kelola Keuangan Lebih Cerdas?</h2>
                <p class="cta-desc">Mulai sekarang. Tanpa risiko. Garansi 7 hari uang kembali.</p>
                <a href="{{ route('premium.checkout', ['plan' => 'monthly']) }}" class="btn-cta-final">
                    <span>Coba Premium Rp9.900</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
                <div class="cta-micro">
                    <i class="bi bi-lock-fill"></i>
                    <span>Pembayaran aman & terenkripsi</span>
                </div>
            </div>
        </div>
    </section>

</div>

@include('partials.scripts.premium.upgrade')

<!-- AOS Script Integration -->
<!-- <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            once: true, // Animasi hanya berjalan sekali saat di-scroll pertama kali
            offset: 120 // Animasi baru terpicu jika elemen 120px di atas viewport
        });
    });
</script> -->
@endsection