<!-- Modal Tambah Tujuan -->
<div class="modal fade" id="tambahNominalModal" tabindex="-1" aria-labelledby="tambahNominalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header modal-header-gradient text-white" style="border-bottom: none;">
                <h5 class="modal-title fw-bold mx-auto" id="tambahNominalLabel">
                    <i class="fa-solid fa-coins"></i>
                    Tambah Tujuan Finansial
                </h5>
            </div>

            <div class="modal-body">

                <!-- ===================== FORM TAMBAH TUJUAN ===================== -->
                <form id="formTambah" action="{{ route('tujuan.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Tujuan</label>
                        <input type="text" name="nama_tujuan" class="form-control text-center" placeholder="Contoh: Beli Rumah" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Target Nominal</label>
                        <input type="text" name="target_nominal" class="form-control text-center nominal" placeholder="Masukkan berapa target anda" inputmode="numeric" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nominal Saat Ini</label>
                        <!-- Tambahkan info saldo di bawah ini -->
                        <div id="saldoInfo" class="text-muted small mb-1" data-saldo="{{ auth()->user()->total_saldo }}">
                            Saldo tersedia: Rp {{ number_format(auth()->user()->total_saldo, 0, ',', '.') }}
                        </div>
                        <input type="text" id="nominalSaatIni" name="nominal_saat_ini" class="form-control text-center nominal" placeholder="Masukkan nominal awal (Isi 0 jika belum ada)" inputmode="numeric">
                        <!-- Tempat memunculkan pesan error jika melebihi saldo -->
                        <div id="errorSaldo" class="text-danger small mt-1" style="display: none;"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deadline</label>
                        <input type="date" name="deadline" class="form-control text-center" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary px-4 rounded-3">Simpan Tujuan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const inputNominal = document.getElementById("nominalSaatIni");
    const saldoInfo = document.getElementById("saldoInfo");
    const errorSaldo = document.getElementById("errorSaldo");
    const formTambah = document.getElementById("formTambah");
    const btnSubmit = formTambah.querySelector('button[type="submit"]');

    // Ambil total saldo dari data attribute HTML
    const totalSaldo = parseFloat(saldoInfo.getAttribute("data-saldo")) || 0;

    // Fungsi helper untuk membersihkan format ribuan menjadi angka murni
    function koverKeAngka(isiInput) {
        // Menghapus semua karakter selain angka (menghindari bug format titik/koma)
        return parseFloat(isiInput.replace(/[^0-9]/g, "")) || 0;
    }

    // Fungsi helper untuk memformat angka menjadi format Rupiah standar
    function formatRupiah(angka) {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            minimumFractionDigits: 0
        }).format(angka);
    }

    // Jalankan validasi setiap kali user mengetik
    inputNominal.addEventListener("input", function () {
        const nominalInput = koverKeAngka(this.value);
        
        // Hitung sisa saldo secara dinamis
        const sisaSaldo = totalSaldo - nominalInput;

        if (nominalInput > totalSaldo) {
            // 1. Tampilkan pesan error
            errorSaldo.textContent = `Nominal melebihi saldo! Maksimal: ${formatRupiah(totalSaldo)}`;
            errorSaldo.style.display = "block";
            
            // 2. Berikan highlight merah pada input (Bootstrap class)
            inputNominal.classList.add("is-invalid");
            
            // 3. Kunci tombol submit agar tidak bisa diklik
            btnSubmit.disabled = true;

            // 4. Update info saldo menjadi 0
            saldoInfo.innerHTML = `Sisa saldo setelah dialokasikan: <span class="text-danger fw-bold">${formatRupiah(0)}</span>`;
        } else {
            // Jika valid/aman
            errorSaldo.style.display = "none";
            inputNominal.classList.remove("is-invalid");
            btnSubmit.disabled = false;

            // Tampilkan sisa saldo real-time yang terus berkurang sesuai inputan
            saldoInfo.innerHTML = `Sisa saldo setelah dialokasikan: <span class="text-success fw-bold">${formatRupiah(sisaSaldo)}</span>`;
        }
    });
});
</script>