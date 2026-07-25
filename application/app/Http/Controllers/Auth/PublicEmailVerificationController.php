<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailOtpVerification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PublicEmailVerificationController extends Controller
{
    public function resend()
    {
        $userId = session('verification_user_id');

        if (!$userId) {
            return redirect('/register')
                ->with('error', 'Sesi tidak valid.');
        }

        $user = User::find($userId);

        if (!$user || $user->hasVerifiedEmail()) {
            return redirect('/login');
        }

        $user->generateEmailOtp();

        session([
            'otp_expires_at' => now()->addMinutes(10)->timestamp
        ]);

        return back()->with('message', 'Kode OTP baru telah dikirim.');
    }
}
