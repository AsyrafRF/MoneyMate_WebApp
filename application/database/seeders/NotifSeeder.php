<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\Notifikasi;
use App\Models\User;
use App\Notifications\WebPushNotification;
use App\Mail\NotifikasiEmail;
use App\Events\NewNotificationEvent;

use Carbon\Carbon;

class NotifSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        // Ambil satu user random sebagai object
        $user = User::inRandomOrder()->first();

        if (!$user) return; // jaga-jaga jika tabel user kosong

        // Buat notifikasi
        $notif = Notifikasi::create([
            'user_id' => $user->id,
            'notif_id' => Str::uuid(),
            'type' => 'app',
            'summary' => 'Ini notif dari seeder data dummy!',
            'content' => '<p>Halo! Silakan klik <a href="/keuangan" class="text-primary">di sini</a> untuk menyelesaikan pencatatan Anda.</p>
                        <img src="https://cdn-icons-png.flaticon.com/512/12165/12165125.png" alt="Reminder" class="img-fluid rounded mt-2" style="max-width: 40px;">',
            'sender' => 'Sistem',
            'resent_at' => now(),
        ]);
    }
}
