<?php

namespace App\Http\Controllers;

use App\Models\Feedback; 
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi input 
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'feature_score' => 'required|in:yes,neutral,no',
            'comment' => 'required|string|max:1000', 
        ]);

        // Ambil ID dari session yang telah diset saat logout
        $userId = session('last_user_id');

        if (!$userId) {
            return redirect('/login')->with('error', 'Sesi feedback habis.');
        }

        // Simpan dengan user_id
        Feedback::create([
            'user_id' => $userId,
            'rating'  => $validated['rating'],
            'feature_score'  => $validated['feature_score'],
            'comment' => strip_tags($validated['comment']),
        ]);

        // Hapus session agar tidak bisa submit berkali-kali
        session()->forget('last_user_id');

        // 4. Redirect dengan pesan sukses
        return redirect('/login')->with('success', 'Terima kasih atas masukannya! Masukan Anda telah tersimpan.');
    }
}