<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Keuangan;
use App\Models\Anggaran;
use App\Models\Notifikasi;
use App\Events\NewNotificationEvent;
use App\Mail\NotifikasiEmail;
use Carbon\Carbon;

class GenerateDailyReminder extends Command
{
    protected $signature = 'notifications:reminder';
    protected $description = 'Generate daily notifications for financial reminders';

    public function handle()
    {
        $this->reminderKeuanganHarian();

        $this->info("Notifikasi reminder otomatis berhasil dibuat.");
    }

    /**
     * 1️⃣ Pengingat keuangan jika belum input hari ini
     */
    private function reminderKeuanganHarian()
    {
        $today = Carbon::today();

        User::chunk(100, function ($users) use ($today) {
            foreach ($users as $user) {

                // Sudah input hari ini?
                $hasInput = Keuangan::where('user_id', $user->id)
                    ->whereDate('tanggal', $today)
                    ->exists();

                if ($hasInput) continue;

                // Sudah pernah dikirimi hari ini?
                $alreadySent = Notifikasi::where('user_id', $user->id)
                    ->where('type', 'reminder')
                    ->whereDate('created_at', $today)
                    ->exists();

                if ($alreadySent) continue;

                $notif = Notifikasi::create([
                    'user_id' => $user->id,
                    'summary' => 'Kamu belum menginput data pencatatan keuangan nih! Ayo segera selesaikan.',
                    'content' => '
                        <div style="font-family: Arial, sans-serif; line-height:1.6;">
                        <img src="https://cdn-icons-png.flaticon.com/512/12165/12165125.png" 
                            alt="Reminder" 
                            style="max-width:40px; margin:10px auto; display:block;">

                            <p>Halo <strong>' . $user->name . '</strong> 👋</p>
                            <p>Kami belum melihat adanya pencatatan keuangan untuk hari ini.</p>
                            <p style="color: #006b8f;">
                                Yuk luangkan waktu kurang dari 1 menit untuk memperbarui catatanmu hari ini.
                            </p>
                            <p style="margin: 20px 0; text-align: center;">
                                <a href="' . route('keuangan.index') . '" 
                                style="background: linear-gradient(135deg, #74b9ff, #0984e3); color: #fff; padding: 10px 16px;
                                        text-decoration: none; border-radius: 6px; display: inline-block;">
                                    Catat Sekarang
                                </a>
                            </p>
                            <p style="font-size: 13px; color: #777;">
                                Konsistensi kecil setiap hari akan berdampak besar pada kondisi keuanganmu 💡
                            </p>
                        </div>
                    ',
                    'type' => 'reminder',
                    'sender' => 'MoneyMate ID',
                ]);

                // Broadcast realtime
                event(new NewNotificationEvent($notif));

                // Push notification (browser)
                $user->notify(new \App\Notifications\WebPushNotification($notif));

                // Email
                Mail::to($user->email)->queue(new NotifikasiEmail($notif));
            }
        });

        $this->info('Daily finance reminder sent.');

    }
}
