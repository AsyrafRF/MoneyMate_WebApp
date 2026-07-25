<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\UserDevice;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Jenssegers\Agent\Agent;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Proses login pengguna.
     */
    public function store(Request $request): Response
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 1. Cari user berdasarkan email
        $user = User::withTrashed()->where('email', $credentials['email'])->first();

        // 2. Validasi user dan password
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Login gagal! Email atau password salah.'], 401);
            }

            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Login gagal! Pastikan email dan password yang Anda masukkan sudah benar.');
        }

        // 3. Cek verifikasi email
        if (!$user->hasVerifiedEmail() && !$user->google_id) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Akun kamu belum diverifikasi.'], 403);
            }

            return redirect()->route('verification.notice')->with([
                'warning' => 'Akun kamu belum diverifikasi. Silakan cek email dan verifikasi dulu sebelum login.',
            ]);
        }

        // 4. Proses Login (Sesi Web)
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // 5. Ambil informasi perangkat
        $agent = new Agent();

        // 6. Simpan ke database user_devices
        UserDevice::create([
            'user_id'        => $user->id,
            'session_id'     => $request->session()->getId(),
            'device_name'    => $agent->device(),
            'platform'       => $agent->platform(),
            'browser'        => $agent->browser(),
            'ip_address'     => $request->ip(),
            'last_active_at' => now(),
        ]);

        // ==========================================
        // TAMBAHAN: CEK JIKA USER SEDANG DITANGGUHKAN
        // ==========================================
        if ($user->trashed()) {
            if ($request->expectsJson()) {
                // Response khusus untuk API jika akun ditangguhkan
                $deviceName = $agent->device() . ' - ' . $agent->platform() . ' - ' . $agent->browser();
                $token = $user->createToken($deviceName)->plainTextToken;

                return response()->json([
                    'message' => 'Akun Anda sedang ditangguhkan.',
                    'status' => 'suspended',
                    'token' => $token,
                    'user' => $user,
                ], 403); // Berikan status 403 Forbidden
            }

            // Jika akses via Web, langsung arahkan ke halaman khusus penangguhan
            return redirect('/account/suspended');
        }
        // ==========================================

        // 7. Kondisi Response Normal (API vs Web jika akun aktif)
        if ($request->expectsJson()) {
            $deviceName = $agent->device() . ' - ' . $agent->platform() . ' - ' . $agent->browser();
            $token = $user->createToken($deviceName)->plainTextToken;

            return response()->json([
                'message' => 'Login berhasil',
                'token' => $token,
                'user' => $user,
            ]);
        }

        // Response normal untuk Web biasa
        return redirect()->intended(route('dashboard.index'))
            ->with('success', 'Login berhasil! Selamat datang di halaman keuangan Anda.');
    }

    /**
     * Proses logout pengguna (Web & API).
     */
    public function destroy(Request $request): Response
    {
        $user = $request->user();
        $showFeedback = false;
        $lastUserId = null;

        if ($user) {
            $lastUserId = $user->id;

            // 1. Logika pengecekan feedback Anda
            if (!$user->hasSubmittedFeedback() && $user->hasCompletedTerms()) {
                $showFeedback = true;
            }

            // 2. JALUR API: Hapus token perangkat saat ini jika request datang dari API
            if ($request->expectsJson()) {
                $user->currentAccessToken()->delete();
                
                return response()->json([
                    'message' => 'Anda telah berhasil logout dari API.',
                    'show_feedback' => $showFeedback
                ]);
            }

            // 3. JALUR WEB: Hapus perangkat aktif dari tabel user_devices sebelum session dihancurkan
            $currentSessionId = $request->session()->getId();
            UserDevice::where('user_id', $user->id)
                ->where('session_id', $currentSessionId)
                ->delete();
        }

        // 4. Proses Logout Sesi Web Utama
        Auth::guard('web')->logout();

        // Hancurkan session lama dan buat token CSRF baru (Mencegah Session Fixation)
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 5. Flash kembali ID user ke session baru untuk kebutuhan form feedback
        if ($showFeedback && $lastUserId) {
            session(['last_user_id' => $lastUserId]);
        }

        return redirect('/')
            ->with('success', 'Anda telah berhasil logout. Sampai jumpa lagi!')
            ->with('show_feedback', $showFeedback);
    }

    protected function redirectTo()
    {
        return 'dashboard.index';
    }
}
