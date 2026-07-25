<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use App\Http\Middleware\TrustProxies;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Middleware\UpdateLastLoginMiddleware;
use App\Exceptions\SaldoTerlaluBesarException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php', 
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Untuk middleware global (semua request)
        $middleware->append([
            TrustProxies::class,
            \Illuminate\Http\Middleware\HandleCors::class,
        ]);

        // Atau jika kamu ingin hanya di grup "web"
        $middleware->web(append: [
            PreventBackHistory::class,
            UpdateLastLoginMiddleware::class,
            \App\Http\Middleware\CheckSuspended::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
        ]);

        $middleware->api(append: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        // Jika kamu ingin alias untuk dipakai di route
        $middleware->alias([
            'prevent-back-history' => PreventBackHistory::class,
            'verified' => EnsureEmailIsVerified::class,
            'admin' => \App\Http\Middleware\IsAdmin::class,
            'auth' => \App\Http\Middleware\Authenticate::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'terms.complete' => \App\Http\Middleware\EnsureTermsComplete::class,
            'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
            'suspended' => \App\Http\Middleware\CheckSuspended::class,
            'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Tangkap exception custom
        $exceptions->render(function (SaldoTerlaluBesarException $e, $request) {
            return back()->with('error', $e->getMessage());
        });
    })
    ->withSchedule(function (Schedule $schedule) {

        // Queue
        $schedule->command('queue:work --stop-when-empty --max-time=50')
            ->everyMinute()
            ->withoutOverlapping(5);
        
        // 🔔 Peringatan anggaran hampir habis - Berjalan setiap 5 detik
        $schedule->call(function () {
            // Batasi 11 kali perulangan (55 detik) agar tidak menabrak menit berikutnya
            for ($i = 0; $i < 11; $i++) {
                \Illuminate\Support\Facades\Artisan::call('notifications:warning');
                sleep(5);
            }
        })
        ->everyMinute()
        ->name('notifikasi.anggaran.hampir.habis')
        ->timezone('Asia/Jakarta')
        ->withoutOverlapping(5); // Berikan expiry time 5 menit jika terjadi crash agar lock otomatis terbuka

        // 🔔 Pengingat jam 20:00
        $schedule->command('notifications:reminder')
            ->dailyAt('20:00')
            ->name('notifikasi.pengingat.keuangan')
            ->timezone('Asia/Jakarta');

        // 🔔 Ringkasan peringatan anggaran
        $schedule->command('notifications:warning-digest')
            ->lastDayOfMonth('08:00')
            ->name('notifikasi.rangkuman.anggaran')
            ->timezone('Asia/Jakarta')
            ->onOneServer()
            ->withoutOverlapping();

        // ⌛ Auto-Cancel expired payment
        $schedule->command('premium:cancel-expired')->hourly();
        // Jalankan pembersihan bukti storage setiap hari jam 1 malam
        $schedule->command('storage:cleanup-images')->dailyAt('01:00');
        // Jalankan pembersihan Notifikasi setiap jamnya
        $schedule->command('model:prune')->hourly();
        // Jalankan Pembersihan Deadline user Supended setiap jam 12
        $schedule->command('user:purge-suspended')->daily();
        // Cek setiap jam, jika ada transaksi yang 'terlantar' 12 jam, kirim email
        $schedule->command('send:payment-reminder')->hourly();
    })
    ->create();