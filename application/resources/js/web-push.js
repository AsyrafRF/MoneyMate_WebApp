// resources/js/web-push.js

export const WebPush = {
    // Helper untuk konversi VAPID key
    urlBase64ToUint8Array(base64String) {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
        const rawData = atob(base64);
        return Uint8Array.from([...rawData].map(c => c.charCodeAt(0)));
    },

    // Registrasi Service Worker
    async registerServiceWorker() {
        if ('serviceWorker' in navigator && 'PushManager' in window) {
            try {
                const registration = await navigator.serviceWorker.register('/service-worker.js');
                console.log('Service Worker terdaftar:', registration);
                return registration;
            } catch (error) {
                console.error('Service Worker registration failed:', error);
            }
        }
        return null;
    },

    // Subscribe User ke Server
    async subscribeUser() {
        const registration = await navigator.serviceWorker.ready;
        const vapidPublicKey = import.meta.env.VITE_VAPID_PUBLIC_KEY; // Ambil dari .env

        if (!vapidPublicKey) {
            throw new Error("VAPID Public Key tidak ditemukan di .env");
        }

        const subscription = await registration.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: this.urlBase64ToUint8Array(vapidPublicKey)
        });

        return await fetch("/push/subscribe", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(subscription)
        }).then(res => res.json());
    },

    // Unsubscribe User
    async unsubscribePush() {
        if (!('serviceWorker' in navigator)) return;

        const reg = await navigator.serviceWorker.ready;
        const sub = await reg.pushManager.getSubscription();

        if (!sub) return;

        await fetch("/push/unsubscribe", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ endpoint: sub.endpoint })
        });

        await sub.unsubscribe();
        console.log("Push notification unsubscribed");
    }
};

// Auto-register saat JS dimuat
WebPush.registerServiceWorker();