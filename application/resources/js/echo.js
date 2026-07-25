// Tidak perlu import Echo lagi di sini karena sudah ada di window
// Ambil elemen meta
const userIdEl = document.head.querySelector('meta[name="user-id"]');

// Hanya jalankan logic jika elemen ada (user sudah login)
if (userIdEl && userIdEl.content) {
    const userId = userIdEl.content;

    window.Echo.private(`notifications.${userId}`)
        .listen('.new-notification', (e) => {
            console.log('Notif baru:', e.notification);

            if (window.showInPageToast) {
                window.showInPageToast(e.notification);
            }
        })
        // Tambahkan catch error untuk channel di bawah ini
        .error((error) => {
            console.error(`Gagal terhubung ke channel notifications.${userId}:`, error);
        });

    window.Echo.connector.pusher.connection.bind('error', (err) => {
        console.error('Terjadi error pada koneksi Websocket/Pusher:', err);
    });
} else {
    console.info("User ID tidak ditemukan. Echo private channel dilewati.");
}