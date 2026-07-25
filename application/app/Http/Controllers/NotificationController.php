<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NotificationController extends Controller
{
    use AuthorizesRequests;
    /**
     * Menampilkan halaman notifikasi (versi Blade).
     */
    public function index(Request $request)
    {
        $query = Notifikasi::forUser(auth()->id());

        // FILTER BULAN
        if ($request->filled('month')) {
            [$year, $month] = explode('-', request('month'));

            $notifications = $query
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month);
        }

        // FILTER TAHUN
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        $notifications = $query
            ->latest()
            ->get()
            ->groupBy(function ($notif) {
                return $notif->created_at->translatedFormat('F Y');
            });

        return view('application.notifications', compact('notifications'));
    }

    public function destroy($id)
    {
        $notif = Notifikasi::forUser(auth()->id())->findOrFail($id);
        $notif->delete();

        return response()->json(['status' => 'success']);
    }
}