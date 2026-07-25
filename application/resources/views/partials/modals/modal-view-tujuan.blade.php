{{-- ========================= --}}
{{--  MODAL DETAIL TUJUAN     --}}
{{-- ========================= --}}
<div class="modal fade" id="viewTujuanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg border-0">

            <!-- Header -->
            <div class="modal-header modal-header-gradient text-white" style="border-bottom: none;">
                <h5 class="modal-title fw-semibold text-white mx-auto">Detail Tujuan</h5>
            </div>

            <!-- Body -->
            <div class="modal-body px-4 py-4">

                <!-- Detail Card Rows -->
                <div class="detail-row">
                    <span class="label">Nama Tujuan</span>
                    <span class="value" id="viewNama"></span>
                </div>

                <div class="detail-row">
                    <span class="label">Target Nominal</span>
                    <span class="value">Rp <span id="viewTarget"></span></span>
                </div>

                <div class="detail-row">
                    <span class="label">Nominal Saat Ini</span>
                    <span class="value">Rp <span id="viewNominal"></span></span>
                </div>

                <div class="detail-row">
                    <span class="label">Deadline</span>
                    <span class="value" id="viewDeadline"></span>
                </div>

                <!-- Progress Bar -->
                <div class="mt-4">
                    <label class="fw-semibold mb-1">Progress</label>
                    <div class="progress" style="height: 10px; border-radius: 20px;">
                        <div id="progressBar" class="progress-bar" 
                             style="width: 0%; border-radius: 20px;"></div>
                    </div>
                    <div class="text-end small mt-1 fw-semibold" id="progressText">0%</div>
                </div>

                <!-- Divider -->
                <hr class="my-4">

                <!-- Action Buttons -->
                <div id="tujuanActionContainer"></div>

            </div>
        </div>
    </div>
</div>

<script>
    function updateProgress(nominal, target) {
        const percentage = Math.min(Math.round((nominal / target) * 100), 100);
        document.getElementById("progressBar").style.width = persen + "%";
        document.getElementById("progressBar").style.backgroundColor = warna;
        document.getElementById("progressText").textContent = persen + "%";
    }
</script>

{{-- ========================= --}}
{{--  MODAL EDIT TUJUAN       --}}
{{-- ========================= --}}
<div class="modal fade" id="editTujuanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg border-0">

            <div class="modal-header modal-header-gradient text-white" style="border-bottom: none;">
                <h5 class="modal-title fw-bold mx-auto">Edit Tujuan</h5>
            </div>

            <div class="modal-body">

                <form id="editTujuanForm" method="POST">
                    @csrf
                    @method("PUT")

                    <input type="hidden" name="id" id="editId">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Tujuan</label>
                        <input type="text" name="nama_tujuan" id="editNama" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Target Nominal</label>
                        <input type="text" name="target_nominal" id="editTarget" class="form-control nominal" inputmode="numeric" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deadline</label>
                        <input type="date" name="deadline" id="editDeadline" class="form-control" required>
                    </div>

                    <div class="d-flex justify-content-center gap-4">

                        {{-- Tombol untuk membuka modal tambah nominal --}}
                        <button type="button" class="btn btn-outline-success w-100 mt-2" id="btnTambahNominal">
                            Tambah Nominal Saat Ini
                        </button>

                        <button type="submit" class="btn btn-primary w-100 mt-2">Simpan Perubahan</button>

                    </div>
                </form>

            </div>
        </div>
    </div>
</div>



{{-- ========================= --}}
{{--  MODAL TAMBAH NOMINAL    --}}
{{-- ========================= --}}
<div class="modal fade" id="tambahNominalModal2" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">

            <div class="modal-header modal-header-gradient text-white" style="border-bottom: none;">
                <h5 class="modal-title fw-bold mx-auto">Tambah Nominal</h5>
            </div>

            <div class="modal-body">

                <form id="formTambahNominal" method="POST">
                    @csrf
                    @method("PUT")

                    <input type="hidden" name="id" id="nominalTujuanId">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nominal Tambahan</label>
                        <input type="text" 
                                class="form-control nominal" 
                                id="inputNominalTambah"
                                name="nominal_saat_ini" 
                                placeholder="Masukkan nominal tambahan" 
                                inputmode="numeric" required>
                        
                        <div id="alertNominalLimit" 
                            class="text-danger mt-1" 
                            style="display:none; font-size: 14px;">
                        </div>

                        <div id="sisaTargetInfo"
                            class="text-muted mt-1"
                            style="font-size: 12px;">
                        </div>
                    </div>

                    <div class="d-flex justify-content-center gap-4">
                        <button type="button" class="btn btn-secondary w-100" id="btnBatalTambahNominal">Batal</button>
                        <button type="submit" class="btn btn-primary bg-btn-gradient w-100 text-center">Tambah</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>

{{-- =================================== --}}
{{--  FORM DELETE - PAKAI - TARIK HIDDEN --}}
{{-- =================================== --}}
<form id="deleteFormReal" method="POST" style="display:none">
    @csrf
    @method("DELETE")
</form>

