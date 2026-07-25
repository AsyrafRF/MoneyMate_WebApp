self.addEventListener('push', function (event) {
    if (!event.data) return;

    const data = event.data.json();

    const title = data.title || 'MoneyMate';
    const options = {
        body: data.body || '',
        icon: '/favicon.ico',
        badge: data.badge || '/images/moneymate-original-notext.png',
        data: {
            url: data.url || '/notifications',
        },
        actions: data.actions || []
    };

    // Logic: Cek apakah ada tab yang sedang terbuka dan aktif (foreground)
    const checkAndShow = clients.matchAll({
        type: 'window',
        includeUncontrolled: true
    }).then((clientList) => {
        // Cek apakah ada setidaknya satu tab yang sedang "focused" (aktif di depan user)
        const isAppVisible = clientList.some(
            client => client.visibilityState === 'visible'
        );

        if (isAppVisible) {
            console.log('App is in foreground, skipping system notification.');
            // Kita tidak memanggil showNotification() di sini
            // Karena user sudah mendapat update via Pusher/Echo di app.blade.php
            return;
        }

        // Jika tab tertutup atau sedang di background, tampilkan notifikasi sistem
        return self.registration.showNotification(title, options);
    });

    event.waitUntil(checkAndShow);
});

self.addEventListener('notificationclick', function (event) {
    event.notification.close();

    const targetUrl = event.notification.data.url || '/notifications';

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true })
            .then(function (clientList) {
                // Cari apakah ada tab yang sudah terbuka dengan URL yang sama
                for (const client of clientList) {
                    if (client.url.includes(targetUrl) && 'focus' in client) {
                        return client.focus();
                    }
                }

                // Jika tidak ada tab yang cocok, buka tab baru
                if (clients.openWindow) {
                    return clients.openWindow(targetUrl);
                }
            })
    );
});