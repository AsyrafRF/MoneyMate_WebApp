<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    public function handle($request, Closure $next, ...$guards)
    {
        // Jalankan autentikasi bawaan Laravel
        $this->authenticate($request, $guards);

        // ✅ Jalankan pengecekan email terverifikasi (kecuali login Google)
        $user = Auth::user();
        if ($user && ! $user->google_id && ! $user->hasVerifiedEmail()) {
            Auth::logout();

            return redirect()
                ->route('verification.notice')
                ->with('warning', 'Kamu harus verifikasi email terlebih dahulu sebelum login.');
        }

        return $next($request);
    }
}
