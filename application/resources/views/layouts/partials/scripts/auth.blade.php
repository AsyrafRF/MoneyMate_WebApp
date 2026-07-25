<script>
function init() {
    const logoutForm = document.getElementById('logoutForm');
    const confirmBtn = document.getElementById('confirmLogout');

    // Pastikan elemennya ada di DOM
    if (!logoutForm || !confirmBtn) return;

    // Pasang event klik pada tombol konfirmasi modal
    confirmBtn.addEventListener('click', function () {
        // 1. Cegah double-submit dengan menonaktifkan tombol
        this.disabled = true;
        
        // 2. Beri feedback visual (spinner)
        this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
        
        // 3. Submit form secara manual
        logoutForm.submit();
    });
}

// Inisialisasi DOM
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
} else {
    init();
}
</script>