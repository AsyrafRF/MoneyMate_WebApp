<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTermsComplete
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Jika tidak login atau sudah selesai onboarding, lanjutkan saja
        if (!$user || $user->hasCompletedTerms()) {
            return $next($request);
        }

        // Daftar route yang diizinkan sebelum agreement disetujui.
        // Penting: Masukkan route POST submit agreement dan route dashboard utama.
        $allowedRoutes = [
            'beranda',     // Halaman utama tempat modal muncul
            'logout',             // Agar user bisa logout jika tidak mau setuju
            'acceptance.terms',   // Route POST untuk submit form
        ];

        // Izinkan akses jika route saat ini ada di daftar putih
        if (in_array($request->route()->getName(), $allowedRoutes)) {
            return $next($request);
        }

        // Jika user mencoba akses halaman lain (misal: keuangan/create), 
        // paksa kembali ke dashboard agar modal terlihat.
        return redirect()->route('beranda');
    }
}