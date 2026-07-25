@extends('layouts.home')

@section('title', 'Kontak')

@push('styles')
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
<link href="{{ asset('css/home/kontak/contact-list.css') }}" rel="stylesheet">
<link href="{{ asset('css/home/kontak/socmed-list.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">

            <!-- Contact Card -->
            <div class="container d-flex justify-content-center py-5" data-aos="fade-up" data-aos-duration="700">
                <div class="card contact-card shadow-sm w-100 text-white">
                    <div class="card-header border-0 pt-4">
                        <div class="text-center mb-1" data-aos="zoom-in" data-aos-duration="600" data-aos-delay="100">
                            <img src="{{ asset('images/moneymate-original.png') }}" alt="Logo" class="contact-logo">
                        </div>
                        <h4 class="fw-bold text-center mb-0" data-aos="fade-down" data-aos-duration="500" data-aos-delay="200">Informasi Kontak</h4>
                        <hr class="mx-auto" style="width: 290px; height: 3px; background: #1B94D7; border-radius: 10px; opacity: 1;" data-aos="zoom-in" data-aos-duration="400" data-aos-delay="300">
                    </div>
                    
                    <div class="card-body px-4 pb-4">
                        <!-- Email -->
                        <div class="d-flex align-items-start mb-4" data-aos="fade-right" data-aos-duration="600" data-aos-delay="350">
                            <div class="icon-box me-3 shadow-sm">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <div class="small fst-italic">Email</div>
                                <a href="mailto:moneymate.app.id@gmail.com" class="contact-link fw-semibold">
                                    moneymate.app.id@gmail.com
                                </a>
                            </div>
                        </div>

                        <!-- Telepon -->
                        <div class="d-flex align-items-start mb-4" data-aos="fade-right" data-aos-duration="600" data-aos-delay="450">
                            <div class="icon-box me-3 shadow-sm">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div>
                                <div class="small fst-italic">Telepon</div>
                                <a href="https://wa.me/6282172437617" target="_blank" class="contact-link fw-semibold">
                                    +62 821-7243-7617
                                </a>
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="d-flex align-items-start mb-4" data-aos="fade-right" data-aos-duration="600" data-aos-delay="550">
                            <div class="icon-box me-3 shadow-sm">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <div class="small fst-italic">Alamat</div>
                                <span class="fw-semibold text-white">
                                    Jl. Ahmad Yani, Tlk. Tering, Batam Kota 29444
                                </span>
                            </div>
                        </div>

                        <!-- Jam Operasional -->
                        <div class="d-flex align-items-start" data-aos="fade-right" data-aos-duration="600" data-aos-delay="650">
                            <div class="icon-box me-3 shadow-sm">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <div class="small fst-italic">Jam Operasional</div>
                                <div class="fw-semibold text-white">
                                    <span class="d-block">Senin - Jumat: 09:00 - 17:00</span>
                                    <span class="d-block">Sabtu: 09:00 - 12:00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media Card -->
            <div class="container d-flex justify-content-center mt-2 mb-4" data-aos="fade-up" data-aos-duration="700" data-aos-delay="100">
                <div class="social-card shadow-sm w-100">
                    <div class="text-center mb-4 mt-3">
                        <h5 class="fw-bold text-white mb-1" data-aos="fade-down" data-aos-duration="500">Ikuti Kami</h5>
                        <p class="text-white-50 small mb-0" data-aos="fade-down" data-aos-duration="500" data-aos-delay="100">Tetap terhubung melalui media sosial kami</p>
                    </div>

                    <div class="row g-3 px-3 pb-3">
                        <!-- Instagram -->
                        <a href="https://instagram.com/moneymate_id" target="_blank" class="col-6 col-md-3 text-decoration-none">
                            <div class="soc-item soc-instagram" data-aos="zoom-in" data-aos-duration="500" data-aos-delay="150">
                                <div class="soc-icon-wrap">
                                    <i class="fab fa-instagram"></i>
                                </div>
                                <span class="soc-name">Instagram</span>
                                <span class="soc-handle">@moneymate_id</span>
                                <div class="soc-arrow">
                                    <i class="fas fa-arrow-up-right-from-square"></i>
                                </div>
                            </div>
                        </a>

                        <!-- X / Twitter -->
                        <a href="https://x.com/moneymateid" target="_blank" class="col-6 col-md-3 text-decoration-none">
                            <div class="soc-item soc-x" data-aos="zoom-in" data-aos-duration="500" data-aos-delay="250">
                                <div class="soc-icon-wrap">
                                    <i class="bi bi-twitter-x"></i>
                                </div>
                                <span class="soc-name">X</span>
                                <span class="soc-handle">@moneymateid</span>
                                <div class="soc-arrow">
                                    <i class="fas fa-arrow-up-right-from-square"></i>
                                </div>
                            </div>
                        </a>

                        <!-- TikTok -->
                        <a href="https://www.tiktok.com/@moneymate.id" target="_blank" class="col-6 col-md-3 text-decoration-none">
                            <div class="soc-item soc-tiktok" data-aos="zoom-in" data-aos-duration="500" data-aos-delay="350">
                                <div class="soc-icon-wrap">
                                    <i class="fab fa-tiktok"></i>
                                </div>
                                <span class="soc-name">TikTok</span>
                                <span class="soc-handle">@moneymate.id</span>
                                <div class="soc-arrow">
                                    <i class="fas fa-arrow-up-right-from-square"></i>
                                </div>
                            </div>
                        </a>

                        <!-- Discord -->
                        <a href="https://discord.gg/Z9YxgFEVtG" target="_blank" class="col-6 col-md-3 text-decoration-none">
                            <div class="soc-item soc-discord" data-aos="zoom-in" data-aos-duration="500" data-aos-delay="450">
                                <div class="soc-icon-wrap">
                                    <i class="fab fa-discord"></i>
                                </div>
                                <span class="soc-name">Discord</span>
                                <span class="soc-handle">MoneyMate</span>
                                <div class="soc-arrow">
                                    <i class="fas fa-arrow-up-right-from-square"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="mt-5">
                <h3 class="text-center mb-4" data-aos="fade-up" data-aos-duration="600">Pertanyaan yang Sering Diajukan</h3>
                <div class="accordion" id="faqAccordion">

                    <div class="accordion-item" data-aos="fade-up" data-aos-duration="500" data-aos-delay="100">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                Aplikasi MoneyMate dipakai untuk apa?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                MoneyMate dipakai untuk membantu anda Mencatatat Keuangan Pribadi dan Mengelola Anggaran sehari-hari dengan mudah dan informatif.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item" data-aos="fade-up" data-aos-duration="500" data-aos-delay="200">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Apa manfaat menggunakan aplikasi MoneyMate untuk saya?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Dengan bantuan Aplikasi MoneyMate, Anda dapat mengatur dan memantau keuangan harian agar pengeluaran tetap terkendali dan tidak boros.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item" data-aos="fade-up" data-aos-duration="500" data-aos-delay="300">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Bisakah saya mengakses MoneyMate di mobile?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Ya, MoneyMate memiliki responsive design yang dapat diakses dengan sempurna di perangkat mobile dan tablet.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item" data-aos="fade-up" data-aos-duration="500" data-aos-delay="400">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                Bagaimana keamanan data saya?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Data Anda dienkripsi dan disimpan dengan aman. Kami tidak akan membagikan informasi Anda kepada pihak ketiga.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item" data-aos="fade-up" data-aos-duration="500" data-aos-delay="500">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                Dari mana saya mendapatkan notifikasi dan pengingat jika telah melewati batas anggaran?
                            </button>
                        </h2>
                        <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Anda akan mendapatkan notifikasi dan pengingat melalui Email anda maupun dari halaman notifikasi di dalam aplikasi.
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        once: true,
        offset: 80,
        easing: 'ease-out-cubic'
    });
</script>
@endpush