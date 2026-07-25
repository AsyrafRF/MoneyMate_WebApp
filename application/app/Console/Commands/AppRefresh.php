<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AppRefresh extends Command
{
    // Nama command yang akan Anda ketik di terminal
    protected $signature = 'app:refresh';

    // Deskripsi command
    protected $description = 'Menjalankan seluruh rangkaian proses refreshment aplikasi secara otomatis';

    public function handle()
    {
        $this->info('🚀 Memulai proses otomatisasi...');

        // 1. Copy .env jika belum ada
        $this->info('📄 Menyalin .env.example ke .env...');
        if (!file_exists(base_path('.env'))) {
            copy(base_path('.env.example'), base_path('.env'));
        } else {
            $this->info('ℹ️ File .env sudah ada, skip penyalinan.');
        }

        // 2. Perintah non-Artisan (Composer & NPM)
        $this->info('📦 Menjalankan Composer Install...');
        shell_exec('composer install');

        // 3. Masuk ke mode Maintenance (Artisan Down)
        $this->info('🔒 Mengaktifkan Mode Maintenance...');
        $this->call('down', ['--secret' => 'PBLTRPL517612A']);

        $this->info('📦 Menjalankan NPM Install...');
        shell_exec('npm install');

        // 4. Membersihkan Cache
        $this->info('🧹 Membersihkan seluruh cache...');
        $this->call('route:clear');
        $this->call('config:clear');
        $this->call('view:clear');
        $this->call('event:clear');
        $this->call('cache:clear');
        $this->call('queue:clear');
        $this->call('queue:flush');
        $this->call('storage:cleanup-images');
        $this->call('auth:clear-resets');
        $this->call('optimize:clear');

        $this->info('🔄 Menjalankan composer dump-autoload...');
        shell_exec('composer dump-autoload');
        $this->call('reload');

        // 5. Generate Key jika belum diset
        $this->info('🔑 Membuat Application Key...');
        $this->call('key:generate');

        // --- TAMBAHAN: Pengecekan Storage Link ---
        $this->info('🔗 Memeriksa Storage Link...');
        if (!is_link(public_path('storage')) && !file_exists(public_path('storage'))) {
            $this->info('Creating storage link...');
            $this->call('storage:link');
        } else {
            $this->comment('ℹ️ Storage link sudah terhubung, otomatis skip!');
        }
        // ----------------------------------------

        // 6. Jalankan webpush (jika package terpasang)
        $this->call('webpush:vapid');

        // 7. Migrasi Database & Seeding
        $this->info('🗄️ Menjalankan Migrasi Database...');
        $this->call('migrate', ['--seed' => true, '--force' => true]);

        // 8. Membuat Cache Baru
        $this->info('⚡ Membuat Cache Baru untuk Optimasi...');
        $this->call('config:cache');
        $this->call('route:cache');
        $this->call('view:cache');
        $this->call('event:cache');
        $this->call('optimize');
        // $this->call('schema:dump', ['--prune' => true]);

        // 9. Build Asset Frontend
        $this->info('💻 Membangun Asset Production (NPM Build)...');
        shell_exec('npm run build');

        // 10. Buka kembali aplikasi (Artisan Up)
        $this->info('🔓 Menonaktifkan Mode Maintenance...');
        $this->call('up');

        // 11. Menampilkan Status Akhir
        $this->info('📊 Menampilkan Informasi Aplikasi:');
        shell_exec('composer audit');
        shell_exec('npm audit');
        $this->call('route:list');
        $this->call('channel:list');
        $this->call('migrate:status');
        $this->call('about');

        $this->info('✅ Seluruh proses refreshment SELESAI!');
    }
}