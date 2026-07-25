class PushNotificationManager {
    constructor(options = {}) {
        this.toggleSelector = options.toggleSelector || '#pushToggle';
        this.statusSelector = options.statusSelector || '#notif-status';

        this.pushToggle = document.querySelector(this.toggleSelector);
        this.notifStatus = document.querySelector(this.statusSelector);

        this.init();
    }

    async init() {
        if (!('serviceWorker' in navigator)) {
            console.warn('Service Worker tidak didukung browser');
            return;
        }

        await this.initPushStatus();

        if (this.pushToggle) {
            this.pushToggle.addEventListener('change', async (e) => {
                if (e.target.checked) {
                    await this.enablePush();
                } else {
                    await this.disablePush();
                }
            });
        }
    }

    async enablePush() {
        try {
            const permission = await Notification.requestPermission();

            if (permission !== 'granted') {
                this.pushToggle.checked = false;
                alert('Izin notifikasi diperlukan');
                return;
            }

            await this.subscribePush();

            alert('Push notification aktif!');
        } catch (err) {
            console.error(err);
            this.pushToggle.checked = false;
            alert('Gagal mengaktifkan push notification');
        }
    }

    async disablePush() {
        try {
            await this.unsubscribePush();

            alert('Push notification dimatikan');
        } catch (err) {
            console.error(err);

            this.pushToggle.checked = true;
            alert('Gagal menonaktifkan push notification');
        }
    }

    async initPushStatus() {
        if (!this.notifStatus || !this.pushToggle) return;

        try {
            const reg = await navigator.serviceWorker.ready;
            const sub = await reg.pushManager.getSubscription();

            if (Notification.permission === 'denied') {
                this.notifStatus.textContent = 'Ditolak';
                this.notifStatus.className = 'badge bg-danger';
                this.pushToggle.checked = false;

            } else if (sub && Notification.permission === 'granted') {
                this.notifStatus.textContent = 'Aktif';
                this.notifStatus.className = 'badge bg-success';
                this.pushToggle.checked = true;

            } else {
                this.notifStatus.textContent = 'Nonaktif';
                this.notifStatus.className = 'badge bg-secondary';
                this.pushToggle.checked = false;
            }

        } catch (e) {
            console.warn('Gagal cek status push:', e);
        }
    }

    async subscribePush() {
        try {
            const data = await window.WebPush.subscribeUser();

            if (data && data.message) {
                console.log(data.message);
            }

            await this.initPushStatus();

        } catch (err) {
            console.error("Gagal subscribe push:", err.message);
            throw err;
        }
    }

    async unsubscribePush() {
        try {
            await window.WebPush.unsubscribePush();

            await this.initPushStatus();

        } catch (err) {
            console.error("Gagal unsubscribe push:", err.message);
            throw err;
        }
    }
}