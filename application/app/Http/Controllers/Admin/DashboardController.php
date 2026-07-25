<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Keuangan;
use App\Models\PremiumTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $completedUsers = User::whereNotNull('email_verified_at')
            ->whereHas('agreements', function ($q) {
                $q->whereIn('document_type', ['terms', 'agreement', 'privacy'])
                ->whereNotNull('completed_at');
            }, '=', 3);
            
        // 1. Ringkasan Pengguna
        $stats = [
            'total_users' => (clone $completedUsers)->count(),

            'premium_users' => (clone $completedUsers)
                ->where('is_premium', true)
                ->count(),

            'active_users' => (clone $completedUsers)
                ->activeLastDays(7)
                ->count(),

            'pending_payments' => PremiumTransaction::where('status', 'pending')->count(),
        ];

        // 2. Data Grafik: Pertumbuhan User (7 Hari Terakhir)
        $userGrowth = (clone $completedUsers)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->get();

        // 3. Data Grafik: Revenue dari Transaksi Premium (Selesai)
        $revenueData = PremiumTransaction::where('status', 'success')
            ->select(DB::raw('DATE(updated_at) as date'), DB::raw('SUM(total_amount) as total'))
            ->groupBy('date')
            ->get();

        // 4. Transaksi Terbaru untuk Tabel
        $recentTransactions = PremiumTransaction::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'userGrowth', 'revenueData', 'recentTransactions'));
    }

    public function getUsersForModal(Request $request)
    {
        $type = $request->query('type');
        
        // Base query yang sama dengan data dashboard utama Anda
        $query = User::whereNotNull('email_verified_at')
            ->whereHas('agreements', function ($q) {
                $q->whereIn('document_type', ['terms', 'agreement', 'privacy'])
                ->whereNotNull('completed_at');
            }, '=', 3);

        // Filter berdasarkan tipe card yang diklik
        switch ($type) {
            case 'total_users':
                // Tidak perlu filter tambahan
                break;
            case 'premium_users':
                $query->where('is_premium', true);
                break;
            case 'active_users':
                $query->activeLastDays(7);
                break;
            default:
                return response()->json(['error' => 'Tipe tidak valid'], 400);
        }

        $users = $query->select('id', 'name', 'email', 'profile_photo')->get();

        // Map untuk menyertakan photo_url dari accessor model User
        $data = $users->map(function($user) {
            return [
                'name' => $user->name,
                'email' => $user->email,
                'photo_url' => $user->photo_url // memanggil accessor photoUrl
            ];
        });

        return response()->json($data);
    }
}