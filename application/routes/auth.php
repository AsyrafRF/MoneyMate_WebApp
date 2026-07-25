<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controllers
    use App\Http\Controllers\Auth\LoginController;
    use App\Http\Controllers\Auth\RegisterController;
    use App\Http\Controllers\Auth\ForgotPasswordController;
    use App\Http\Controllers\Auth\ResetPasswordController;
    use App\Http\Controllers\Auth\VerifyEmailController;
    use App\Http\Controllers\Auth\PublicEmailVerificationController;
    use App\Http\Controllers\Auth\ConfirmablePasswordController;
    use App\Http\Controllers\Auth\ChangePwConfirmController;
    use App\Http\Controllers\Auth\PasswordController;
    use App\Http\Controllers\Auth\GoogleLinkController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

// Hanya untuk guest (belum login)
    Route::middleware('guest')->group(function () {
        // Registration
            Route::get('register', fn () => view('auth.register'))->name('register');
            Route::post('register', [RegisterController::class, 'store'])->name('register.post');
        
        // Login
            Route::get('login', [LoginController::class, 'create'])->name('login');
            Route::post('login', [LoginController::class, 'store']);

        // Password Reset
            Route::get('forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');
            Route::post('forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');
            Route::get('reset-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
            Route::post('reset-password', [ResetPasswordController::class, 'store'])->name('password.store');

    });

// Hanya untuk user yang sudah login
    Route::middleware('auth')->group(function () {
        // Proses memutus sambungan Google ke akun MoneyMate
            Route::delete('auth/google/disconnect', [GoogleLinkController::class, 'disconnectGoogle'])->name('auth.google.disconnect');

        // Confirm Password untuk hapus akun
            Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
            Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

        // Confirm Password untuk ganti password
            Route::get('confirm-password-change', [ChangePwConfirmController::class, 'show'])->name('password.confirm.change');
            Route::post('confirm-password-change', [ChangePwConfirmController::class, 'store']);

        // Update Password
            Route::put('password', [PasswordController::class, 'update'])->name('password.update');

        // Logout
            Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
    });

// verifikasi email
    Route::get('email/verify', function () { return view('auth.verify-email'); })->name('verification.notice');
    Route::post('email/verify-otp', [VerifyEmailController::class, 'verifyOtp'])->name('verification.verify.otp')->middleware('throttle:5,1');
    Route::post('email/resend-otp', [PublicEmailVerificationController::class, 'resend'])->name('verification.resend.otp')->middleware('throttle:3,1');