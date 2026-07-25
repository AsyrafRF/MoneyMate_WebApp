<x-guest-layout>
    <div class="text-center mb-4 animate__animated animate__fadeInDown" data-aos="fade-down">
        <div class="text-muted mb-2">
            <i class="bi bi-envelope-check-fill text-primary fs-3 mb-2 d-block"></i>
            Terima kasih sudah mendaftar! 💙<br>
            Sebelum lanjut, silakan cek email kamu untuk kode verifikasi.<br>
        </div>
    </div>

    {{-- ✅ Pesan sukses --}}
    @if (session('message'))
        <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- ❗Pesan Peringatan --}}
    @if (session('warning'))
        <div class="alert alert-warning text-center">
            {{ session('warning') }}
        </div>
    @endif

    {{-- ℹ️ Pesan Informasi --}}
    @if (session('info'))
        <div class="alert alert-info text-center">
            {{ session('info') }}
        </div>
    @endif

    {{-- ⚠️ Pesan error --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="text-center mb-3">
        <small class="text-muted">
            Kode berlaku selama:
            <span id="countdown" class="fw-bold text-primary"></span>
        </small>
    </div>

    {{-- 💌 Form verifikasi Email --}}
    <form method="POST" action="{{ route('verification.verify.otp') }}">
        @csrf

        <div class="d-flex justify-content-center gap-2 mb-3">
            @for ($i = 0; $i < 6; $i++)
                <input type="text"
                    maxlength="1"
                    class="otp-input form-control text-center"
                    style="width:50px; height:50px; font-size:20px;"
                    inputmode="numeric"
                    required>
            @endfor
        </div>

        <input type="hidden" name="otp" id="otp">

        <button type="submit" class="btn btn-primary w-100">
            Verifikasi
        </button>
    </form>

    {{-- 🔃 Resend(Kirim Ulang) Kode OTP --}}
    <form method="POST" action="{{ route('verification.resend.otp') }}">
        @csrf
        <button id="resendBtn" class="btn btn-link mt-3" disabled>
            Kirim Ulang OTP
        </button>
    </form>

    {{-- Auto Merge, Focus, & Paste OTP Input --}}
    <script>
        const inputs = document.querySelectorAll('.otp-input');
        const hiddenInput = document.getElementById('otp');
        const form = hiddenInput.closest('form'); // Mengambil form verifikasi

        inputs.forEach((input, index) => {
            // 1. Menangani input manual (ketik satu per satu)
            input.addEventListener('input', (e) => {
                // Hanya menerima angka (jika ada karakter non-angka, hapus)
                input.value = input.value.replace(/[^0-9]/g, '');

                if (input.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }

                updateHiddenInput();
            });

            // 2. Menangani tombol Backspace (mundur ke kotak sebelumnya)
            input.addEventListener('keydown', (e) => {
                if (e.key === "Backspace") {
                    if (!input.value && index > 0) {
                        inputs[index - 1].focus();
                        inputs[index - 1].value = ''; // Opsional: langsung hapus angka di belakangnya
                        updateHiddenInput();
                    }
                }
            });

            // 3. FITUR UTAMA: Menangani Paste (Salin-Tempel) 6 Angka
            input.addEventListener('paste', (e) => {
                e.preventDefault(); // Mencegah text bawaan masuk ke satu kotak saja
                
                // Ambil data dari clipboard dan bersihkan dari karakter non-angka
                const pasteData = (e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '');
                
                if (pasteData.length > 0) {
                    // Pecah angka dan masukkan ke setiap input dimulai dari kotak yang aktif/difokuskan
                    let pasteIndex = 0;
                    for (let i = index; i < inputs.length; i++) {
                        if (pasteData[pasteIndex]) {
                            inputs[i].value = pasteData[pasteIndex];
                            pasteIndex++;
                        }
                    }
                    
                    // Pindahkan fokus ke input terakhir atau input kosong berikutnya
                    const nextFocusIndex = Math.min(index + pasteData.length, inputs.length - 1);
                    inputs[nextFocusIndex].focus();
                    
                    updateHiddenInput();

                    // Opsional: Jika pas 6 angka, otomatis submit form
                    if (hiddenInput.value.length === 6) {
                        form.submit();
                    }
                }
            });
        });

        // Fungsi untuk menggabungkan semua nilai box ke hidden input
        function updateHiddenInput() {
            hiddenInput.value = Array.from(inputs).map(i => i.value).join('');
        }
    </script>

    {{-- COUNTDOWN + AUTO ENABLE --}}
    <script>
        const expireTimestamp = {{ session('otp_expires_at') ?? 0 }};
        const countdownElement = document.getElementById('countdown');
        const resendBtn = document.getElementById('resendBtn');

        function startCountdown() {
            const interval = setInterval(() => {
                const now = Math.floor(Date.now() / 1000);
                const remaining = expireTimestamp - now;

                if (remaining <= 0) {
                    clearInterval(interval);
                    countdownElement.innerHTML = "00:00";
                    resendBtn.disabled = false;
                    resendBtn.classList.remove('text-muted');
                    return;
                }

                const minutes = Math.floor(remaining / 60);
                const seconds = remaining % 60;

                countdownElement.innerHTML =
                    String(minutes).padStart(2, '0') + ":" +
                    String(seconds).padStart(2, '0');
            }, 1000);
        }

        if (expireTimestamp > 0) {
            startCountdown();
        }
    </script>
</x-guest-layout>
