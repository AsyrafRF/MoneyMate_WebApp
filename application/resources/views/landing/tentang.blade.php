@extends('layouts.home')

@push('styles')
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
@endpush

@section('title', 'Tentang')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">

            {{-- Heading Utama --}}
            <h1 class="text-center mb-5" data-aos="fade-down" data-aos-duration="800" data-aos-easing="ease-out-cubic">
                Tentang Tim Pengembang
            </h1>

            {{-- Card Visi & Misi --}}
            <div class="card shadow-sm mb-5" data-aos="fade-up" data-aos-duration="900" data-aos-easing="ease-out-cubic">
                <div class="card-body p-5">

                    <h3 class="bg-general-monmat mb-4" data-aos="fade-right" data-aos-delay="200" data-aos-duration="700">
                        <i class="fas fa-eye me-2"></i>Visi Kami
                    </h3>
                    <p class="lead" data-aos="fade-right" data-aos-delay="300" data-aos-duration="700">
                        Membantu generasi muda mengelola keuangan pribadi dengan cara yang mudah, transparan, dan menyenangkan.
                    </p>

                    <h3 class="bg-general-monmat mb-4 mt-5" data-aos="fade-left" data-aos-delay="400" data-aos-duration="700">
                        <i class="fas fa-bullseye me-2"></i>Misi Kami
                    </h3>
                    <ul class="list-unstyled">
                        <li class="mb-2" data-aos="fade-left" data-aos-delay="500" data-aos-duration="700">
                            <i class="fas fa-check text-success me-2"></i>Menyediakan pencatatan keuangan sederhana namun powerful.
                        </li>
                        <li class="mb-2" data-aos="fade-left" data-aos-delay="600" data-aos-duration="700">
                            <i class="fas fa-check text-success me-2"></i>Memberikan insight melalui visualisasi interaktif.
                        </li>
                        <li class="mb-2" data-aos="fade-left" data-aos-delay="700" data-aos-duration="700">
                            <i class="fas fa-check text-success me-2"></i>Menumbuhkan budaya finansial sehat.
                        </li>
                    </ul>

                </div>
            </div>

            {{-- Heading Tim --}}
            <h2 class="text-center mb-5" data-aos="zoom-in" data-aos-duration="800" data-aos-delay="100">
                Tim Pengembang
            </h2>

            <div class="row">

                {{-- 1. Holong Marisi --}}
                <div class="col-md-6 mb-4">
                    <div class="card h-100" data-aos="fade-up" data-aos-delay="0" data-aos-duration="700" data-aos-easing="ease-out-cubic">
                        <div class="card-body text-center">
                            <img src="https://if.polibatam.ac.id/assets/backupold/img/dosen/holongmarisi.jpeg" 
                                class="rounded-circle mb-3 shadow-sm d-block mx-auto" 
                                style="width: 90px; height: 90px; object-fit: cover;" 
                                alt="Profile"
                                data-aos="zoom-in" data-aos-delay="150" data-aos-duration="600">
                            <a href="mailto:holongmarisi@polibatam.ac.id" target="polibatam.id" class="dev-name">
                                <h5>Holong Marisi Simalango, A.Md., S.T., M.Kom.</h5>
                            </a>
                            <span class="badge bg-primary-subtle text-primary mb-2" data-aos="fade-up" data-aos-delay="200">
                                Project Manager
                            </span>
                            <p>Merencanakan dan mengawasi jalannya proyek agar selesai tepat waktu dan memenuhi standar kualitas dari MoneyMate.</p>
                        </div>
                    </div>
                </div>

                {{-- 2. Nurul Amalia --}}
                <div class="col-md-6 mb-4">
                    <div class="card h-100" data-aos="fade-up" data-aos-delay="200" data-aos-duration="700" data-aos-easing="ease-out-cubic">
                        <div class="card-body text-center">
                            <img src="https://github.com/nurul2010.png" 
                                class="rounded-circle mb-3 shadow-sm d-block mx-auto" 
                                style="width: 90px; height: 90px; object-fit: cover;" 
                                alt="Profile"
                                data-aos="zoom-in" data-aos-delay="350" data-aos-duration="600">
                            <a href="https://github.com/nurul2010" target="_blank" class="dev-name text-decoration-none">
                                <h5>Nurul Amalia Ramadhani</h5>
                            </a>
                            <span class="badge bg-warning-subtle text-warning mb-2 mt-4" data-aos="fade-up" data-aos-delay="400">
                                Business Analyst
                            </span>
                            <p>Menyusun dan Merencanakan Kebutuhan Perangkat Lunak & Alur Bisnis dari Aplikasi Moneymate.</p>
                        </div>
                    </div>
                </div>

                {{-- 3. Cahya Trixie --}}
                <div class="col-md-6 mb-4">
                    <div class="card h-100" data-aos="fade-up" data-aos-delay="300" data-aos-duration="700" data-aos-easing="ease-out-cubic">
                        <div class="card-body text-center">
                            <img src="https://github.com/Cahyatrixie.png" 
                                class="rounded-circle mb-3 shadow-sm d-block mx-auto" 
                                style="width: 90px; height: 90px; object-fit: cover;" 
                                alt="Profile"
                                data-aos="zoom-in" data-aos-delay="450" data-aos-duration="600">
                            <a href="https://github.com/Cahyatrixie" target="_blank" class="dev-name">
                                <h5>Cahya Trixie Ariella</h5>
                            </a>
                            <span class="badge bg-danger-subtle text-danger mb-2" data-aos="fade-up" data-aos-delay="500">
                                QA Tester
                            </span>
                            <p>Menjaga Kualitas Produk serta merencanakan dan menjalankan pengujian dalam pengembangan MoneyMate.</p>
                        </div>
                    </div>
                </div>

                {{-- 4. Fauzan Alwan --}}
                <div class="col-md-6 mb-4">
                    <div class="card h-100" data-aos="fade-up" data-aos-delay="400" data-aos-duration="700" data-aos-easing="ease-out-cubic">
                        <div class="card-body text-center">
                            <img src="https://github.com/fauzan-alwan.png" 
                                class="rounded-circle mb-3 shadow-sm d-block mx-auto" 
                                style="width: 90px; height: 90px; object-fit: cover;" 
                                alt="Profile"
                                data-aos="zoom-in" data-aos-delay="550" data-aos-duration="600">
                            <a href="https://github.com/fauzan-alwan" target="_blank" class="dev-name">
                                <h5>Fauzan Alwan</h5>
                            </a>
                            <span class="badge bg-success-subtle text-success mb-2" data-aos="fade-up" data-aos-delay="600">
                                UI/UX Designer
                            </span>
                            <p>Merancang antarmuka yang menarik dan pengalaman pengguna yang optimal bagi Aplikasi Web MoneyMate.</p>
                        </div>
                    </div>
                </div>

                {{-- 5. Daniel Charlie --}}
                <div class="col-md-6 mb-4">
                    <div class="card h-100" data-aos="fade-up" data-aos-delay="500" data-aos-duration="700" data-aos-easing="ease-out-cubic">
                        <div class="card-body text-center">
                            <img src="https://github.com/danielcharlie9122e.png" 
                                class="rounded-circle mb-3 shadow-sm d-block mx-auto" 
                                style="width: 90px; height: 90px; object-fit: cover;" 
                                alt="Profile"
                                data-aos="zoom-in" data-aos-delay="650" data-aos-duration="600">
                            <a href="https://github.com/danielcharlie9122e" target="_blank" class="dev-name">
                                <h5>Daniel Charlie Samuel</h5>
                            </a>
                            <span class="badge bg-info-subtle text-info mb-2" data-aos="fade-up" data-aos-delay="700">
                                Front-End Developer
                            </span>
                            <p>Bertanggung jawab dalam pengembangan tampilan depan dari aplikasi web MoneyMate.</p>
                        </div>
                    </div>
                </div>

                {{-- 6. Asyraf Rais --}}
                <div class="col-md-6 mb-4 mx-auto">
                    <div class="card h-100" data-aos="fade-up" data-aos-delay="600" data-aos-duration="700" data-aos-easing="ease-out-cubic">
                        <div class="card-body text-center">
                            <img src="https://github.com/AsyrafRF.png" 
                                class="rounded-circle mb-3 shadow-sm d-block mx-auto" 
                                style="width: 90px; height: 90px; object-fit: cover;" 
                                alt="Profile"
                                data-aos="zoom-in" data-aos-delay="750" data-aos-duration="600">
                            <a href="https://github.com/AsyrafRF" target="_blank" class="dev-name">
                                <h5>Asyraf Rais Fadhil</h5>
                            </a>
                            <span class="badge bg-dark-subtle text-dark mb-2" data-aos="fade-up" data-aos-delay="800">
                                Backend Developer
                            </span>
                            <p>Bertanggung jawab dalam pengembangan Sisi Server dan Database dari aplikasi MoneyMate.</p>
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