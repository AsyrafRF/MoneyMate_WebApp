import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { VitePWA } from 'vite-plugin-pwa';
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',        // global CSS
                'resources/js/app.js',          // global JS

                // Entry per halaman
                'resources/js/pages/keuangan/index.js',
            ],
            refresh: true,
        }),
        VitePWA({
            registerType: 'autoUpdate',
            // PENTING: Ubah strategi ke 'generateSW' atau biarkan default, 
            // tapi matikan injeksi otomatis index.html
            injectRegister: 'auto',
            workbox: {
                // Hapus atau overwrite navigasi default index.html bawaan SPA
                navigateFallback: null,
                // Jika ingin caching halaman utama Laravel secara offline, daftarkan url '/'
                runtimeCaching: [
                    {
                        urlPattern: ({ request }) => request.mode === 'navigate',
                        handler: 'NetworkFirst', // Coba ambil jaringan dulu, jika offline pakai cache
                        options: {
                            cacheName: 'laravel-pages',
                        },
                    },
                ],
            },
            manifest: {
                id: '/',
                scope: '/',
                name: 'MoneyMate ID',
                short_name: 'MoneyMate',
                description: 'Aplikasi Kelola Anggaran Pribadi & Keuangan Harian',
                background_color: "#ffffff",
                theme_color: '#1B94D7',
                start_url: '/', // Pastikan start_url mengarah ke root Laravel
                display: 'standalone',
                screenshots: [
                    {
                        "src": "/images/screenshot-mobile.png",
                        "sizes": "390x844",
                        "type": "image/png",
                        "form_factor": "narrow"
                    },
                    {
                        "src": "/images/screenshot-desktop.png",
                        "sizes": "1366x768",
                        "type": "image/png",
                        "form_factor": "wide"
                    }
                ],
                icons: [
                    {
                        src: '/icons/pwa-192x192.png',
                        sizes: '192x192',
                        type: 'image/png'
                    },
                    {
                        src: '/icons/pwa-512x512.png',
                        sizes: '512x512',
                        type: 'image/png'
                    }
                ]
            }
        }),
        tailwindcss(),
    ],
});
