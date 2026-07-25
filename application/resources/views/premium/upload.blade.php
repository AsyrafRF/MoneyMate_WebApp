@extends('layouts.app')

@section('title', 'Konfirmasi Pembayaran')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center mb-4">
                <img src="{{ asset('images/moneymate-original.png') }}" alt="MoneyMate Logo" style="height: 60px;">
            </div>  

            <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <h4 class="text-center fw-bold mb-4">Selesaikan Pembayaran</h4>

                    {{-- ⚠️ Pesan Peringatan --}}
                    @if (session('warning'))
                        <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
                            {{ session('warning') }}
                        </div>
                    @endif

                    <div class="alert alert-light border-0 bg-light p-3 mb-4 text-center">
                        <p class="text-muted small mb-2">Silakan transfer tepat sejumlah:</p>
                        <h2 class="fw-bold text-primary mb-3">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</h2>
                        
                        <!-- Tab Metode Pembayaran -->
                        <ul class="nav nav-pills nav-fill mb-3" id="paymentTabs" role="tablist" style="border-radius: 12px; overflow: hidden; background: #e9ecef; padding: 3px;">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fw-semibold py-2" id="tab-rekening" data-bs-toggle="pill" data-bs-target="#panel-rekening" type="button" role="tab" style="border-radius: 10px; font-size: 0.85rem;">
                                    <i class="bi bi-bank me-1"></i> Transfer Bank
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-semibold py-2" id="tab-qris" data-bs-toggle="pill" data-bs-target="#panel-qris" type="button" role="tab" style="border-radius: 10px; font-size: 0.85rem;">
                                    <i class="bi bi-qr-code me-1"></i> QR Code
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="paymentTabContent">
                            <!-- Panel Transfer Bank -->
                            <div class="tab-pane fade show active p-3 bg-white rounded shadow-sm border" id="panel-rekening" role="tabpanel">
                                <div class="d-inline-block p-3 bg-white rounded shadow-sm border w-100 text-start">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <small class="text-muted d-block">{{ $app_settings['bank_name'] ?? 'Bank Seabank' }}</small>
                                            <span id="rekening" class="fw-bold fs-5" style="letter-spacing: 1px;">{{ $app_settings['bank_account_number'] ?? '9013 9685 7636' }}</span>
                                        </div>
                                        <button onclick="copyRekening()" class="btn btn-outline-primary btn-sm rounded-pill">
                                            <i class="bi bi-copy"></i> Salin
                                        </button>
                                    </div>
                                    <hr class="my-2">
                                    <small class="text-muted d-block">Atas Nama:</small>
                                    <span class="fw-bold text-primary">{{ $app_settings['bank_account_name'] ?? 'ASYRAF RAIS FADHIL' }}</span>
                                </div>
                            </div>

                            <!-- Panel QR Code -->
                            <div class="tab-pane fade p-4 bg-white rounded shadow-sm border text-center" id="panel-qris" role="tabpanel">
                                <div class="my-3">
                                    <!-- Ikon Peringatan/Informasi -->
                                    <div class="d-inline-flex align-items-center justify-content-center bg-warning bg-opacity-10 text-warning rounded-circle mb-3" style="width: 60px; height: 60px;">
                                        <i class="bi bi-exclamation-triangle-fill fs-3"></i>
                                    </div>
                                    
                                    <h5 class="fw-bold text-dark mb-2">QRIS Belum Tersedia</h5>
                                    <p class="text-muted small mx-auto mb-4" style="max-width: 280px;">
                                        Mohon maaf, saat ini metode pembayaran via QR Code/QRIS belum bisa digunakan.
                                    </p>
                                    
                                    <!-- Informasi Alternatif -->
                                    <div class="p-3 bg-light rounded-3 border border-dashed text-start">
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <i class="bi bi-info-circle-fill text-primary small"></i>
                                            <span class="fw-semibold small text-secondary">Solusi Pembayaran:</span>
                                        </div>
                                        <p class="small text-muted mb-0">
                                            Silakan gunakan tab <strong>Transfer Bank</strong> di atas untuk mengirimkan pembayaran ke nomor rekening Admin MoneyMate resmi.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-primary mb-3">
                        <div class="card-body text-primary">
                            <h5 class="card-title">Batas Waktu Pembayaran</h5>
                            <p class="card-text">
                                Segera lakukan pembayaran dan upload bukti sebelum: <br>
                                <strong>{{ $transaction->created_at->addHours(24)->format('d M Y, H:i') }} WIB</strong>
                            </p>
                            <small>*Jika lewat dari batas waktu, transaksi akan dibatalkan otomatis.</small>
                        </div>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger" style="background-color: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                            <strong>Oops!</strong> {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('premium.checkoutUpload', $transaction->id) }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                        @csrf
                        <div class="form-group mb-4">
                            <label class="fw-bold mb-2">Unggah Bukti Transfer</label>
                            
                            <div class="upload-area p-4 border-2 border-dashed rounded text-center" id="dropzone" style="border: 2px dashed #dee2e6; cursor: pointer; transition: 0.3s;">
                                <i class="bi bi-cloud-arrow-up display-4 text-muted"></i>
                                <p class="small text-muted mt-2">Klik atau tarik gambar ke sini</p>
                                <input type="file" name="proof" id="proofInput" class="form-control d-none @error('proof') is-invalid @enderror" accept="image/jpeg,image/png">
                                <div id="fileName" class="fw-bold text-primary mt-2 small"></div>
                            </div>
                            
                            <div id="error-message" class="text-danger small mt-2" style="display: none;"></div>
                            <small class="text-muted mt-2 d-block">
                                * Format: <strong>JPG, PNG</strong> (Maks. 2MB)
                            </small>

                            @error('proof')
                                <span style="color: red; font-size: 0.8rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-gradient w-100 py-3 fw-bold rounded-pill shadow-sm" id="submitBtn">
                            Konfirmasi Pembayaran
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="{{ route('dashboard.index') }}" class="text-muted text-decoration-none small"><i class="bi bi-arrow-left"></i> Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</div>

