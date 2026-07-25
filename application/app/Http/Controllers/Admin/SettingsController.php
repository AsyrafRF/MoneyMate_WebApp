<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function editSettings()
    {
        $settings = Setting::pluck('value', 'key'); 
        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:50',
            'bank_account_number' => 'required|string|numeric|digits_between:8,20',
            'bank_account_name' => 'required|string|max:100',
            'wa_number' => 'required|string|min:10|max:15|regex:/^[0-9]+$/',
            'payment_qr' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', // Maks 2MB
        ]);

        // Update Rekening
        Setting::updateOrCreate(['key' => 'bank_name'], ['value' => $request->bank_name]);
        Setting::updateOrCreate(['key' => 'bank_account_number'], ['value' => $request->bank_account_number]);
        Setting::updateOrCreate(['key' => 'bank_account_name'], ['value' => $request->bank_account_name]);
        Setting::updateOrCreate(['key' => 'wa_number'], ['value' => $request->wa_number]);

        // Update QR Code
        if ($request->hasFile('payment_qr')) {
            $path = $request->file('payment_qr')->store('public/settings');
            // Simpan path ke database
            Setting::updateOrCreate(['key' => 'payment_qr'], ['value' => Storage::url($path)]);
        }

        return back()->with('success', 'Pengaturan berhasil diperbarui!');
    }
}