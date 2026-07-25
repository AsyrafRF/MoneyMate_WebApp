// Script auto close budget limits alert (Disatukan agar tidak bentrok)
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(alert => {
        // 1. Ambil atau buat instance resmi Bootstrap Alert
        const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);

        // 2. Cek apakah alert ini berada di dalam sebuah baris (.row-alert)
        const parentRow = alert.closest('.row-alert');

        if (parentRow) {
            // Jika ada di dalam row, pasang listener untuk menghapus row setelah animasi close selesai
            alert.addEventListener('closed.bs.alert', () => {
                parentRow.remove(); // Hapus baris tabel agar tidak ada sisa ruang kosong
            });
        }

        // 3. Picu penutupan alert lewat jalur resmi Bootstrap
        // (Bootstrap otomatis akan menambahkan kelas 'fade' dan menghapus 'show')
        bsAlert.close();
    });
}, 8000);