<style>
    .upload-area:hover {
        background-color: #f8f9fa;
        border-color: #0d6efd !important;
    }
    .border-dashed { border-style: dashed !important; }

    /* Custom Tab Active */
    #paymentTabs .nav-link {
        color: #6c757d;
        transition: all 0.3s ease;
    }
    #paymentTabs .nav-link.active {
        background-color: #ffffff !important;
        color: #0d6efd !important;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }
    #paymentTabs .nav-link:not(.active):hover {
        color: #0d6efd;
        background-color: rgba(255,255,255,0.5);
    }

    /* Panel QR Code hover effect */
    #panel-qris img {
        transition: transform 0.3s ease;
    }
    #panel-qris img:hover {
        transform: scale(1.03);
    }
</style>

<script>
const input = document.getElementById('proofInput');
const dropzone = document.getElementById('dropzone');
const fileNameDisplay = document.getElementById('fileName');
const errorMessage = document.getElementById('error-message');
const submitBtn = document.getElementById('submitBtn');

// Trigger input klik saat area dropzone diklik
dropzone.addEventListener('click', () => input.click());

input.addEventListener('change', function() {
    validateFile(this.files[0]);
});

function validateFile(file) {
    errorMessage.style.display = 'none';
    fileNameDisplay.innerText = '';
    
    if (!file) return;

    // Validasi Tipe File
    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    if (!allowedTypes.includes(file.type)) {
        showError("Format file tidak didukung! Harap gunakan JPG atau PNG.");
        return;
    }

    // Validasi Ukuran File (2MB = 2048 * 1024 bytes)
    if (file.size > 2 * 1024 * 1024) {
        showError("Ukuran file terlalu besar! Maksimal adalah 2MB.");
        return;
    }

    // Jika lolos validasi
    fileNameDisplay.innerText = "File terpilih: " + file.name;
    submitBtn.disabled = false;
}

function showError(msg) {
    errorMessage.innerText = msg;
    errorMessage.style.display = 'block';
    input.value = ''; // Reset input
    fileNameDisplay.innerText = '';
    submitBtn.disabled = true;
}

function copyRekening() {
    const text = document.getElementById("rekening").innerText.replace(/\s/g, '');
    navigator.clipboard.writeText(text).then(() => {
        alert("Nomor rekening berhasil disalin!");
    });
}
</script>
@endsection