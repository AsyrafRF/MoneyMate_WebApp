<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {

    // Fungsi pembantu untuk mengubah format ribuan (Rp) menjadi angka murni integer
    function getCleanNumber(value) {
        if (!value) return 0;
        // Menghapus semua karakter selain angka
        let clean = value.toString().replace(/[^0-9]/g, '');
        return parseInt(clean) || 0;
    }

    function formatRupiah(angka) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
    }

    // Fungsi Utama Validasi Form
    function lakukanValidasiFrontend($form) {
        // Jika user premium, abaikan semua validasi limit dan pastikan error bersih
        if ($form.data('is-premium') === true || $form.data('is-premium') === 'true') {
            $form.find('.error-limit-saldo, .error-limit-upload').hide();
            setButtonDisabled($form, false);
            return;
        }

        let currentSaldo = parseFloat($form.data('current-saldo')) || 0;
        let limitSaldo = parseFloat($form.data('limit-saldo')) || 6000000;
        let sisaUpload = parseInt($form.data('sisa-upload')) || 0;

        // Ambil input nominal saat ini secara bersih
        let inputNominalVal = $form.find('.input-nominal').val();
        let nominalInput = getCleanNumber(inputNominalVal);

        // Deteksi jenis transaksi
        let jenis = '';
        if ($form.attr('id') === 'formTambahKeuangan') {
            jenis = $form.find('input[name="jenis"]:checked').val();
        } else {
            jenis = $form.find('.select-jenis-edit').val();
            
            // Khusus EDIT: Kembalikan dulu saldo ke kondisi sebelum transaksi ini dibuat
            let oldNominal = parseFloat($form.data('old-nominal')) || 0;
            let oldJenis = $form.data('old-jenis');
            if (oldJenis === 'Pemasukan') {
                currentSaldo -= oldNominal;
            } else if (oldJenis === 'Pengeluaran') {
                currentSaldo += oldNominal;
            }
        }

        // Hitung prediksi saldo baru
        let saldoPrediksi = currentSaldo;
        if (jenis === 'Pemasukan') {
            saldoPrediksi += nominalInput;
        } else if (jenis === 'Pengeluaran') {
            saldoPrediksi -= nominalInput;
        }

        let isSaldoError = false;
        let isUploadError = false;

        // 1. Validasi Limit Saldo (+6jt atau -6jt)
        if (saldoPrediksi > limitSaldo || saldoPrediksi < -limitSaldo) {
            isSaldoError = true;
            $form.find('.error-limit-saldo')
                .text(`Gagal! Saldo setelah transaksi (${formatRupiah(saldoPrediksi)}) akan melewati batas Freemium (${formatRupiah(limitSaldo)}).`)
                .show();
        } else {
            // Sembunyikan text merah secara eksplisit jika sudah aman
            $form.find('.error-limit-saldo').hide().text('');
        }

        // 2. Validasi Limit Upload Bukti
        let $inputBukti = $form.find('.input-bukti');
        if ($inputBukti.length > 0 && $inputBukti[0].files && $inputBukti[0].files.length > 0) {
            if (sisaUpload <= 0) {
                isUploadError = true;
                $form.find('.error-limit-upload')
                    .text('Gagal! Batas upload bukti untuk akun freemium habis (Maks 40 kali / 2 months). Upgrade ke Premium!')
                    .show();
            } else {
                $form.find('.error-limit-upload').hide().text('');
            }
        } else {
            $form.find('.error-limit-upload').hide().text('');
        }

        // 3. Aksi Kelola Status Button Submit
        if (isSaldoError || isUploadError) {
            setButtonDisabled($form, true);
        } else {
            setButtonDisabled($form, false);
        }
    }

    // Fungsi pembantu untuk mengontrol tombol submit berdasarkan form terkait
    function setButtonDisabled($form, status) {
        let $btnSubmit = $form.attr('id') === 'formTambahKeuangan' 
            ? $('button[form="formTambahKeuangan"]') 
            : $form.find('button[type="submit"], .btn-primary');

        if (status) {
            $btnSubmit.prop('disabled', true);
        } else {
            $btnSubmit.prop('disabled', false);
        }
    }

    // ==========================================
    // EVENT TRIGGER UNTUK FORM TAMBAH
    // ==========================================
    $(document).on('keyup input change', '#formTambahKeuangan .input-nominal', function() {
        lakukanValidasiFrontend($('#formTambahKeuangan'));
    });

    $(document).on('change', '#formTambahKeuangan input[name="jenis"]', function() {
        lakukanValidasiFrontend($('#formTambahKeuangan'));
    });

    $(document).on('change', '#formTambahKeuangan .input-bukti', function() {
        lakukanValidasiFrontend($('#formTambahKeuangan'));
    });


    // ==========================================
    // EVENT TRIGGER UNTUK FORM EDIT (DYNAMIC MODAL)
    // ==========================================
    $(document).on('keyup input change', '.form-edit-keuangan .input-nominal', function() {
        let $form = $(this).closest('form');
        lakukanValidasiFrontend($form);
    });

    $(document).on('change', '.form-edit-keuangan .select-jenis-edit', function() {
        let $form = $(this).closest('form');
        lakukanValidasiFrontend($form);
    });

    $(document).on('change', '.form-edit-keuangan .input-bukti', function() {
        let $form = $(this).closest('form');
        lakukanValidasiFrontend($form);
    });

    // Reset total saat modal ditutup
    $('.modal').on('hidden.bs.modal', function () {
        let $form = $(this).find('form');
        $form.find('.error-limit-saldo, .error-limit-upload').hide().text('');
        setButtonDisabled($form, false);
    });
});
</script>