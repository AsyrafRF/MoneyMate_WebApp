<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailOtpVerification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    /**
     * Proses pendaftaran akun baru.
     */
    public function store(Request $request)
    {
        // 🔒 Jika user sudah login, tolak pendaftaran
        if (Auth::check()) {
            return redirect()->route('beranda')
                ->with('error', 'Anda masih dalam keadaan login. Silakan logout terlebih dahulu!');
        }

        try {
            // Validasi input
            $request->validate([
                'email' => 'required|string|email|max:255|unique:users',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                    // Harus ada huruf besar, kecil, angka, dan simbol
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'
                ],
            ], [
                // Pesan error kustom
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.max' => 'Email maksimal 255 karakter.',
                'password.required' => 'Password wajib diisi.',
                'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan simbol.',
                'password.min' => 'Password minimal 8 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'email.unique' => 'Email sudah terdaftar.',
            ]);

            // ✅ Simpan user baru
            $user = User::create([
                'name' => explode('@', $request->email)[0],
                'email' => $request->email,
                'password' => $request->password, // Langsung masukkan plain text, biarkan Model cast yang mengenkripsi
            ]);

            // ✅ Kirim email verifikasi (tanpa login otomatis)
            // Generate OTP 6 digit
            $user->generateEmailOtp();

            session([
                'verification_user_id' => $user->id,
                'otp_expires_at' => now()->addMinutes(10)->timestamp
            ]);

            // ✅ Redirect ke halaman verifikasi
            return redirect()->route('verification.notice')
                ->with('message', 'Kode OTP telah dikirim ke email kamu.');

        } catch (ValidationException $e) {
            return back()
                ->withInput()
                ->withErrors($e->validator)
                ->with('error', 'Pendaftaran gagal! Pastikan semua kolom diisi dengan benar dan email belum terdaftar.');
        }
    }
}
