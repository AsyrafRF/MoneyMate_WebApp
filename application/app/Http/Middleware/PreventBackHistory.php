<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PreventBackHistory
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // 1. Abaikan untuk route tertentu (misal callback Google)
        if ($request->is('auth/google/callback')) {
            return $response;
        }

        // 2. Gunakan $response->headers->set() yang kompatibel untuk SEMUA tipe response
        // (Termasuk Response standar, BinaryFileResponse, dan StreamedResponse)
        if (isset($response->headers)) {
            $response->headers->set('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT');
        }

        return $response;
    }
}