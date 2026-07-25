@extends('layouts.home')

@section('title', 'Informasi')

@push('styles')
<link href="{{ asset('css/home/informasi/whatis.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h1 class="text-center mb-5"
                data-aos="fade-down" 
                data-aos-duration="800" 
                data-aos-easing="ease-out-cubic">Informasi Aplikasi</h1>
            
            <div class="var-section" data-aos="zoom-in">
                <div class="card card-v5">
                    <div class="pattern-bg"></div>
                    <div class="glow glow-1"></div>
                    <div class="glow glow-2"></div>
                    <div class="card-body">
                        <div class="eyebrow">Tentang Platform</div>
                        <h3>Apa itu MoneyMate?</h3>
                        <p class="desc">
                            MoneyMate adalah platform web interaktif yang dirancang untuk membantu pengguna mengelola anggaran harian secara efektif melalui <em>pencatatan Pemasukan dan Pengeluaran</em>, pengelompokan kategori, serta penyajian analisis keuangan dalam bentuk <em>grafik dan laporan visual</em>. Memudahkan pengguna memantau kondisi keuangan secara <em>real-time</em> dan merencanakan anggaran dengan lebih terarah.
                        </p>
                        <div class="divider"></div>
                        <div class="bottom-row">
                            <div class="bottom-item">
                                <div class="bottom-icon">
                                    <i class="fa-solid fa-table-cells-large"></i>
                                </div>
                                <div class="bottom-text">
                                    <strong>Pencatatan</strong>
                                    Pemasukan & Pengeluaran
                                </div>
                            </div>
                            <div class="bottom-item">
                                <div class="bottom-icon">
                                    <i class="fa-solid fa-chart-pie"></i>
                                </div>
                                <div class="bottom-text">
                                    <strong>Analisis</strong>
                                    Grafik visual interaktif
                                </div>
                            </div>
                            <div class="bottom-item">
                                <div class="bottom-icon">
                                    <i class="fa-solid fa-compass"></i>
                                </div>
                                <div class="bottom-text">
                                    <strong>Perencanaan</strong>
                                    Anggaran terarah
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-body p-5">
                    <h3 class="bg-general-monmat mb-4 text-center"
                        data-aos="zoom-in">Fitur Utama</h3>
                    <div class="row g-4">
                        @php
                            $features = [
                                ['icon' => 'fa-chart-line', 'title' => 'Manajemen Anggaran per Kategori', 'desc' => 'Catat semua Pemasukan dan Pengeluaran Anda dengan mudah.'],
                                ['icon' => 'fa-chart-pie', 'title' => 'Laporan Keuangan Interaktif', 'desc' => 'Lihat data keuangan Anda dalam bentuk grafik yang mudah dipahami.'],
                                ['icon' => 'fa-bell', 'title' => 'Notifikasi & Pengingat', 'desc' => 'Dapatkan pengingat untuk batas anggaran dan pencatatan keuangan.'],
                                ['icon' => 'fa-bullseye', 'title' => 'Tujuan Finansial dengan Progress', 'desc' => 'Capai tujuan finansial dengan tepat waktu dan sasaran.'],
                            ];
                        @endphp

                        @foreach($features as $f)
                        <div class="col-md-6" data-aos="zoom-in" data-aos-delay="100">
                            <div class="feature-card text-center p-4 rounded-4 h-100 border-0 shadow-sm bg-light hover-shadow transition">
                                <div class="icon-circle bg-primary text-white mx-auto mb-3">
                                    <i class="fas {{ $f['icon'] }} fa-2x"></i>
                                </div>
                                <h5 class="fw-bold text-dark">{{ $f['title'] }}</h5>
                                <p class="text-muted">{{ $f['desc'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4"
                 data-aos="zoom-in">
                <div class="card-body p-5">
                    <h3 class="bg-general-monmat mb-4 text-center">Cara Menggunakan</h3>
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            <div class="rounded-circle bg-general-gradient text-white d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <span class="fs-4 fw-bold">1</span>
                            </div>
                            <h5 class="mt-3">Daftar Akun</h5>
                            <p>Buat akun MoneyMate dengan email Anda</p>
                        </div>
                        <div class="col-md-4 text-center mb-4">
                            <div class="rounded-circle bg-general-gradient text-white d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <span class="fs-4 fw-bold">2</span>
                            </div>
                            <h5 class="mt-3">Input Data</h5>
                            <p>Masukkan data keuangan harian Anda</p>
                        </div>
                        <div class="col-md-4 text-center mb-4">
                            <div class="rounded-circle bg-general-gradient text-white d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <span class="fs-4 fw-bold">3</span>
                            </div>
                            <h5 class="mt-3">Analisis</h5>
                            <p>Lihat analisis dan insight keuangan Anda</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
            </div>
        </div>
    </div>
</div>
@endsection