@extends('layouts.home')

@section('title', 'Kelola Keuangan & Anggaran Pribadi')

@section('content')
<div class="hero-section">
    <div class="container">
        {{-- Alert untuk pesan sukses --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('status'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>INFO:</strong> {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h1 class="hero-title">Selamat Datang di Money<span style="color: #3182ce;">Mate</span></h1>
                <p class="hero-subtitle">
                    <span class="top-text">
                        Platform Web Interaktif untuk Manajemen Anggaran Harian
                    </span> 
                    <span class="bottom-text">
                        dan Analisis Keuangan
                    </span>
                </p>
                <button class="btn btn-lihat" onclick="scrollToFeatures()">
                    Lihat Selengkapnya <i class="fas fa-arrow-right ms-2"></i>
                </button> 
            </div>
            <div class="col-lg-6 text-center" data-aos="fade-left">
                <div class="swiper heroSwiper fancy-swiper" style="height: 400px;">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="{{ asset('images/banner1.png') }}" alt="Banner 1" class="img-fluid rounded-4 shadow" 
                                 style="object-fit: none;">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ asset('images/banner2.png') }}" alt="Banner 2" class="img-fluid rounded-4 shadow">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ asset('images/banner3.png') }}" alt="Banner 3" class="img-fluid rounded-4 shadow">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ asset('images/banner4.png') }}" alt="Banner 4" class="img-fluid rounded-4 shadow">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ asset('images/banner5.png') }}" alt="Banner 5" class="img-fluid rounded-4 shadow">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ asset('images/banner6.png') }}" alt="Banner 6" class="img-fluid rounded-4 shadow">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ asset('images/flyer.png') }}" alt="Banner 7" class="img-fluid rounded-4 shadow"
                                 style="object-fit: cover;">
                        </div>
                        <div class="swiper-slide">
                            <img src="#" 
                                 alt="MoneyMate: Aplikasi Web Interaktif Pengelola Anggaran"
                                 class="img-fluid rounded-4 shadow"
                                 onerror="this.style.display='none'; this.insertAdjacentHTML('afterend', `<p class='alt-text'>${this.alt}</p>`);">
                        </div>
                    </div>
                    <!-- Pagination dan Navigation -->
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4">
    {{-- Isi konten tema --}}
    <div class="card shadow-lg border-0 rounded-3 my-4" data-aos="zoom-in" data-aos-delay="100" animate__animated animate__fadeInUp>
        <div class="card-body text-center p-4">
            <div class="d-flex justify-content-center align-items-center mb-3" data-aos="fade-up" data-aos-delay="200">
                <img src="{{ asset('images/moneymate-original.png') }}" 
                    alt="Logo" 
                    class="me-2" 
                    style="width: 60px; height:auto;">
                <h4 class="fw-bold mb-0" style="color: #1a365d;">Aplikasi Web Teman Anggaranmu</h4>
            </div>
            <p class="card-text text-muted mb-4" data-aos="fade-up" data-aos-delay="300">
                Kelola keuanganmu lebih mudah, cepat, dan terorganisir di sini.
            </p>
            <a href="{{ route('dashboard.index') }}" class="btn btn-primary bg-btn-gradient px-4" data-aos="fade-up" data-aos-delay="400">
                Mulai Sekarang
            </a>
        </div>
    </div>
</div>

<!-- Fitur Unggulan -->
<section id="features" class="py-5">
    <div class="container">
        <h2 class="text-center mb-5" data-aos="fade-up">Fitur Unggulan MoneyMate</h2>
        <div class="row">
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-chart-pie fa-3x mb-3" style="color: #1a365d;"></i>
                        <h5>Analisis Keuangan</h5>
                        <p>Dapatkan insight mendalam tentang pola Pengeluaran dan Pemasukan Anda dengan grafik interaktif</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-mobile-alt fa-3x mb-3" style="color: #1a365d;"></i>
                        <h5>Interface Interaktif</h5>
                        <p>Kelola keuangan dengan mudah melalui interface yang user-friendly dan responsive</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-shield-alt fa-3x mb-3" style="color: #1a365d;"></i>
                        <h5>Keamanan Terjamin</h5>
                        <p>Data keuangan Anda tersimpan aman dengan Enkripsi dan Autorisasi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistik -->
<section class="py-5" style="background: linear-gradient(135deg, #2c5282 0%, #3182ce 100%);">
    <div class="container">
        <div class="row text-center text-white justify-content-center">
            
            <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="counter-box p-4 rounded-4 shadow-sm bg-opacity-10 bg-white">
                    <i class="fas fa-users fa-3x mb-3"></i>
                    <h3 class="fw-bold counter" data-target="{{ $activeUsers }}"></h3>
                    <p>Pengguna Aktif</p>
                </div>
            </div>

            <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="counter-box p-4 rounded-4 shadow-sm bg-opacity-10 bg-white">
                    <i class="fas fa-chart-line fa-3x mb-3"></i>
                    <h3 class="fw-bold counter" data-target="{{ $transactions }}"></h3>
                    <p>Transaksi Tercatat</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-light">
    <div class="container text-center">
        <div data-aos="fade-up">
            <h2 class="mb-4">Siap Mengelola Keuangan Anda dengan Lebih Baik?</h2>
            <p class="lead mb-4">Bergabunglah untuk merasakan manfaat dari MoneyMate terhadap keuangan Anda!</p>
            <a href="/register" class="btn btn-primary bg-btn-gradient btn-lg me-3">Daftar Sekarang</a>
            <a href="/informasi">
                <button class="btn btn-outline-monmat btn-lg me-3">Pelajari Lebih Lanjut</button>
            </a>
        </div>
    </div>
