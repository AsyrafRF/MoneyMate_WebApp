<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureEmailIsVerifiedOnLogin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Skip untuk login via Google
            if ($user->google_id) {
                return $next($request);
            }

            // Jika belum verifikasi email, logout dan arahkan ke halaman verifikasi
            if (! $user->hasVerifiedEmail()) {
                Auth::logout();

                return redirect()
                    ->route('verification.notice')
                    ->with('warning', 'Kamu harus verifikasi email terlebih dahulu sebelum bisa login.');
            }
        }

        return $next($request);
    }
}
