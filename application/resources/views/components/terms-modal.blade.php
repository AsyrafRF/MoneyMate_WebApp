<!-- resources/views/components/terms-modal.blade.php -->

<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">

            <!-- Body: Konten Tunggal (Single Scroll) -->
            <div class="modal-body px-4 py-2">
                <div class="text-center mb-3">
                    <img src="{{ asset('images/moneymate-original.png') }}" alt="MoneyMate Logo" class="inline-block" style="width: 70px;">
                </div>
                <h4 class="modal-title fw-bold text-dark text-center" id="termsModalLabel">Persetujuan Layanan</h4>
                <p class="text-muted small text-center px-4">Mohon tinjau dokumen hukum kami sebelum melanjutkan penggunaan aplikasi.</p>

                <div class="legal-container bg-light text-dark rounded-3 p-4 border">
                    <x-content-terms :version="$version" />
                </div>
            </div>

            <!-- Footer: Form Action -->
            <div class="modal-footer border-0 flex-column px-4 pb-4">
                <form method="POST" action="{{ route('acceptance.terms') }}" id="form-accept" class="w-100">
                    @csrf
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input custom-check" id="agreement_check_modal" name="agreement_check" value="1">
                        <label class="form-check-label small text-secondary" for="agreement_check_modal">
                            Saya telah membaca dan menyetujui seluruh isi dokumen di atas tanpa pengecualian.
                        </label>
                    </div>

                    <div class="d-flex gap-2 w-100">
                        <a href="{{ route('logout') }}" 
                           id="loadingBtn" 
                           onclick="event.preventDefault(); document.getElementById('logout-form-modal').submit();" 
                           class="btn btn-light text-muted fw-bold px-4 py-2 border w-50">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary-custom text-dark fw-bold px-4 py-2 w-50" id="btn-accept-modal" disabled>
                            Terima & Lanjutkan
                        </button>
                    </div>
                </form>

                <!-- Hidden Logout Form -->
                <form id="logout-form-modal" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link href="{{ asset('css/auth/terms/modal-style.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('js/button-loading.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalEl = document.getElementById('termsModal');
        
        if (modalEl) {
            const modal = new bootstrap.Modal(modalEl);
            modal.show();

            const checkbox = document.getElementById('agreement_check_modal');
            const btn = document.getElementById('btn-accept-modal');
            const form = document.getElementById('form-accept');

            checkbox.addEventListener('change', function() {
                btn.disabled = !this.checked;
            });

            form.addEventListener('submit', function() {
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';
            });
        }
    });
</script>
@endpush