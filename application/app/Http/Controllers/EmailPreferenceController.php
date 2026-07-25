<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class EmailPreferenceController extends Controller
{
    /**
     * Memperbarui preferensi email ke DB Lokal dan API Brevo.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Evaluasi input checkbox (jika dicentang nilainya true, jika tidak nilainya false)
        $isSubscribed = $request->has('is_subscribed');

        // 1. Update ke Database Lokal MoneyMate
        $user->update([
            'is_subscribed' => $isSubscribed
        ]);

        // 2. Sinkronisasi dengan API Brevo v3
        // Brevo menggunakan parameter 'emailBlacklisted'. Jika kita ingin BERLANGGANAN, blacklisted harus FALSE.
        $isBlacklisted = !$isSubscribed;

        $response = Http::withHeaders([
            'api-key' => env('BREVO_API_KEY'),
            'Content-Type' => 'application/json',
            'accept' => 'application/json',
        ])->put("https://api.brevo.com/v3/contacts/" . urlencode($user->email), [
            'emailBlacklisted' => $isBlacklisted,
        ]);

        // Jika user belum terdaftar sama sekali di kontak Brevo, API PUT akan return 404.
        // Kita bisa buat handling otomatis untuk mendaftarkannya (opsional tapi disarankan)
        if ($response->status() == 404) {
            Http::withHeaders([
                'api-key' => env('BREVO_API_KEY'),
                'Content-Type' => 'application/json',
                'accept' => 'application/json',
            ])->post("https://api.brevo.com/v3/contacts", [
                'email' => $user->email,
                'emailBlacklisted' => $isBlacklisted,
            ]);
        }

        if ($response->successful() || $response->status() == 201 || $response->status() == 204) {
            return redirect()->back()->with('success', 'Preferensi email Anda berhasil diperbarui!');
        }

        return redirect()->back()->with('error', 'Gagal menyinkronkan data dengan server email.');
    }
}