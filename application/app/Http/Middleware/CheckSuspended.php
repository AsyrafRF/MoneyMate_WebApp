<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSuspended
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user login DAN akunnya berstatus soft-deleted (trashed)
        if (Auth::check() && Auth::user()->trashed()) {
            
            // IZINKAN user mengakses halaman penangguhan, proses restore, ATAU proses logout
            if (
                $request->is('account/suspended') || 
                $request->is('account/restore') || 
                $request->is('logout') ||             // Tambahkan ini (sesuaikan dengan URL route logout Anda)
                $request->routeIs('logout')          // Opsi tambahan aman jika menggunakan nama route
            ) {
                return $next($request);
            }

            // Jika mencoba akses halaman lain (dashboard, dll), lempar ke halaman khusus
            return redirect('/account/suspended');
        }

        return $next($request);
    }
}