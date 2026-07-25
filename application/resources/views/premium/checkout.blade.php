@extends('layouts.app')

@section('title', 'Checkout Premium')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center justify-content-between flex-column flex-sm-row text-center text-sm-start">
                        <h4 class="mb-2 mb-sm-0 fw-bold text-primary">Detail Pembayaran Premium</h4>
                        
                        <div class="logo-wrapper">
                            <img src="{{ asset('images/moneymate-original.png') }}" 
                                alt="MoneyMate Logo" 
                                style="max-height: 40px; width: auto;" 
                                class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <h6 class="text-muted mb-1">Informasi Pelanggan:</h6>
                            <p class="mb-0"><strong>{{ Auth::user()->name }}</strong></p>
                            <p class="text-muted small">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <h6 class="text-muted mb-1">Nomor Invoice:</h6>
                            <p class="fw-bold text-dark">#{{ $invoice }}</p>
                        </div>
                    </div>

                    <hr class="my-4" style="border-top: 1px dashed #ddd;">

                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td>
                                        <p class="mb-0 fw-bold">Paket Premium ({{ $plan == 'monthly' ? 'Bulanan' : 'Tahunan' }})</p>
                                        <small class="text-muted">Akses penuh ke semua fitur premium</small>
                                    </td>
                                    <td class="text-end">Rp {{ number_format($baseAmount, 0, ',', '.') }}</td>
                                </tr>

                                @if($discount > 0)
                                    <tr class="text-success">
                                        <td>
                                            <p class="mb-0">Promo Member Baru (50%)</p>
                                            <small class="text-muted">*Tidak termasuk kode unik transfer</small>
                                        </td>
                                        <td class="text-end text-success">- Rp {{ number_format($discount, 0, ',', '.') }}</td>
                                    </tr>
                                @endif

                                <tr>
                                    <td>Kode Unik (Identifikasi Otomatis)</td>
                                    <td class="text-end text-danger">+{{ $uniqueCode }}</td>
                                </tr>

                                <tr class="border-top">
                                    <td class="fw-bold fs-5">Total Bayar</td>
                                    <td class="text-end fw-bold fs-5 text-primary">Rp {{ number_format($totalAmount, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="alert alert-light border p-3 mt-3">
                        <h6 class="fw-bold mb-3"><i class="bi bi-bank"></i> Instruksi Transfer:</h6>
                        
                        <div class="d-flex align-items-center mb-2">
                            <div class="me-3">
                                <strong>{{ $app_settings['bank_name'] ?? 'Bank Seabank' }}:</strong> 
                                <span id="norek" class="fw-bold ms-1" style="letter-spacing: 0.5px;">{{ $app_settings['bank_account_number'] ?? '9013 9685 7636' }}</span>
                            </div>
                            <button onclick="copyToClipboard()" class="btn btn-sm btn-outline-primary py-0 px-2" style="font-size: 0.75rem;">
                                Salin No
                            </button>
                        </div>

                        <div>
                            <strong>Merchant:</strong> 
                            <span class="fw-bold text-primary">
                                {{ $app_settings['bank_account_name'] ?? 'ASYRAF RAIS FADHIL' }}
                            </span>
                        </div>

                        <div class="mt-3 p-2 bg-light rounded border-start border-4 border-info" style="font-size: 0.85rem;">
                            <i class="bi bi-qr-code-scan me-1"></i> 
                            Atau ingin lebih praktis? Opsi <strong>QRIS / QR Code</strong> tersedia di halaman berikutnya.
                        </div>

                        <small class="text-muted mt-2 d-block">*Mohon transfer tepat sampai 3 digit terakhir agar sistem dapat mempercepat proses verifikasi.</small>
                    </div>

                    <form action="{{ route('premium.store') }}" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="plan" value="{{ $plan }}">
                        <input type="hidden" name="baseAmount" value="{{ $baseAmount }}">
                        <input type="hidden" name="uniqueCode" value="{{ $uniqueCode }}">
                        <input type="hidden" name="totalAmount" value="{{ $totalAmount }}">
                        <input type="hidden" name="invoice" value="{{ $invoice }}">
                        
                        <button type="submit" class="btn btn-gradient w-100 btn-lg shadow-sm">
                            Konfirmasi & Bayar Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard() {
    const norek = "901396857636"; // Versi angka tanpa spasi agar mudah di paste di m-banking
    navigator.clipboard.writeText(norek).then(() => {
        alert("Nomor rekening berhasil disalin!");
    }).catch(err => {
        console.error('Gagal menyalin: ', err);
    });
}
</script>

<style>
    /* Tambahan style jika diperlukan */
    .card { border-radius: 15px; }
    .btn-primary { background: linear-gradient(45deg, #007bff, #0056b3); border: none; }
    .btn-primary:hover { background: linear-gradient(45deg, #0056b3, #004085); transition: 0.3s; }
</style>
@endsection