<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ConfirmablePasswordController extends Controller
{
    /**
     * Tampilkan halaman konfirmasi kata sandi.
     */
    public function show(): View
    {
        return view('auth.confirm-password');
    }

    /**
     * Proses konfirmasi kata sandi pengguna.
     */
    public function store(Request $request): RedirectResponse
    {
        if (! Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => 'Kata sandi yang kamu masukkan tidak sesuai. Silakan coba lagi.',
            ]);
        }

        // Simpan waktu konfirmasi password
        $request->session()->put('auth.password_confirmed_at', time());

        // Redirect dengan alert sukses
        return redirect()
            ->intended(route('profile.index'))
            ->with([
                'success' => 'Kata sandi berhasil dikonfirmasi! Anda dapat melanjutkan.',
                'warning' => 'Silahkan ulangi kembali untuk verifikasi!.'
            ]);
    }
}