</section>

<!-- Pricing List -->
<section id="pricing" class="py-5">
    <div class="container text-center">
        <h2 class="mb-5" data-aos="fade-up">Paket Harga MoneyMate</h2>
        <div class="row justify-content-center">

            <!-- Paket Dasar (Gratis) -->
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 text-center reguler-card">
                    <div class="card-header text#102F4B">
                        <h4 class="my-0">Dasar</h4>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title pricing-card-title">Rp0<span class="fs-6 fw-light">/bln</span></h3>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li>✔ Catat Transaksi</li>
                            <li>✔ Kelola Anggaran</li>
                            <li>✔ Grafik Laporan</li>
                            <li>✔ 1 Tujuan Finansial</li>
                            <li>✖ Fitur Premium</li>
                        </ul>
                        <a href="{{ route('dashboard.index') }}" class="btn btn-premium w-100">
                            Mulai
                        </a>
                    </div>
                </div>
            </div>

            <!-- Paket Premium (Langganan) -->
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="premium-wrapper">

                    <!-- Badge Pojok -->
                    <div class="promo-badge-pill">Diskon 50% untuk 1 bulan pertama*</div>

                    <div class="card h-100 text-center premium-card">

                        <div class="card-header">
                            <h4 class="my-0">Premium</h4>
                        </div>

                        <div class="card-body position-relative">

                            <!-- Premium Star -->
                            <div style="position: absolute; top: 15px; right: 15px;">
                                <svg 
                                    xmlns="http://www.w3.org/2000/svg" 
                                    fill="none" 
                                    viewBox="0 0 24 24" 
                                    stroke-width="1.5" 
                                    stroke="currentColor" 
                                    style="width: 32px; height: 32px; color: #2979ff;"
                                >
                                    <path 
                                        stroke-linecap="round" 
                                        stroke-linejoin="round" 
                                        d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" 
                                    />
                                </svg>
                            </div>

                            <div class="mb-2">
                                <span class="harga-asli">Rp19.900</span>
                                <span class="badge-discount">-50%</span>
                            </div>

                            <h3 class="card-title pricing-card-title">
                                Rp9.900<span class="fs-6 fw-light">/bln</span>
                            </h3>

                            <ul class="list-unstyled mt-3 mb-4">
                                <li>✔ Semua Fitur Dasar</li>
                                <li>✔ Kategori Tambahan</li>
                                <li>✔ Tujuan Finansial tanpa batas</li>
                                <li>✔ Limit Saldo > Rp. 6.000.000</li>
                            </ul>

                            <div class="mb-3">
                                <a href="#" class="opsi-tahunan"
                                data-bs-toggle="modal" data-bs-target="#modalTahunan">
                                    Opsi paket tahunan
                                </a>
                            </div>

                            <a href="{{ route('premium.checkout', ['plan' => 'monthly']) }}" class="btn btn-premium w-100">
                                Upgrade Sekarang
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Modal Paket Tahunan -->
            <div class="modal fade" id="modalTahunan" tabindex="-1" aria-labelledby="modalTahunanLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTahunanLabel">Paket Premium Tahunan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body text-center">

                            <!-- Label Hemat -->
                            <div class="hemat-badge mb-3">Lebih Hemat</div>

                            <!-- Harga Tahunan -->
                            <h3 class="fw-bold text-success">
                                Rp219.900 <span class="fs-6 text-muted">/tahun</span>
                            </h3>

                            <!-- Fitur Premium -->
                            <ul class="list-unstyled mt-3 text-start mx-auto" style="max-width: 260px;">
                                <li>✔ Semua Fitur Dasar</li>
                                <li>✔ Kategori Tambahan</li>
                                <li>✔ Tujuan Finansial tanpa batas</li>
                                <li>✔ Saldo lebih dari 6.000.000</li>
                            </ul>

                        </div>

                        <div class="modal-footer justify-content-center">
                            <a href="{{ route('premium.checkout', ['plan' => 'yearly']) }}" class="btn btn-primary">
                                Upgrade Sekarang
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@auth
    @if(!auth()->user()->hasCompletedTerms())
        @include('components.terms-modal', ['version' => '1.0'])
    @endif
@endauth

<script>
document.addEventListener("DOMContentLoaded", () => {
    const counters = document.querySelectorAll(".counter"); 
    const speed = 500; // semakin kecil, semakin cepat animasinya

    const animate = () => {
        counters.forEach(counter => {
            const target = +counter.getAttribute("data-target");
            const current = +counter.innerText;
            const increment = target / speed;

            if (current < target) {
                counter.innerText = Math.ceil(current + increment);
                setTimeout(animate, 20);
            } else {
                counter.innerText = target;
            }
        });
    };

    // Jalankan animasi ketika elemen terlihat di layar (scroll)
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animate();
                observer.disconnect();
            }
        });
    }, { threshold: 0.3 });

    observer.observe(document.querySelector(".counter-box"));
});

function scrollToFeatures() {
    document.getElementById('features').scrollIntoView({ 
        behavior: 'smooth' 
    });
}
</script>

@endsection