import './bootstrap';
import './echo'; // Panggil di sini agar masuk ke bundle Vite
import './animate';
import { registerSW } from 'virtual:pwa-register';
import { WebPush } from './web-push';

// Hapus import Alpine dan Alpine.start() jika menggunakan Livewire 3
// Jika Livewire 2, biarkan saja.

// Registrasi Service Worker bawaan Vite PWA
registerSW({ immediate: true });
// Masukkan ke global window agar Alpine.js bisa mengaksesnya
window.WebPush = WebPush;