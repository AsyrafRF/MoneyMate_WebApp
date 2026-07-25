@extends('layouts.home')

@section('title', 'Masuk')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh; padding: 50px 0;">
    <div class="card p-4 shadow-lg rounded" style="max-width: 400px; width: 100%;">
        
        <div class="text-center mb-4">
            <img src="{{ asset('images/moneymate-original.png') }}" alt="MoneyMate Logo" style="width: 90px;">
            <p class="text-muted fst-italic mt-3 mb-0">Silahkan masukkan Email dan Password anda</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> {{ session('error') }}
            </div>
        @endif

        @if(session('status'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>INFO:</strong> {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning text-center">
                {{ session('warning') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            {{-- Email --}}
            <div class="mb-3">
                <label for="login_email" class="form-label fw-semibold">Email</label>
                <input type="email" class="form-control form-control-lg" id="login_email" name="email" placeholder="Masukkan email" required>
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <label for="login_password" class="form-label fw-semibold">Password</label>
                <div class="input-group input-group-lg">
                    <input type="password" class="form-control" id="login_password" name="password" placeholder="Masukkan password" required>
                    <button type="button" class="btn btn-outline-secondary" id="toggleLoginPassword" title="Lihat Password">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            {{-- Tombol --}}
            <button type="submit" class="btn btn-primary bg-btn-gradient w-100 mt-3">Masuk</button>
        </form>

        <p class="text-center text-muted my-3">atau</p>

        <livewire:google />

        <div class="text-center small mt-3">
            <p class="mb-1">Belum punya akun? 
                <a href="{{ route('register') }}" class="text-primary fw-bold">Daftar</a>
            </p>
            <p class="mb-0">Lupa password? 
                <a href="{{ route('password.request') }}" class="text-primary fw-bold">Ubah Password</a>
            </p>
        </div>
    </div>
</div>
@endsection
