// Global handler untuk semua form yang sedang dikirim
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function() {
        // Cek apakah form memiliki instruksi untuk tidak menampilkan overlay
        if (this.getAttribute('data-no-overlay') === 'true') {
            return; // Keluar dari fungsi, overlay tidak akan muncul
        }
        
        const submitButtons = this.querySelectorAll('button[type="submit"]');
        const externalButtons = document.querySelectorAll(`button[form="${this.id}"]`);

        // Menampilkan overlay
        const overlay = document.getElementById('loading-overlay');
        overlay.style.display = 'flex';
        
        // Matikan semua tombol terkait
        submitButtons.forEach(btn => btn.disabled = true);
        externalButtons.forEach(btn => btn.disabled = true);
    });
});