<form id="formPakai" method="POST" style="display:none;">
    @csrf
</form>

<form id="formTarik" method="POST" style="display:none;">
    @csrf
</form>

{{-- ========================= --}}
{{--  SCRIPT LOGIC MODAL       --}}
{{-- ========================= --}}

<!-- SWEETALERT2 KONFIRMASI -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const viewModalEl = document.getElementById("viewTujuanModal");
    const editModalEl = document.getElementById("editTujuanModal");
    const tambahModalEl = document.getElementById("tambahNominalModal2");

    const viewModal   = bootstrap.Modal.getOrCreateInstance(viewModalEl);
    const editModal   = bootstrap.Modal.getOrCreateInstance(editModalEl);
    const tambahModal = bootstrap.Modal.getOrCreateInstance(tambahModalEl);

    // Elemen UI
    const btnTambahNominal = document.getElementById("btnTambahNominal");
    const inputNominal = document.getElementById("inputNominalTambah");
    const alertNominalLimit = document.getElementById("alertNominalLimit");
    const sisaTargetInfo = document.getElementById("sisaTargetInfo");

    let targetNominal = 0;
    let currentNominal = 0;

    //---------------------------------------------------
    //     EVENT: KLIK KARTU TUJUAN (1 event saja)
    //---------------------------------------------------
    document.querySelectorAll(".tujuan-card").forEach(card => {
        card.addEventListener("click", function () {

            const id        = this.dataset.id;
            const nama      = this.dataset.nama;
            const status    = this.dataset.status;
            const targetRaw = parseInt(this.dataset.targetRaw);
            const currRaw   = parseInt(this.dataset.currentRaw);
            const deadline  = this.dataset.deadline;

            targetNominal = targetRaw;
            currentNominal = currRaw;

            // Tampilkan data ke modal view
            document.getElementById("viewNama").innerText = nama;
            document.getElementById("viewTarget").innerText = targetRaw.toLocaleString("id-ID");
            document.getElementById("viewNominal").innerText = currRaw.toLocaleString("id-ID");
            document.getElementById("viewDeadline").innerText = deadline;

            // Set form action
            document.getElementById("editTujuanForm").action       = `/tujuan/${id}`;
            document.getElementById("formTambahNominal").action   = `/tujuan/${id}/tambah-nominal`;
            document.getElementById("deleteFormReal").action      = `/tujuan/${id}`;
            document.getElementById("nominalTujuanId").value      = id;

            // Isi form edit
            document.getElementById("editId").value   = id;
            document.getElementById("editNama").value = nama;
            document.getElementById("editTarget").value = targetRaw;

            const d = new Date(deadline);
            document.getElementById("editDeadline").value =
                `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, "0")}-${String(d.getDate()).padStart(2, "0")}`;

            // Update info sisa
            updateSisaTargetUI();

            // Render tombol dinamis
            renderActionButtons(id, status, currRaw, targetRaw);

            // Tampilkan modal view
            viewModal.show();
        });
    });

    
    //---------------------------------------------------
    //     RENDER TOMBOL DINAMIS DALAM MODAL
    //---------------------------------------------------
    function renderActionButtons(id, status, nominal, target) {
        const persen = Math.round((nominal / target) * 100);
        const container = document.getElementById("tujuanActionContainer");

        if (persen >= 100) {
            container.innerHTML = `
                <div class="d-flex justify-content-center gap-4">
                    <button id="btnEditTujuan" class="btn-action-edit">
                        <i class="bi bi-pencil-square"></i> Edit
                    </button>
                    <button id="btnDeleteTujuan" class="btn-action-delete">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </div>
                <div class="alert alert-success mt-3">Tujuan telah mencapai 100%. Pilih tindakan:</div>
                <button class="btn btn-primary w-100 mb-2" id="btnPakaiTabungan">Pakai Tabungan</button>
                <button class="btn btn-success w-100" id="btnTarikKeKeuangan">Masukkan sebagai Pemasukan</button>
            `;
        }
        else if (status === "active") {
            container.innerHTML = `
                <div class="d-flex justify-content-center gap-4">
                    <button id="btnEditTujuan" class="btn-action-edit">
                        <i class="bi bi-pencil-square"></i> Edit
                    </button>
                    <button id="btnDeleteTujuan" class="btn-action-delete">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </div>
            `;
        }
        else {
            container.innerHTML = `
                <div class="alert alert-warning mt-3">Tabungan Tujuan Finansial telah digunakan.</div>
                <div class="d-flex justify-content-center gap-4">
                    <button id="btnDeleteTujuan" class="btn-action-delete">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </div>
            `;
        }

        attachDynamicEvents(id);
    }


    //---------------------------------------------------
    //     PASANG EVENT KE TOMBOL YANG BARU DIBUAT
    //---------------------------------------------------
    function attachDynamicEvents(id) {

        const editBtn = document.getElementById("btnEditTujuan");
        if (editBtn) {
            editBtn.onclick = () => {
                viewModal.hide();
                editModal.show();
            };
        }

        const deleteBtn = document.getElementById("btnDeleteTujuan");
        if (deleteBtn) {
            deleteBtn.onclick = () => {
                Swal.fire({
                    title: "Hapus Tujuan?",
                    text: "Pilih bagaimana Anda ingin menangani riwayat keuangan tujuan ini:",
                    icon: "warning",
                    input: 'radio', // Menggunakan radio button di dalam SweetAlert
                    inputOptions: {
                        'hapus_semua': 'Hapus beserta seluruh riwayat pengeluaran',
                        'kembalikan_saldo': 'Hapus & kembalikan nominal ke Pemasukan'
                    },
                    inputValue: 'hapus_semua', // Default pilihan
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Anda harus memilih salah satu opsi!';
                        }
                    },
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: "Ya, Hapus!",
                    cancelButtonText: "Batal",
                    reverseButtons: true
                }).then(result => {
                    if (result.isConfirmed) {
                        // Ambil form delete
                        const form = document.getElementById("deleteFormReal");
                        
                        // Tambahkan input hidden secara dinamis untuk mengirimkan opsi yang dipilih
                        let inputOpsi = document.createElement("input");
                        inputOpsi.type = "hidden";
                        inputOpsi.name = "opsi_hapus";
                        inputOpsi.value = result.value; // Nilai 'hapus_semua' atau 'kembalikan_saldo'
                        
                        form.appendChild(inputOpsi);
                        form.submit();
                    }
                });
            };
        }

        const pakaiBtn = document.getElementById("btnPakaiTabungan");
        if (pakaiBtn) {
            pakaiBtn.onclick = () => {
                const form = document.getElementById("formPakai");
                form.action = `/tujuan/${id}/pakai`;
                form.submit();
            };
        }

        const tarikKeuangan = document.getElementById("btnTarikKeKeuangan");
        if (tarikKeuangan) {
            tarikKeuangan.onclick = () => {
                const form = document.getElementById("formTarik");
                form.action = `/tujuan/${id}/tarik`;
                form.submit();
            };
        }
    }


    //---------------------------------------------------
    //     EVENT: Tombol "Tambah Nominal"
    //---------------------------------------------------
    btnTambahNominal.addEventListener("click", () => {
        editModal.hide();
        tambahModal.show();
    });

    // Tombol Batal di Modal Tambah Nominal
    const btnBatalTambah = document.getElementById("btnBatalTambahNominal");
    btnBatalTambah.addEventListener("click", () => {
        tambahModal.hide();
        editModal.show();
    });

    //---------------------------------------------------
    //     VALIDASI REAL-TIME INPUT NOMINAL
    //---------------------------------------------------
    function updateSisaTargetUI() {
        const sisa = targetNominal - currentNominal;
        sisaTargetInfo.innerHTML = `Sisa target: <strong>Rp ${sisa.toLocaleString('id-ID')}</strong>`;
    }

    inputNominal.addEventListener("input", function () {
        let tambahan = parseInt(this.value.replace(/\D/g, "")) || 0;
        this.value = tambahan.toLocaleString("id-ID");

        const total = currentNominal + tambahan;

        if (total > targetNominal) {
            this.classList.add("is-invalid");
            alertNominalLimit.style.display = "block";
            alertNominalLimit.innerText = "Penambahan melebihi target tujuan!";
            document.querySelector("#formTambahNominal button[type='submit']").disabled = true;
        } else {
            this.classList.remove("is-invalid");
            alertNominalLimit.style.display = "none";
            document.querySelector("#formTambahNominal button[type='submit']").disabled = false;
        }
    });

});
</script>

