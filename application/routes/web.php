<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Livewire\UserDashboard;
use App\Livewire\PaymentStatusChecker;
use App\Livewire\EventIndex;
use App\Livewire\EventManage;
use App\Mail\NotifikasiEmail;
use App\Models\User;

// ── Controllers ──
    use App\Http\Controllers\EmailPreferenceController;
    use App\Http\Controllers\HomeController;
    use App\Http\Controllers\LegalController;
    use App\Http\Controllers\PremiumController;
    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\AnggaranController;
    use App\Http\Controllers\KeuanganController;
    use App\Http\Controllers\KategoriController;
    use App\Http\Controllers\TujuanController;
    use App\Http\Controllers\VisualisasiController;
    use App\Http\Controllers\NotificationController;
    use App\Http\Controllers\TermsController;
    use App\Http\Controllers\PushNotificationController;
    use App\Http\Controllers\FeedbackController;
    use App\Http\Controllers\Admin\CommandController;
    use App\Http\Controllers\Admin\DashboardController;
    use App\Http\Controllers\Admin\SettingsController;
    use App\Http\Controllers\Auth\DeviceSessionController;
    use App\Http\Controllers\Auth\GoogleController;

// ── Landing Page ──
    Route::get('/', [HomeController::class, 'beranda'])->name('beranda');
    Route::get('/tentang', [HomeController::class, 'tentang'])->name('tentang');
    Route::get('/informasi', [HomeController::class, 'informasi'])->name('informasi');
    Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');
    Route::get('/feedback-dismiss', [HomeController::class, 'dismiss'])->name('feedback.dismiss');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    // Premium pricelist
        Route::get('/plans', [PremiumController::class, 'price'])->name('premium.upgrade');

// ── Legal Documents (Guest Accessible) ──
    Route::get('/persetujuan/syarat-ketentuan', [LegalController::class, 'terms'])->name('legal.terms');
    Route::get('/persetujuan/perjanjian-pengguna', [LegalController::class, 'agreement'])->name('legal.agreement');
    Route::get('/persetujuan/kebijakan-privasi', [LegalController::class, 'privacy'])->name('legal.privacy');

// ── Redirect ke Google ──
    Route::get('/auth/google/redirect', [GoogleController::class, 'redirectToGoogle'])->name('login.google')->middleware('throttle:5,1'); // max 5 request per menit;
    Route::get('/login/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback'); // Callback (bisa untuk login & sambungkan)

// ── Onboarding (setelah login & verifikasi, sebelum akses app) ──
    Route::middleware(['auth', 'verified', 'prevent-back-history'])->group(function () {
        Route::post('/persetujuan', [TermsController::class, 'acceptTerms'])->name('acceptance.terms');
    });

