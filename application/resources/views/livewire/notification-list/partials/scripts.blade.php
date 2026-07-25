{{-- ================= ALPINE COMPONENT SCRIPT ================= --}}
@script
<script>
    // Register directly - do not wrap in alpine:init or DOMContentLoaded
    Alpine.data('notificationList', () => ({
        init() 
        {
            this.initTooltips();
            this.initPushStatus();
            this.initModals();
            this.initEventDelegation();

            // FIX: Use Livewire's hook system instead of watching $effects
            Livewire.hook('morph.updated', ({ el, component }) => {
                this.$nextTick(() => {
                    this.initTooltips();
                    // Re-run status check if necessary
                    this.initPushStatus();
                });
            });
        },

        showBrowserNotification(title, body) {
            if (document.visibilityState !== 'visible') return;

            if ("Notification" in window &&
                Notification.permission === "granted") {

                new Notification(title, {
                    body: body.replace(/<[^>]+>/g, '')
                });
            }
        },

        initTooltips() {
            this.$el.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
                const existing = bootstrap.Tooltip.getInstance(el);
                if (existing) existing.dispose();
                new bootstrap.Tooltip(el);
            });
        },

        initModals() {
            this.$wire.on('open-detail-modal', () => {
                // Gunakan nextTick agar Livewire selesai render "is_read" dulu
                this.$nextTick(() => {
                    const el = document.getElementById('notifDetailModal');
                    if (!el) return;
                    
                    // Pastikan instance bersih
                    let modal = bootstrap.Modal.getInstance(el);
                    if (!modal) {
                        modal = new bootstrap.Modal(el);
                    }
                    modal.show();
                });
            });

            this.$wire.on('close-detail-modal', () => {
                const el = document.getElementById('notifDetailModal');
                if (!el) return;
                const instance = bootstrap.Modal.getInstance(el);
                if (instance) {
                    instance.hide();
                    // Opsional: Hapus backdrop secara paksa jika masih bandel
                    document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
                }
            });
        },

        initEventDelegation() {
            const root = this.$el;

            root.addEventListener('change', async (e) => {
                if (e.target.id !== 'pushToggle') return;
                const pushToggle = e.target;

                // --- JIKA TOGGLE DIMATIKAN (UNSUBSCRIBE) ---
                if (!pushToggle.checked) {
                    try {
                        // Panggil global helper WebPush untuk unsubscribe browser & hapus di database
                        await window.WebPush.unsubscribePush(); 
                        
                        const notifStatus = root.querySelector('#notif-status');
                        if (notifStatus) {
                            notifStatus.textContent = 'Nonaktif';
                            notifStatus.className = 'badge bg-secondary';
                        }
                        alert('Push notification dimatikan');
                    } catch (err) {
                        // Jika gagal unsubscribe, kembalikan toggle ke posisi ON
                        pushToggle.checked = true;
                        alert('Gagal menonaktifkan push notification');
                        console.error(err);
                    }
                    return; // Selesai untuk proses turn off
                }

                // --- JIKA TOGGLE DIHIDUPKAN (SUBSCRIBE) ---
                const permission = await Notification.requestPermission();
                if (permission !== 'granted') {
                    pushToggle.checked = false;
                    const permModal = document.getElementById('notifPermissionModal');
                    if (permModal) bootstrap.Modal.getOrCreateInstance(permModal).show();
                    return alert('Izin notifikasi pada Browser diperlukan');
                }

                try {
                    await this.subscribePush();
                    alert('Push notification aktif!');
                } catch (err) {
                    pushToggle.checked = false;
                    alert('Gagal mengaktifkan push notification');
                    console.error(err);
                }
            });

            root.addEventListener('click', async (e) => {
                const confirmBtn = e.target.closest('#confirmEnableNotif');
                if (confirmBtn) {
                    const permModal = document.getElementById('notifPermissionModal');
                    if (permModal) bootstrap.Modal.getOrCreateInstance(permModal).hide();

                    const permission = await Notification.requestPermission();
                    if (permission !== 'granted') {
                        return alert('Izin ditolak. Aktifkan manual di browser.');
                    }

                    try {
                        await this.subscribePush();
                        alert('Push notification aktif!');
                    } catch (err) {
                        console.error(err);
                    }
                }

                const testBtn = e.target.closest('#testPushBtn');
                if (testBtn) {
                    try {
                        const res = await fetch('/push/test', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });

                        const data = await res.json();

                        // tampilkan browser notif lokal
                        this.showBrowserNotification(
                            'Test Notification',
                            data.message || 'Push notification berhasil'
                        );

                        alert(data.message);

                    } catch (err) {
                        console.error(err);
                    }
                }
            });
        },

        async initPushStatus() {
            const notifStatus = this.$el.querySelector('#notif-status');
            const pushToggle = this.$el.querySelector('#pushToggle');
            const reg = await navigator.serviceWorker.ready;
            const sub = await reg.pushManager.getSubscription();
            if (!notifStatus || !pushToggle) return;
            if (!('serviceWorker' in navigator)) return;

            try {
                const reg = await navigator.serviceWorker.ready;
                const sub = await reg.pushManager.getSubscription();

                if (Notification.permission === 'denied') {
                    notifStatus.textContent = 'Ditolak';
                    notifStatus.className = 'badge bg-danger';
                    pushToggle.checked = false;
                } else if (sub && Notification.permission === 'granted') {
                    notifStatus.textContent = 'Aktif';
                    notifStatus.className = 'badge bg-success';
                    pushToggle.checked = true;
                } else {
                    notifStatus.textContent = 'Nonaktif';
                    notifStatus.className = 'badge bg-secondary';
                    pushToggle.checked = false;
                }
            } catch (e) {
                console.warn('Gagal cek status push:', e);
            }
        },

        async subscribePush() {
            try {
                const data = await window.WebPush.subscribeUser();
                
                // Memastikan data ada sebelum membaca properti .message
                if (data && data.message) {
                    console.log(data.message);
                }
                
                await this.initPushStatus();
            } catch (err) {
                console.error("Gagal subscribe push:", err.message);
                throw err;
            }
        }
    }));
</script>
@endscript