<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDevice;
use Jenssegers\Agent\Agent;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class GoogleController extends Controller
{
    /**
     * Helper: Isi field user jika kosong.
     */
    protected function fillIfEmpty($user, $field, $value)
    {
        if (empty($user->$field)) {
            $user->$field = $value;
        }
    }

    /**
     * Redirect ke Google OAuth.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Callback untuk login & sambungkan akun Google.
     */
    public function handleGoogleCallback(Request $request): Response
    {
        // 1. Cek & Set status progress login Google
        if (session('google_login_in_progress')) {
            return redirect()->back();
        }
        session(['google_login_in_progress' => true]);

        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $googleId     = $googleUser->getId();
            $googleName   = $googleUser->getName();
            $googleEmail  = $googleUser->getEmail();
            $googleAvatar = $googleUser->getAvatar();

            /**
             * ========================================================
             * CASE 1: USER SUDAH LOGIN → SAMBUNGKAN AKUN GOOGLE
             * ========================================================
             */
            if (Auth::check()) {
                $user = Auth::user();

                // Cegah duplikasi Google ID ke akun lain
                $alreadyLinked = User::where('google_id', $googleId)
                    ->where('id', '!=', $user->id)
                    ->exists();

                if ($alreadyLinked) {
                    session()->forget('google_login_in_progress'); 
                    return redirect()->route('profile.index')
                        ->with('warning', 'Akun Google ini sudah terhubung dengan pengguna lain.');
                }

                $this->fillIfEmpty($user, 'google_id', $googleId);
                $this->fillIfEmpty($user, 'google_email', $googleEmail);
                $this->fillIfEmpty($user, 'profile_photo', $googleAvatar);
                $user->save();

                if ($user->email !== $googleEmail) {
                    Session::flash('google_email_mismatch', [
                        'google_email' => $googleEmail,
                        'user_email' => $user->email,
                    ]);
                }

                session()->forget('google_login_in_progress'); 
                return redirect()->route('profile.index')
                    ->with('success', 'Akun Google berhasil disambungkan!');
            }

            /**
             * ========================================================
             * CASE 2: USER BELUM LOGIN → LOGIN / REGISTER VIA GOOGLE
             * ========================================================
             */
            $user = User::withTrashed()->where(function ($query) use ($googleEmail) {
                $query->where('email', $googleEmail)
                    ->orWhere('google_email', $googleEmail);
            })->first();

            $emailDifferent = false;

            if (!$user) {
                $user = User::create([
                    'name'              => $googleName,
                    'email'             => $googleEmail,
                    'google_email'      => $googleEmail,
                    'google_id'         => $googleId,
                    'profile_photo'     => $googleAvatar,
                    'email_verified_at' => now(),
                    'password'          => bcrypt(str()->random(16)),
                ]);
            } else {
                $this->fillIfEmpty($user, 'google_id', $googleId);
                $this->fillIfEmpty($user, 'google_email', $googleEmail);
                $this->fillIfEmpty($user, 'profile_photo', $googleAvatar);

                if (is_null($user->email_verified_at)) {
                    $user->email_verified_at = now();
                }

                if ($user->google_email !== $user->email) {
                    $emailDifferent = true;
                }

                $user->save();
            }

            $agent = new Agent();
            $deviceName = $agent->device() . ' - ' . $agent->platform() . ' - ' . $agent->browser();

            // 🔐 PROSES LOGIN (API vs WEB)
            if ($request->expectsJson()) {
                $token = $user->createToken($deviceName)->plainTextToken;
                session()->forget('google_login_in_progress');

                // Interseptasi Status Suspended untuk Jalur API
                if ($user->trashed()) {
                    return response()->json([
                        'message' => 'Akun Anda sedang ditangguhkan.',
                        'status'  => 'suspended',
                        'token'   => $token,
                        'user'    => $user,
                    ], 403);
                }

                return response()->json([
                    'message' => 'Login berhasil',
                    'token'   => $token,
                    'user'    => $user,
                ]);
            }

            // Jalur Web: Buat Sesi Web Browser
            Auth::login($user);
            $request->session()->regenerate();

            // Catat info perangkat
            UserDevice::create([
                'user_id'        => $user->id,
                'session_id'     => $request->session()->getId(),
                'device_name'    => $agent->device(),
                'platform'       => $agent->platform(),
                'browser'        => $agent->browser(),
                'ip_address'     => $request->ip(),
                'last_active_at' => now(),
            ]);

            session()->forget('google_login_in_progress');

            // ========================================================
            // INTERSEPTASI STATUS SUSPENDED UNTUK JALUR WEB
            // ========================================================
            if ($user->trashed()) {
                return redirect('/account/suspended');
            }
            // ========================================================

            // Siapkan redirect utama jika akun aktif normal
            $redirect = redirect()->intended('/dashboard')
                ->with('success', '✅ Berhasil masuk menggunakan akun Google!');

            if ($emailDifferent) {
                $redirect->with('warning', '⚠️ Email Google Anda berbeda dengan email utama. Akun telah dihubungkan dengan keduanya.');
            }

            return $redirect;

        } catch (\Exception $e) {
            session()->forget('google_login_in_progress');

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Gagal login via Google: ' . $e->getMessage()], 422);
            }

            return redirect()->route('login')
                ->with('error', 'Gagal menyambungkan akun Google: ' . $e->getMessage());
        }
    }
}
