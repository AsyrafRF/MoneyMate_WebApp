<?php
// app/Http/Middleware/UpdateLastLoginMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateLastLoginMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->last_login === null || $user->last_login->diffInMinutes() > 30) {
                $user->update(['last_login' => now()]);
            }
        }

        return $next($request);
    }
}