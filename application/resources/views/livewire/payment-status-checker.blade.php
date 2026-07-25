<div class="container py-5" @if($transaction->status == 'verifying') wire:poll.3s @endif>
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            
            <div class="mb-4">
                @if($transaction->status == 'verifying')
                    <h3 class="fw-bold text-warning">Menunggu Verifikasi</h3>
                @elseif($transaction->status == 'success')
                    <h3 class="fw-bold text-success">Pembayaran Berhasil!</h3>
                @else
                    <h3 class="fw-bold text-danger">Pembayaran Gagal</h3>
                @endif
                <p class="text-muted small">ID Transaksi: <span class="fw-bold">#{{ $transaction->invoice_number }}</span></p>
            </div>

            <div class="card shadow-lg border-0 overflow-hidden" style="border-radius: 20px;">
                <div class="card-body p-0">
                    
                    @if($transaction->status == 'verifying')
                        <div class="p-5">
                            <div class="spinner-wrapper mb-4">
                                <svg width="80" height="80" viewBox="0 0 50 50" class="animate-spin" style="animation: spinner-border 1s linear infinite;">
                                    <circle cx="25" cy="25" r="20" fill="none" stroke="#e9ecef" stroke-width="4"></circle>
                                    <circle cx="25" cy="25" r="20" fill="none" stroke="#007bff" stroke-width="4" stroke-linecap="round" stroke-dasharray="80, 150"></circle>
                                </svg>
                            </div>
                            <h5 class="fw-bold">Kami sedang memproses pembayaran Anda</h5>
                            <p class="text-muted px-lg-5">Tim kami sedang melakukan verifikasi manual terhadap transfer Anda. Proses ini biasanya memakan waktu 10-30 menit (maksimal 1x24 jam).</p>
                            
                            <div class="alert alert-info border-0 bg-light-primary mt-4 mx-lg-4 text-start">
                                <small class="d-block mb-2 text-primary fw-bold text-uppercase"><i class="bi bi-lightning-fill"></i> Ingin proses lebih cepat?</small>
                                <p class="small mb-2">Kirimkan bukti transfer Anda langsung ke WhatsApp Admin untuk aktivasi instan:</p>
                                @php
                                    $message = "Halo Admin MoneyMate, saya ingin konfirmasi pembayaran:\n\n"
                                            . "-> No Invoice: " . $transaction->invoice_number . "\n"
                                            . "-> Kode Unik: " . $transaction->unique_code . "\n"
                                            . "-> Total Bayar: Rp " . number_format($transaction->total_amount, 0, ',', '.') . "\n\n"
                                            . "Berikut bukti pembayaran dilampirkan di bawah ini:\n"
                                            . "(Tolong jangan mengubah isi chat ini agar mempercepat proses verifikasi anda)";
                                @endphp
                                <a href="https://wa.me/{{ $app_settings['wa_number'] ?? '6282172437617' }}?text={{ urlencode($message) }}" 
                                target="_blank" 
                                class="btn btn-sm btn-success rounded-pill px-3">
                                    <i class="bi bi-whatsapp me-1"></i> Hubungi WhatsApp Admin
                                </a>
                            </div>
                        </div>

                    @elseif($transaction->status == 'success')
                        <div class="bg-general-gradient py-4 text-white">
                            <i class="bi bi-check-circle-fill display-3"></i>
                            <h4 class="mt-2 mb-0">Transaksi Selesai</h4>
                        </div>

                        <div class="p-4 text-start">
                            <div class="row g-4">
                                <div class="col-md-6 border-end">
                                    <h6 class="fw-bold mb-3">Detail Transaksi:</h6>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted small">Paket</span>
                                        <span class="small fw-bold">{{ $transaction->plan == 'monthly' ? 'Bulanan' : 'Tahunan' }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted small">Metode</span>
                                        <span class="small">{{ $transaction->payment_method ?? 'Transfer' }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted small">Total</span>
                                        <span class="small fw-bold text-primary">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                                    </div>
                                    <hr>
                                    <p class="text-muted x-small italic">Akses Anda berlaku hingga: <br><strong>{{ \Carbon\Carbon::parse($transaction->user->subscription_until)->format('d M Y, H:i') }} WIB</strong></p>
                                </div>
                                
                                <div class="col-md-6">
                                    <h6 class="fw-bold mb-3">Benefit Premium Anda:</h6>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2 small"><i class="bi bi-patch-check-fill text-primary me-2"></i> Akses Seluruh Fitur Premium</li>
                                        <li class="mb-2 small"><i class="bi bi-patch-check-fill text-primary me-2"></i> Kategori kustom & tambahan</li>
                                        <li class="mb-2 small"><i class="bi bi-patch-check-fill text-primary me-2"></i> Tujuan Finansial Tanpa Batas</li>
                                        <li class="mb-2 small"><i class="bi bi-patch-check-fill text-primary me-2"></i> Batas Saldo lebih dari Rp. 6.000.000</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('tujuan.index') }}" class="btn btn-gradient w-100 py-2 rounded-pill shadow-sm fw-bold">
                                    Mulai Gunakan Fitur Premium
                                </a>
                            </div>
                        </div>

                    @elseif($transaction->status == 'failed')
                        <div class="p-5 text-center">
                            <i class="bi bi-x-circle-fill text-danger display-3"></i>
                            <h4 class="mt-3">Pembayaran Tidak Valid</h4>
                            <p class="text-muted px-lg-5">Sistem kami mendeteksi ketidaksesuaian data atau transaksi dibatalkan. Jika Anda merasa ini adalah kesalahan, silakan hubungi bantuan.</p>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                                <a href="/premium/checkout" class="btn btn-outline-danger px-4">Coba Lagi</a>
                                <a href="mailto:moneymate.app.id@gmail.com" class="btn btn-light px-4 border text-muted">Bantuan Email</a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

            @if($transaction->proof_path)
                <div class="my-4 p-3 bg-light rounded border text-start mx-lg-4">
                    <small class="d-block mb-2 text-muted fw-bold text-uppercase">Bukti Pembayaran Anda:</small>
                    <div class="text-center bg-white p-2 rounded border" style="max-height: 300px; overflow: hidden;">
                        <img src="{{ asset('storage/' . $transaction->proof_path) }}" 
                            alt="Bukti Pembayaran" 
                            class="img-fluid rounded" 
                            style="max-height: 280px; object-fit: contain;">
                    </div>
                </div>
            @endif

            <div class="mt-4">
                <p class="text-muted small">Mengalami kendala teknis? Hubungi kami di <a href="mailto:moneymate.app.id@gmail.com" class="text-decoration-none fw-bold">moneymate.app.id@gmail.com</a></p>
            </div>
        </div>
    </div>
</div>