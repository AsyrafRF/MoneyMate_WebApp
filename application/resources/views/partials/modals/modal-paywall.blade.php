<div class="modal fade" id="paywallModal" tabindex="-1" aria-labelledby="paywallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header modal-header-gradient text-white border-0">
                <h5 class="modal-title fw-bold" id="paywallModalLabel">
                    <i class="bi bi-gem me-2"></i> Fitur Premium
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4">
                <div class="mb-3">
                    <i class="bi bi-lock-fill text-warning" style="font-size: 3rem;"></i>
                </div>
                <h4 class="fw-bold">Batas Maksimal Tercapai!</h4>
                <p class="text-muted">
                    Kamu saat ini menggunakan <strong>Akun Freemium</strong>. Untuk menggunakan layanan eksklusif MoneyMate, silakan berlangganan ke paket Premium.
                </p>
                
                <div class="bg-light p-3 rounded-3 mb-3 text-start">
                    <ul class="list-unstyled mb-0">
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i> Kategori kustom & tambahan</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i> Tujuan Finansial Tanpa Batas</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i> Batas Saldo lebih dari Rp. 6.000.000</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer border-0 pb-4 justify-content-center">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Nanti Saja</button>
                <a href="{{ route('premium.upgrade') }}" class="btn btn-primary px-4 fw-bold shadow-sm">
                    Upgrade Sekarang <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(45deg, #4e73df 0%, #224abe 100%);
    }
</style>