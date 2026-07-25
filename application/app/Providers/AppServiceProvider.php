<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Notification;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use App\Extensions\SuspendedEloquentUserProvider;
use App\Models\Anggaran;
use App\Models\Keuangan;
use App\Models\Notifikasi;
use App\Models\Setting;
use App\Models\User;
use App\Observers\AnggaranObserver;
use App\Observers\KeuanganObserver;
use NotificationChannels\WebPush\WebPushChannel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Observer untuk model Anggaran
        Anggaran::observe(AnggaranObserver::class);
        // Observer untuk model Keuangan
        Keuangan::observe(KeuanganObserver::class);

        // Force HTTPS di production
        // if (config('app.env') === 'production') {
        //     URL::forceRootUrl(config('app.url'));
        //     URL::forceScheme('https');
        // }

        // Register WebPush custom channel
        Notification::extend('webpush', function ($app) {
            return $app->make(WebPushChannel::class);
        });

        // Gunakan Bootstrap 5 untuk pagination
        Paginator::useBootstrapFive();

        // Cek apakah aplikasi tidak sedang berjalan di mode konsol (Artisan) 
        // DAN tabel settings sudah ada
        if (!app()->runningInConsole() && Schema::hasTable('settings')) {
            View::share('app_settings', Setting::pluck('value', 'key'));
        }

        // Daftarkan driver auth baru bernama 'eloquent-suspended'
        Auth::provider('eloquent-suspended', function ($app, array $config) {
            return new SuspendedEloquentUserProvider($app['hash'], $config['model']);
        });
    }
}