{{-- ====================================================== --}}
{{--              STYLE CUSTOM BUTTON EDIT/HAPUS            --}}
{{-- ====================================================== --}}
<style>
.detail-row {
    background: #F9FAFB;
    border-radius: 12px;
    padding: 12px 16px;
    margin-bottom: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 1px solid #E5E7EB;
}

.detail-row .label {
    font-weight: 600;
    color: #6B7280;
}

.detail-row .value {
    font-weight: 600;
    color: #111827;
}

.btn-action-edit {
    background: none;
    border: 2px solid;
    border-radius: 12px;
    font-size: 16px;
    color: #102F4B
    cursor: pointer;
    transition: color 0.2s ease, transform 0.2s ease;
}

.btn-action-edit i {
    margin-right: 4px;
}

/* Hover Edit */
.btn-action-edit:hover {
    color: #1B94D7;      /* Biru */
    transform: scale(1.1);
}

.btn-action-delete {
    background: none;
    border: 2px solid;
    border-radius: 12px;
    font-size: 16px;
    color: #DC3545;
    cursor: pointer;
    transition: color 0.2s ease, transform 0.2s ease;
}

.btn-action-delete i {
    margin-right: 4px;
}

/* Hover Delete */
.btn-action-delete:hover {
    color: #cc0000;      /* Merah lebih gelap */
    transform: scale(1.1);
}

.swal2-radio {
    display: grid !important;
    grid-column: 1;
    text-align: left;
    margin-left: 20px;
}
.swal2-radio label {
    margin-bottom: 10px;
    font-size: 14px;
}
</style>