// ── Authenticated Routes ──
    Route::middleware(['auth', 'prevent-back-history', 'verified', 'terms.complete', 'suspended'])->group(function () {
        // Dashboard functional routes
            Route::get('/dashboard', UserDashboard::class)->name('dashboard.index');

        // Keuangan functional routes
            Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan.index');
            Route::post('keuangan-store', [KeuanganController::class, 'store'])->name('keuangan.store');
            Route::put('/keuangan/{id}', [KeuanganController::class, 'update'])->name('keuangan.update');
            Route::delete('/keuangan/{id}', [KeuanganController::class, 'destroy'])->name('keuangan.destroy');

        // Kategori functional routes
            Route::get('/kategori/{jenis}', [KategoriController::class, 'getByJenis']);
            // Kategori management (Premium)
                Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
                Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
                Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
                Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

        // Anggaran functional routes
            Route::get('/anggaran', [AnggaranController::class, 'index'])->name('anggaran.index');
            Route::post('/anggaran', [AnggaranController::class, 'store'])->name('anggaran.store');
            Route::put('/anggaran/{id}', [AnggaranController::class, 'update'])->name('anggaran.update');
            Route::delete('/anggaran/{id}', [AnggaranController::class, 'destroy'])->name('anggaran.destroy');

        // Tujuan functional routes
            Route::get('/tujuan', [TujuanController::class, 'index'])->name('tujuan.index');
            Route::post('/tujuan', [TujuanController::class, 'store'])->name('tujuan.store');
            Route::put('/tujuan/{id}', [TujuanController::class, 'perbarui'])->name('tujuan.perbarui'); // Update data Tujuan Finansial (Nama Tujuan, Target, Deadline)
            Route::put('/tujuan/{id}/tambah-nominal', [TujuanController::class, 'add'])->name('tujuan.update'); // Tambah Nominal (fitur Card)
            Route::delete('/tujuan/{id}', [TujuanController::class, 'destroy'])->name('tujuan.destroy');
            // Jika sudah 100%
                Route::post('/tujuan/{id}/pakai', [TujuanController::class, 'pakai'])->name('tujuan.pakai');
                Route::post('/tujuan/{id}/tarik', [TujuanController::class, 'tarik'])->name('tujuan.tarik');

        // Notifications functional routes
            Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
            Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy'); // Hapus Notif
            // Push configuration
                Route::post('/push/subscribe', [PushNotificationController::class, 'subscribe'])->name('push.subscribe');
                Route::post('/push/unsubscribe', [PushNotificationController::class, 'unsubscribe'])->name('push.unsubscribe');
                Route::post('/push/test', [PushNotificationController::class, 'testPush']); // Test Push
            // Email Preference
                Route::post('/profile/email-preference', [EmailPreferenceController::class, 'update'])->name('email.preference.update');

        // Profile Management
            Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
            Route::post('/profile', [ProfileController::class, 'perbarui'])->name('profile.perbarui');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
            Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
            // Penggunaan Kode Kupon
                Route::post('/profile/redeem', [ProfileController::class, 'redeem'])->name('profile.redeem');
                Route::get('/redeem/success', function () { return view('redeem.success'); })->name('redeem.success');

        // Visualization functional routes
            Route::get('/keuangan/laporan', [VisualisasiController::class, 'laporan'])->name('keuangan.laporan');
            Route::post('/laporan/keuangan/pdf', [VisualisasiController::class, 'exportPdf'])->name('laporan.export.pdf'); // Unduh Laporan PDF

        // Halaman Events (acara)
            Route::get('/events', EventIndex::class)->name('events.index');

        // Route Proses Pembayaran
            Route::get('/premium/checkout', [PremiumController::class, 'checkout'])->name('premium.checkout');
            Route::post('/premium/checkout', [PremiumController::class, 'store'])->name('premium.store');
            Route::get('/premium/upload/{id}', [PremiumController::class, 'uploadPage'])->name('premium.upload');
            Route::post('/premium/upload/{id}', [PremiumController::class, 'processUpload'])->name('premium.checkoutUpload');
            Route::get('/premium/status/{transactionId}', PaymentStatusChecker::class)->name('premium.status');
            Route::get('/premium/history', [PremiumController::class, 'history'])->name('premium.history');
            Route::get('/premium/invoice/{id}/download', [PremiumController::class, 'downloadInvoice'])->name('premium.invoice.download');

        // Pengaturan functional routes
            // Sesi Login
                Route::get('/pengaturan/sesi', [DeviceSessionController::class, 'index'])->name('sesi.index');
                Route::delete('/pengaturan/sesi/{id}', [DeviceSessionController::class, 'destroy'])->name('perangkat.logout');

    });

// ── Admin Routes ──
    Route::middleware(['auth', 'admin', 'terms.complete'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/dashboard/users-modal', [DashboardController::class, 'getUsersForModal'])->name('admin.dashboard.users-modal');

        // Route untuk menampilkan halaman form pengaturan
            Route::get('/settings', [SettingsController::class, 'editSettings'])->name('admin.settings.edit');
        
        // Route untuk memproses update data (menggunakan POST atau PUT)
            Route::post('/settings', [SettingsController::class, 'updateSettings'])->name('admin.settings.update');

        // Pengelolaan Events
            Route::get('/manage-events', EventManage::class)->name('events.manage');
        
        // Confirm Pembayaran
            Route::get('/admin/confirm-payment/{id}', [PremiumController::class, 'confirmPayment'])->name('admin.confirm.payment');

        // Commands
            Route::get('/jalankan-optimize', [CommandController::class, 'optimize']);
    });

// Halaman Informasi Akun Ditangguhkan
    Route::get('/account/suspended', function () {
        if (!Auth::check() || !Auth::user()->trashed()) {
            return redirect('/');
        }
        return view('auth.suspended'); // Buat file blade ini
    })->middleware('auth');

// Proses Pengajuan Pemulihan Akun (Tombol Klik)
    Route::post('/account/restore', function (Request $request) {
        $user = Auth::user();
        
        if ($user && $user->trashed()) {
            // Kembalikan akun user (deleted_at menjadi NULL)
            $user->restore();
            
            // Kirim notifikasi email ke user & admin bahwa akun aktif kembali (Opsional)
            // Mail::to($user->email)->queue(new AccountRestoredMail($user));

            return redirect('/keuangan')->with('status', 'Akun Anda berhasil dipulihkan!');
        }

        return redirect('/');
    })->middleware('auth')->name('account.restore');

// ── Requires ──
    require __DIR__.'/auth.php';