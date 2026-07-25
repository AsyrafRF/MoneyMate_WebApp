<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        $userId = session('verification_user_id');

        if (!$userId) {
            return redirect('/register')
                ->with('error', 'Sesi verifikasi tidak ditemukan.');
        }

        $user = User::find($userId);

        if (!$user) {
            return redirect('/register')
                ->with('error', 'User tidak ditemukan.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect('/login')
                ->with('info', 'Email sudah terverifikasi.');
        }

        $result = $user->verifyEmailOtp($request->otp);

        if ($result === 'expired') {
            return back()->with('error', 'Kode OTP sudah kedaluwarsa.');
        }

        if ($result === 'locked') {
            return back()->with('error', 'Terlalu banyak percobaan. Silakan kirim ulang OTP.');
        }

        if ($result === 'invalid') {
            return back()->with('error', 'Kode OTP salah.');
        }

        // Valid
        $user->markEmailAsVerified();
        $user->clearEmailOtp();

        session()->forget('verification_user_id');

        return redirect('/login')
            ->with('success', 'Email berhasil diverifikasi. Silahkan Login!');
    }
}
