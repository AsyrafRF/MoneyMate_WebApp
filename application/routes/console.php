<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Untuk Commands Notifikasi Pengingat Pencatatan
Artisan::command('notifications:reminder', function () {
    $this->call(\App\Console\Commands\GenerateDailyReminder::class);
})->purpose('Generate notifications for reminders');

// Untuk Commands Notifikasi Peringatan Batas Anggaran
Artisan::command('notifications:warning', function () {
    $this->call(\App\Console\Commands\GenerateDailyWarning::class);
})->purpose('Generate notifications for budget-warnings');

// Untuk Commands Notifikasi Peringatan Batas Anggaran
Artisan::command('notifications:warning-digest', function () {
    $this->call(\App\Console\Commands\GenerateWarningDigest::class);
})->purpose('Generate notifications for budget-warning-digest');

// Untuk Commands Notifikasi Pembayaran Expired
Artisan::command('premium:cancel-expired', function () {
    $this->call(\App\Console\Commands\CancelExpiredTransactions::class);
})->purpose('Generate notifications for premium-cancel-expired');

// Jalankan pembersihan img otomatis
Artisan::command('storage:cleanup-images', function () {
    $this->call(\App\Console\Commands\CleanupUnusedImages::class);
})->purpose('Clean Up Unused Imgage');

// Refresh
Artisan::command('app:refresh', function () {
    $this->call(\App\Console\Commands\AppRefresh::class);
})->purpose('Refresh project changes');

// Menjalankan perintah pembersihan user suspended
Artisan::command('user:purge-suspended', function () {
    $this->call(\App\Console\Commands\PurgeDeletedUsers::class);
})->purpose('Clear Suspended User');

// Cek jika ada transaksi yang 'terlantar', kirim email
Artisan::command('send:payment-reminder', function () {
    $this->call(\App\Console\Commands\SendPaymentReminder::class);
})->purpose('Pending Payment Reminder');