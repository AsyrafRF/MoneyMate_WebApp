<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ChangePwConfirmController extends Controller
{
    /**
     * Tampilkan halaman konfirmasi kata sandi.
     */
    public function show(): View
    {
        return view('auth.confirm-password-change');
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

        $request->session()->put('auth.password_confirmed_at', time());

        // Tandai agar modal password dibuka setelah kembali
        return redirect()
            ->intended(route('profile.index'))
            ->with('showPasswordModal', true)
            ->with('confirm', 'Kata sandi berhasil dikonfirmasi. Silakan ubah password Anda.');
    }
}
