@extends('layouts.app')

@section('title', 'Aktivasi Kupon')

@section('content')
<div class="container py-4 py-md-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="text-center mb-4">
                <img src="{{ asset('images/moneymate-original.png') }}" alt="MoneyMate Logo" style="height: 60px;">
            </div> 

            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div style="height: 6px;" class="bg-success"></div>
                
                <div class="card-body text-center p-4 p-md-5">
                    <div class="mb-4">
                        <div class="display-1 text-success">
                            <i class="bi bi-patch-check-fill"></i> {{-- Gunakan Bootstrap Icons --}}
                            <span style="font-size: 3rem;">🎉</span>
                        </div>
                    </div>

                    <h2 class="fw-bold text-dark mb-2">Aktivasi Berhasil!</h2>
                    <p class="text-muted mb-4 px-md-4">
                        {{ session('success') ?? 'Trial Premium Anda kini telah aktif. Selamat menikmati fitur eksklusif kami.' }}
                    </p>

                    <div class="bg-light rounded-4 p-3 p-md-4 mb-4 text-start">
                        <h6 class="fw-bold text-secondary text-uppercase small mb-3 border-bottom pb-2">
                            Detail Membership
                        </h6>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Paket</span>
                            <span class="fw-bold text-primary">{{ ucfirst(auth()->user()->subscription_plan) }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Durasi</span>
                            <span class="fw-bold">{{ Auth::user()->subscription_days_left }} Hari</span>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Berlaku Sampai</span>
                            <span class="fw-bold">{{ auth()->user()->subscription_until->translatedFormat('d F Y') }}</span>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ route('dashboard.index') }}" class="btn btn-primary btn-lg rounded-pill fw-bold">
                            Ke Dashboard Utama
                        </a>
                        <button onclick="window.print()" class="btn btn-link btn-sm text-decoration-none text-muted d-none d-md-block">
                            <i class="bi bi-printer me-1"></i> Cetak Bukti
                        </button>
                    </div>
                </div>
            </div>

            <p class="text-center text-muted mt-4 small">
                Butuh bantuan? <a href="mailto:moneymate.app.id@gmail.com" class="text-decoration-none">Hubungi Support</a>
            </p>
        </div>
    </div>
</div>

<style>
    /* Tambahan agar tampilan lebih manis di mobile */
    .card {
        transition: transform 0.3s ease;
    }
    
    @media (max-width: 576px) {
        h2 {
            font-size: 1.5rem;
        }
        .card-body {
            padding: 1.5rem !important;
        }
        .bg-light {
            font-size: 0.9rem;
        }
    }

    /* Support untuk icon jika belum ada */
    @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css");
</style>
@endsection