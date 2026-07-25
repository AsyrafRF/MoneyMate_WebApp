<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeviceSessionController extends Controller
{
    public function index()
    {
        $currentSessionId = session()->getId();
        $devices = \App\Models\UserDevice::where('user_id', auth()->id())
            ->orderBy('last_active_at', 'desc')
            ->get();

        return view('pengaturan.perangkat.index', compact('devices', 'currentSessionId'));
    }

    public function destroy($id)
    {
        $device = \App\Models\UserDevice::where('user_id', auth()->id())->findOrFail($id);

        // 1. Hapus sesi di tabel session Laravel agar pengguna di perangkat itu otomatis logout
        if ($device->session_id) {
            \DB::table('sessions')->where('id', $device->session_id)->delete();
        }

        // 2. Hapus data perangkat dari log tabel kita
        $device->delete();

        return back()->with('success', 'Perangkat berhasil dikeluarkan.');
    }
}
