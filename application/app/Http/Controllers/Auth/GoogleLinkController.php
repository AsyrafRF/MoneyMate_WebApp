<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Exception;

class GoogleLinkController extends Controller
{
    public function disconnectGoogle(Request $request)
    {
        $user = $request->user();

        if (!$user->google_id) {
            return back()->with('warning', 'Akun ini belum terhubung dengan Google.');
        }

        // Bersihkan semua data terkait Google
        $user->google_id = null;
        $user->google_email = null;

        // Jika foto profilnya dari Google (URL https://lh3.googleusercontent.com)
        if ($user->profile_photo && str_contains($user->profile_photo, 'googleusercontent.com')) {
            $user->profile_photo = null;
        }

        $user->save();

        Session::forget('google_email_mismatch');
        return back()->with('success', 'Sambungan akun Google berhasil diputuskan.');
    }
}
