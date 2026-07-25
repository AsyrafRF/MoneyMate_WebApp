{{-- Modal Tambah Catatan --}}
<div class="modal fade" id="tambahKeuanganModal" tabindex="-1" aria-labelledby="tambahKeuanganLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-header-gradient text-white">
            <h5 class="modal-title id="tambahKeuanganLabel"">
            <i class="bi bi-pencil-square"></i>  Tambah Catatan Keuangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('keuangan.store') }}" method="POST" enctype="multipart/form-data" id="formTambahKeuangan"
                      data-is-premium="{{ $user->is_premium ? 'true' : 'false' }}"
                      data-current-saldo="{{ $user->saldo }}"
                      data-limit-saldo="{{ $limitSaldo }}"
                      data-sisa-upload="{{ $sisaUpload }}">
                    @csrf

                    <!-- Tanggal -->
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" 
                                name="tanggal" 
                                id="tanggal" 
                                class="form-control" 
                                value="{{ now()->format('Y-m-d') }}" 
                                required
                        >
                    </div>

                    <!-- Jenis -->
                    <div class="catat-field">
                        <label class="catat-field__label">Jenis</label>
                        <div class="catat-radio-group">
                            <label class="catat-radio">
                                <input type="radio" name="jenis" id="jenis_pemasukan" value="Pemasukan" required>
                                <span class="catat-radio__box"></span>
                                <span class="catat-radio__text">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/></svg>
                                    Pemasukan
                                </span>
                            </label>
                            <label class="catat-radio">
                                <input type="radio" name="jenis" id="jenis_pengeluaran" value="Pengeluaran" required>
                                <span class="catat-radio__box"></span>
                                <span class="catat-radio__text">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
                                    Pengeluaran
                                </span>
                            </label>
                        </div>
                        <p class="kat-field__error" id="errorJenis"></p>
                    </div>

                    <!-- Kategori -->
                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">Kategori</label>
                        <select name="kategori_id" id="kategori_id" class="form-control form-select select-kategori" required>
                            <option value="">-- Pilih Jenis Terlebih Dahulu --</option>
                        </select>
                    </div>

                    <!-- Tujuan Finansial -->
                    <div class="mb-3" id="tujuanWrapper" style="display:none;">
                        <label for="tujuan_id" class="form-label">Pilih Tujuan Finansial</label>
                        <select name="tujuan_id" id="tujuan_id" class="form-control">
                            <option value="">-- Pilih Tujuan --</option>
                            @foreach($tujuan as $t)
                                <option value="{{ $t->id }}">{{ $t->nama_tujuan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Nominal -->
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Nominal</label>
                        <input type="text" name="jumlah" class="form-control nominal input-nominal" id="jumlah" inputmode="numeric" required>
                        {{-- Tempat pesan error nominal --}}
                        <small class="error-limit-saldo text-danger mt-1 d-block" style="display:none;"></small>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                    </div>

                    <!-- Bukti -->
                    <div class="mb-3">
                        <button type="button" class="btn btn-sm btn-outline-secondary toggle-bukti">
                            <i class="bi bi-image"></i>
                            Opsional
                        </button>
                    </div>
                    <div class="mb-3 bukti-wrapper" style="display: none;">
                        <label for="bukti" class="form-label">Upload Bukti (jpg/png)</label>
                        <input type="file" id="bukti" name="bukti" class="form-control input-bukti" accept="image/*,application/pdf">
                        {{-- Tempat pesan error bukti --}}
                        <small class="error-limit-upload text-danger mt-1 d-block" style="display:none;"></small>
                        
                        <button type="button" class="btn btn-sm btn-outline-danger mt-2 hide-bukti">Tutup</button>
                    </div>
                </form>

                {{-- ==============================
                     INFO LIMIT FREEMIUM
                     ============================== --}}
                <div id="freemium-info-box" class="alert alert-light border d-none mb-3 p-2" role="alert" style="font-size: 0.9em; border-left: 4px solid #ffc107 !important;">
                    <div class="d-flex align-items-center mb-1">
                        <i class="bi bi-info-circle-fill text-warning me-2"></i>
                        <strong class="text-dark">Akun Gratis (Freemium)</strong>
                    </div>
                    
                    <!-- Bar Progress Saldo -->
                    <div class="mb-2">
                        <div class="d-flex justify-content-between text-muted small">
                            <span>Limit Saldo: <span id="info-saldo-text">0</span></span>
                            <span id="info-saldo-percent">0%</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div id="info-saldo-bar" class="progress-bar bg-warning" role="progressbar" style="width: 0%"></div>
                        </div>
                        <small class="text-danger fw-bold d-none mt-1" id="warning-saldo-exceed">
                            ⚠️ Transaksi ini melebihi batas saldo maksimal (Rp 6.000.000)!
                        </small>
                    </div>

                    <!-- Info Upload -->
                    <div class="d-flex justify-content-between text-muted small border-top pt-2">
                        <span>Sisa Kuota Upload Bukti:</span>
                        <span class="fw-bold" id="info-upload-text">0</span>
                    </div>
                </div>
                {{-- ============================== END INFO LIMIT ============================== --}}
            </div>
            <div class="modal-footer gap-2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formTambahKeuangan" class="btn btn-primary bg-btn-gradient">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formTambahKeuangan');
    const isPremium = form.getAttribute('data-is-premium') === 'true';
    const currentSaldo = parseInt(form.getAttribute('data-current-saldo')) || 0;
    const limitSaldo = parseInt(form.getAttribute('data-limit-saldo')) || 0;
    const sisaUpload = parseInt(form.getAttribute('data-sisa-upload')) || 0;

    // Elemen UI untuk Info Box
    const infoBox = document.getElementById('freemium-info-box');
    const infoSaldoText = document.getElementById('info-saldo-text');
    const infoSaldoBar = document.getElementById('info-saldo-bar');
    const infoSaldoPercent = document.getElementById('info-saldo-percent');
    const warningSaldoExceed = document.getElementById('warning-saldo-exceed');
    const infoUploadText = document.getElementById('info-upload-text');

    // Input Elements
    const inputJumlah = document.getElementById('jumlah');
    const radioPemasukan = document.getElementById('jenis_pemasukan');
    const radioPengeluaran = document.getElementById('jenis_pengeluaran');
    const inputBukti = document.getElementById('bukti');
    const errorLimitUpload = document.querySelector('.error-limit-upload');

    // Helper: Format Rupiah
    const formatRupiah = (number) => {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(number);
    };

    // Helper: Unformat (hilangkan titik dan Rp) untuk kalkulasi
    const unformatRupiah = (str) => {
        return parseInt(str.replace(/[^0-9]/g, '')) || 0;
    };

    // ============================
    // 1. INISIALISASI TAMPILAN
    // ============================
    if (!isPremium) {
        infoBox.classList.remove('d-none');
        
        // Set initial upload text
        infoUploadText.innerText = sisaUpload + " kali";
        if(sisaUpload <= 0) {
            infoUploadText.classList.add('text-danger');
        } else {
            infoUploadText.classList.add('text-success');
        }

        updateSaldoInfo(0); // Init saldo info dengan 0 input
    }

    // ============================
    // 2. LOGIKA UPDATE SALDO
    // ============================
    function updateSaldoInfo(inputNominal) {
        // Hitung persentase saat ini
        let percent = (currentSaldo / limitSaldo) * 100;
        if (percent > 100) percent = 100;

        infoSaldoBar.style.width = percent + '%';
        infoSaldoText.innerText = formatRupiah(currentSaldo) + " / " + formatRupiah(limitSaldo);
        infoSaldoPercent.innerText = Math.round(percent) + '%';

        // Warna Bar berubah jika hampir penuh
        if (percent >= 90) {
            infoSaldoBar.classList.remove('bg-warning', 'bg-success');
            infoSaldoBar.classList.add('bg-danger');
        } else if (percent >= 70) {
            infoSaldoBar.classList.remove('bg-danger', 'bg-success');
            infoSaldoBar.classList.add('bg-warning');
        } else {
            infoSaldoBar.classList.remove('bg-danger', 'bg-warning');
            infoSaldoBar.classList.add('bg-success');
        }

        // Cek apakah user sedang input Pemasukan
        const isPemasukan = radioPemasukan.checked;

        if (isPemasukan && inputNominal > 0) {
            // Proyeksi Saldo jika transaksi berhasil
            let projectedSaldo = currentSaldo + inputNominal;

            if (projectedSaldo > limitSaldo) {
                // Tampilkan peringatan
                warningSaldoExceed.classList.remove('d-none');
                infoSaldoBar.style.width = '100%';
                infoSaldoBar.classList.add('bg-danger');
                inputJumlah.classList.add('is-invalid');
            } else {
                // Sembunyikan peringatan
                warningSaldoExceed.classList.add('d-none');
                inputJumlah.classList.remove('is-invalid');
            }
        } else {
            warningSaldoExceed.classList.add('d-none');
            inputJumlah.classList.remove('is-invalid');
        }
    }

    // Event Listener saat mengetik nominal
    inputJumlah.addEventListener('input', function() {
        const val = unformatRupiah(this.value);
        updateSaldoInfo(val);
    });

    // Event Listener saat ganti jenis (Pemasukan/Pengeluaran)
    radioPemasukan.addEventListener('change', function() {
        const val = unformatRupiah(inputJumlah.value);
        updateSaldoInfo(val);
    });
    radioPengeluaran.addEventListener('change', function() {
        const val = unformatRupiah(inputJumlah.value);
        updateSaldoInfo(val);
    });

    // ============================
    // 3. LOGIKA UPLOAD BUKTI
    // ============================
    inputBukti.addEventListener('change', function() {
        if (!isPremium) {
            if (sisaUpload <= 0) {
                // Tampilkan error di bawah input
                errorLimitUpload.style.display = 'block';
                errorLimitUpload.innerText = "Gagal! Kuota upload bukti habis (0 kali tersisa).";
                this.value = ''; // Reset input
            } else {
                errorLimitUpload.style.display = 'none';
            }
        }
    });

    // ============================
    // 4. TOGGLE BUKTI (EXISTING LOGIC)
    // ============================
    document.querySelectorAll('.toggle-bukti').forEach(btn => {
        btn.addEventListener('click', function() {
            const wrapper = this.closest('form').querySelector('.bukti-wrapper');
            wrapper.style.display = 'block';
            this.style.display = 'none';
        });
    });

    document.querySelectorAll('.hide-bukti').forEach(btn => {
        btn.addEventListener('click', function() {
            const wrapper = this.closest('.bukti-wrapper');
            const toggleBtn = this.closest('form').querySelector('.toggle-bukti');
            const input = wrapper.querySelector('input[type="file"]');
            input.value = ''; // reset file
            wrapper.style.display = 'none';
            toggleBtn.style.display = 'inline-block';
            errorLimitUpload.style.display = 'none'; // Reset error msg
        });
    });
});
</script>