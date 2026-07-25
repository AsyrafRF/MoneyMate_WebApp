<?php

namespace App\Http\Controllers;

use App\Mail\AccountSuspendedUserMail;
use App\Mail\AccountSuspendedAdminMail; 
use App\Mail\RedeemSuccessMail;
use App\Models\User;
use App\Models\RedeemCode;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('application.profile', compact('user'));
    }

    public function perbarui(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->name = $request->name;

        // Upload foto jika ada
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = 'profile_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profile_photos', $filename, 'public');
            $user->profile_photo = $path;
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'new_password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                // Harus ada huruf besar, kecil, angka, dan simbol
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'
            ],
        ]);

        $user = auth()->user();

        // 🚫 Cegah penggunaan password yang sama dengan saat ini
        if (Hash::check($request->new_password, $user->password)) {
            return redirect()->back()->with('alert', 'Kata sandi baru tidak boleh sama dengan yang sedang digunakan.');
        }

        // 🚫 Cegah penggunaan salah satu dari 3 password terakhir
        $recentPasswords = $user->passwordHistories()->latest()->take(3)->get();
        foreach ($recentPasswords as $oldPassword) {
            if (Hash::check($request->new_password, $oldPassword->password)) {
                return redirect()->back()->with('alert', 'Kata sandi baru tidak boleh sama dengan salah satu dari 3 kata sandi terakhir.');
            }
        }

        // ✅ Simpan password baru ke users table
        $user->update(['password' => Hash::make($request->new_password)]);

        // ✅ Simpan password lama ke tabel riwayat
        $user->passwordHistories()->create([
            'password' => $user->password,
        ]);

        // 🔄 Batasi hanya 3 riwayat terakhir — hapus yang lebih lama
        $excess = $user->passwordHistories()->latest()->skip(3)->take(PHP_INT_MAX)->get();
        foreach ($excess as $item) {
            $item->delete();
        }

        return back()->with('success', 'Kata sandi berhasil diperbarui.');
    }

    /**
     * Delete (suspend) the user's account temporarily.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            $request->validateWithBag('userDeletion', [
                'password' => ['required', 'current_password'],
            ]),
        ]);

        $user = $request->user();

        // 1. Kirim email ke User
        Mail::to($user->email)->queue(new AccountSuspendedUserMail($user));

        // 2. Kirim email ke Admin (Sesuaikan cara Anda mengambil email admin)
        $adminEmail = config('mail.admin_address', 'admin@example.com'); 
        Mail::to('moneymate.app.id@gmail.com')->queue(new AccountSuspendedAdminMail($user));

        // 3. Proses Logout pengguna
        Auth::logout();

        // 4. Soft delete user (karena sudah pakai trait SoftDeletes, data di DB tidak hilang)
        $user->delete();

        // 5. Hancurkan session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 6. Redirect ke halaman utama dengan pesan sukses
        return Redirect::to('/login')->with('status', 'Akun Anda telah ditangguhkan. Anda memiliki waktu beberapa hari untuk membatalkannya sebelum dihapus permanen.');
    }

    public function redeem(Request $request)
    {
        $request->validate([
            'code' => 'required|string|exists:redeem_codes,code',
        ]);

        $code = RedeemCode::where('code', $request->code)->first();

        // 1. Validasi Kode
        if (!$code->isValid()) {
            return back()->with('error', 'Kode redeem tidak valid, kadaluarsa, atau telah habis kuotanya.');
        }

        $user = $request->user();

        // 2. Cek apakah user sudah pernah pakai kode ini (Opsional, jika Anda ingin 1 user 1 kode)
        // Jika ingin satu user bisa redeem kode yang sama berkali-kali, hapus bagian ini.
        // Misal kita asumsikan 1 user hanya bisa pakai 1x per kode unik:
        if ($user->redeemedCodes()->where('redeem_code_id', $code->id)->exists()) {
            return back()->with('error', 'Anda sudah pernah menggunakan kode ini.');
        }

        // 3. Hitung tanggal baru
        $startDate = $user->subscription_until && $user->subscription_until->isFuture()
            ? $user->subscription_until // Jika masih premium, tambah dari tanggal habisnya
            : now(); // Jika tidak, mulai dari hari ini

        $newExpirationDate = $startDate->addDays($code->duration_days);

        // 4. Update User Premium dalam Transaction Database
        DB::transaction(function () use ($user, $newExpirationDate, $code) {
            
            // Update status user
            $user->update([
                'is_premium' => true,
                'subscription_until' => $newExpirationDate,
                'subscription_plan' => 'trial', // Atau plan lain sesuai kebutuhan
            ]);

            // Catat bahwa user ini sudah pakai kode ini
            $user->redeemedCodes()->attach($code->id);

            // Catat penggunaan kode (Relasi Many-to-Many, lihat langkah tambahan di bawah jika perlu)
            // Untuk sederhananya, kita cukup increment counter di tabel redeem_codes
            $code->increment('uses');
        });

        // Kirim Email
        Mail::to($user->email)->queue(
            new RedeemSuccessMail(
                $user,
                $newExpirationDate,
                $code->duration_days,
                'Trial'
            )
        );

        return redirect()->route('redeem.success')->with('success', "Selamat! Akun Anda kini Premium.");
    }
}
