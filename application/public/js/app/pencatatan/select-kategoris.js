document.addEventListener('DOMContentLoaded', function () {

    // 1. Fungsi Utama Fetch & Update Dropdown (Solusi Inject Memori Tom Select)
    async function loadKategori(jenis, targetSelect, selectedValue = "") {
        // 1. Hancurkan instansi Tom Select lama jika ada
        if (targetSelect.tomselect) {
            targetSelect.tomselect.destroy();
        }

        if (!jenis) {
            targetSelect.innerHTML = '<option value="">-- Pilih Jenis Terlebih Dahulu --</option>';
            targetSelect.disabled = true;
            return;
        }

        targetSelect.disabled = true;
        targetSelect.innerHTML = '<option>Loading...</option>';

        try {
            const res = await fetch(`/kategori/${jenis}`);
            if (!res.ok) throw new Error('Network response was not ok');

            const data = await res.json();

            // 2. Kosongkan innerHTML dan siapkan placeholder dasar
            targetSelect.innerHTML = '<option value="">-- Pilih Kategori --</option>';
            targetSelect.disabled = false;

            // 3. Inisialisasi Tom Select TERLEBIH DAHULU dengan konfigurasi mapping data yang jelas
            const tsInstance = new TomSelect(targetSelect, {
                create: false,
                valueField: 'id_kategori',    // Memetakan id_kategori dari JSON ke value option
                labelField: 'nama_kategori',  // Memetakan nama_kategori dari JSON ke text option
                searchField: ['nama_kategori'],

                render: {
                    option: function (item, escape) {
                        // AMAN: Mengambil langsung dari properti objek data 'item.icon' tanpa lewat DOM HTML
                        const icon = item.icon ? item.icon : 'bi-tag';
                        return `<div class="d-flex align-items-center">
                                    <i class="bi ${icon} me-2 text-secondary" style="font-size: 1.1rem;"></i>
                                    <span>${escape(item.nama_kategori)}</span>
                                </div>`;
                    },
                    item: function (item, escape) {
                        const icon = item.icon ? item.icon : 'bi-tag';
                        return `<div class="d-flex align-items-center">
                                    <i class="bi ${icon} me-2 text-primary" style="font-size: 1.1rem;"></i>
                                    <strong>${escape(item.nama_kategori)}</strong>
                                </div>`;
                    }
                }
            });

            // 4. Suntik seluruh data JSON langsung ke dalam memori Tom Select
            tsInstance.addOptions(data);

            // 5. Set nilai yang terpilih (jika ada data lama / untuk modal edit)
            if (selectedValue) {
                tsInstance.setValue(String(selectedValue));
            }

        } catch (error) {
            console.error('Gagal mengambil data kategori:', error);
            targetSelect.innerHTML = '<option>Gagal memuat data</option>';
            targetSelect.disabled = false;
        }
    }

    // 2. Event Delegation untuk Semua Perubahan 'Jenis' (Pemasukan/Pengeluaran)
    document.addEventListener('change', function (e) {
        if (e.target && (e.target.id === 'jenis' || e.target.name === 'jenis')) {
            const container = e.target.closest('.modal-body') || e.target.closest('form');
            // Menargetkan menggunakan class baru '.select-kategori'
            const kategoriSelect = container.querySelector('.select-kategori');

            if (kategoriSelect) {
                loadKategori(e.target.value, kategoriSelect);
            }
        }
    });

    // 3. Inisialisasi Modal Edit saat Dibuka
    document.addEventListener('shown.bs.modal', function (e) {
        const modal = e.target;
        const jenisSelect = modal.querySelector('select[name="jenis"]') || modal.querySelector('input[name="jenis"]:checked');
        const kategoriSelect = modal.querySelector('.select-kategori');

        if (jenisSelect && kategoriSelect) {
            const selectedValue = kategoriSelect.getAttribute('data-selected');
            loadKategori(jenisSelect.value, kategoriSelect, selectedValue);
        }
    });

    // 4. Validasi Sebelum Submit (Mencegah Manipulasi HTML / Kosong)
    document.addEventListener('submit', function (e) {
        const form = e.target;
        const jenisSelect = form.querySelector('select[name="jenis"]') || form.querySelector('input[name="jenis"]:checked');
        const kategoriSelect = form.querySelector('.select-kategori');

        if (jenisSelect && kategoriSelect) {
            if (jenisSelect.value && !kategoriSelect.value) {
                e.preventDefault();
                alert('Silakan pilih kategori yang valid untuk jenis tersebut!');
            }
        }
    });
});