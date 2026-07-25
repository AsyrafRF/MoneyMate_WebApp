<?php

namespace App\Http\Controllers;

use App\Models\UserAgreement;
use App\Models\UserProfile;
use App\Models\Keuangan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TermsController extends Controller
{
    const DOCUMENT_VERSION = '1.0';

    // ── STEP 1: Simpan persetujuan ──
    public function acceptTerms(Request $request)
    {
        $request->validate([
            'agreement_check' => 'required|accepted',
        ], [
            'agreement_check.required' => 'Anda harus mencentang pernyataan persetujuan.',
            'agreement_check.accepted' => 'Anda harus mencentang pernyataan persetujuan.',
        ]);

        $user = auth()->user();
        $now = now();
        $documents = ['terms', 'agreement', 'privacy'];

        $rows = collect($documents)->map(fn ($type) => [
            'user_id'          => $user->id,
            'document_type'    => $type,
            'document_version' => self::DOCUMENT_VERSION,
            'accepted_at'      => $now,
            'ip_address'       => $request->ip(),
            'user_agent'       => $request->userAgent(),
            'completed_at' => now(),
            'created_at'       => $now,
            'updated_at'       => $now,
        ])->toArray();

        UserAgreement::upsert($rows, ['user_id', 'document_type', 'document_version']);

        return redirect()->route('dashboard.index')->with('success', 'Selamat datang di MoneyMate! Akun Anda siap digunakan.');
    }
}