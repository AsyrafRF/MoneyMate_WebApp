@extends('layouts.home')

@section('title', 'Daftar')

@push('styles')
<link href="{{ asset('css/home/register.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card p-4 shadow-lg rounded" style="max-width: 400px; width: 100%;">
        <div class="text-center mb-4">
            <a href="/" class="d-inline-block animate__animated animate__fadeInDown">
                <img src="{{ asset('images/moneymate-original.png') }}" 
                     alt="Logo" 
                     class="logo" 
                     style="width: 90px;">
            </a>
        </div>
        <h4 class="text-center mb-4">Daftar Akun Baru</h4>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST" id="registerForm">
            @csrf

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email Asli" required>
            </div>

            {{-- Password --}}
            <div class="mb-3 position-relative">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" required placeholder="Masukkan password">
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword" aria-label="Lihat password">
                        <i class="bi bi-eye" id="iconPassword"></i>
                    </button>
                </div>
                <small id="strengthMessage" class="form-text mt-1"></small>
            </div>

            {{-- Konfirmasi Password --}}
            <div class="mb-3 position-relative">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi password">
                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirm" aria-label="Lihat konfirmasi password">
                        <i class="bi bi-eye" id="iconConfirm"></i>
                    </button>
                </div>
                <small id="passwordMessage" class="form-text mt-1"></small>
            </div>

            {{-- Tombol Daftar --}}
            <button type="submit" id="submitBtn" class="btn btn-primary bg-btn-gradient w-100 mb-2" disabled>Daftar</button>
        </form>

        <p class="text-center my-2">atau</p>

        <a href="{{ route('login.google') }}" 
           id="loadingBtn"
           class="btn btn-outline-secondary w-100">
            <img src="https://www.google.com/favicon.ico" alt="Google Logo" class="me-2" style="height: 1.25rem;">
            Daftar dengan Akun Google
        </a>

        <div class="text-center mt-3">
            <p class="small">Sudah Punya Akun? <a href="{{ route('login') }}">Masuk</a></p>
        </div>

        <hr class="footer-line">

        <!-- Bawah -->
        <footer class="money-mate-footer">
            <div class="footer-content">
                <div class="footer-copyright">
                    <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
                        <strong class="brand-name">
                            Money<span style="color: #2087bf;">Mate</span>
                        </strong>
                    </span>
                </div>
                <div class="footer-dev">
                    <span class="dev-text">Developed by</span> 
                    <span class="text-accent">PBL-TRPL621</span>
                </div>
            </div>
            <div class="footer-glow-line"></div>
        </footer>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const password = document.getElementById('password');
    const confirm = document.getElementById('password_confirmation');
    const strengthMessage = document.getElementById('strengthMessage');
    const confirmMessage = document.getElementById('passwordMessage');
    const submitBtn = document.getElementById('submitBtn');

    const togglePassword = document.getElementById('togglePassword');
    const toggleConfirm = document.getElementById('toggleConfirm');
    const iconPassword = document.getElementById('iconPassword');
    const iconConfirm = document.getElementById('iconConfirm');

    // === Fungsi Toggle Password ===
    function toggleVisibility(input, icon) {
        const type = input.type === 'password' ? 'text' : 'password';
        input.type = type;
        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');
    }

    togglePassword.addEventListener('click', () => toggleVisibility(password, iconPassword));
    toggleConfirm.addEventListener('click', () => toggleVisibility(confirm, iconConfirm));

    // === Cek Kekuatan Password ===
    function checkStrength() {
        const pass = password.value;
        let messages = [];

        if (pass.length < 8) messages.push("Minimal 8 karakter");
        if (!/[a-z]/.test(pass)) messages.push("Harus ada huruf kecil");
        if (!/[A-Z]/.test(pass)) messages.push("Harus ada huruf besar");
        if (!/[0-9]/.test(pass)) messages.push("Harus ada angka");
        if (!/[^A-Za-z0-9]/.test(pass)) messages.push("Harus ada simbol");

        if (messages.length > 0) {
            strengthMessage.textContent = "❌ Password lemah: " + messages.join(", ");
            strengthMessage.style.color = "red";
            password.classList.add('is-invalid');
            password.classList.remove('is-valid');
        } else {
            strengthMessage.textContent = "✅ Password kuat";
            strengthMessage.style.color = "green";
            password.classList.add('is-valid');
            password.classList.remove('is-invalid');
        }

        // Pastikan konfirmasi juga dicek ulang setiap kali password berubah
        checkMatch();
    }

    // === Cek Kecocokan Password ===
    function checkMatch() {
        const pass = password.value.trim();
        const conf = confirm.value.trim();

        // Jika konfirmasi kosong, reset pesan
        if (!conf) {
            confirmMessage.textContent = '';
            confirm.classList.remove('is-valid', 'is-invalid');
            submitBtn.disabled = true;
            return;
        }

        const passIsStrong = strengthMessage.textContent.includes('✅');

        if (pass === conf && passIsStrong) {
            confirmMessage.textContent = '✅ Password cocok';
            confirmMessage.style.color = 'green';
            confirm.classList.add('is-valid');
            confirm.classList.remove('is-invalid');
            submitBtn.disabled = false;
        } else if (pass !== conf) {
            confirmMessage.textContent = '❌ Password tidak cocok';
            confirmMessage.style.color = 'red';
            confirm.classList.add('is-invalid');
            confirm.classList.remove('is-valid');
            submitBtn.disabled = true;
        } else {
            confirmMessage.textContent = '⚠️ Password belum memenuhi kriteria';
            confirmMessage.style.color = 'orange';
            submitBtn.disabled = true;
        }
    }

    // Event listener
    password.addEventListener('input', checkStrength);
    confirm.addEventListener('input', checkMatch);
});
</script>
@endsection
