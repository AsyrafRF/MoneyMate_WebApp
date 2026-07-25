<?php

namespace App\Services\Notifications;

use App\Models\Anggaran;
use App\Models\Notifikasi;
use App\Events\NewNotificationEvent;
use App\Mail\NotifikasiEmail;
use App\Notifications\WebPushNotification;
use Illuminate\Support\Facades\Mail;

class BudgetWarningService
{
    protected string $currentMonth;

    public function __construct()
    {
        // Carbon instance sebaiknya di-string-kan sekali di constructor
        $this->currentMonth = now()->format('Y-m');
    }

    public function handle(): void
    {
        // 1. Menggunakan chunkById untuk efisiensi query pada data besar
        Anggaran::with(['user', 'kategori'])
            ->where('jumlah_anggaran', '>', 0)
            ->chunkById(100, function ($anggarans) {
                foreach ($anggarans as $anggaran) {
                    // Pastikan relasi user ada sebelum diproses untuk menghindari error null
                    if ($anggaran->user) {
                        $this->processAnggaran($anggaran);
                    }
                }
            });
    }

    private function processAnggaran(Anggaran $anggaran): void
    {
        $percentage = $this->calculatePercentage($anggaran);

        if ($percentage < 80) return;

        [$status, $summary] = $this->resolveStatus($percentage);

        if ($this->shouldSkip($anggaran, $percentage)) return;

        $notif = $this->createNotification($anggaran, $percentage, $status, $summary);

        $this->dispatch($anggaran->user, $notif);
    }

    private function calculatePercentage(Anggaran $anggaran): int
    {
        return (int) round(
            ($anggaran->nominal_yang_terpakai / $anggaran->jumlah_anggaran) * 100
        );
    }

    private function resolveStatus(int $percentage): array
    {
        if ($percentage >= 100) {
            return ['Over Budget', 'Anggaran Melewati Batas!'];
        }

        if ($percentage >= 90) {
            return ['Critical', 'Anggaran kritis!'];
        }

        return ['Warning', 'Anggaran hampir habis!'];
    }

    private function shouldSkip(Anggaran $anggaran, int $percentage): bool
    {
        // PENTING: Pastikan kolom JSON ini sudah diindeks di DB (Virtual Column Index) jika data masif
        $lastNotif = Notifikasi::where('user_id', $anggaran->user_id)
            ->where('type', 'Anggaran')
            ->where('meta->kategori_id', $anggaran->kategori_id)
            ->where('meta->month', $this->currentMonth)
            ->latest('id') // Menggunakan 'id' jauh lebih cepat daripada default 'created_at'
            ->first();

        if (!$lastNotif) return false;

        // Pastikan di-cast ke int untuk menghindari bug perbandingan string vs int
        $lastPercentage = (int) ($lastNotif->meta['percentage'] ?? 0);

        return $percentage <= $lastPercentage;
    }

    private function createNotification(
        Anggaran $anggaran,
        int $percentage,
        string $status,
        string $summary
    ): Notifikasi {
        return Notifikasi::create([
            'user_id' => $anggaran->user_id,
            'summary' => $summary,
            'content' => $this->buildContent($anggaran, $percentage, $status),
            'type' => 'Anggaran',
            'sender' => 'Sistem',
            'meta' => [
                'kategori_id' => $anggaran->kategori_id,
                'percentage'  => $percentage,
                'status'      => $status,
                'month'       => $this->currentMonth,
            ],
        ]);
    }

    private function buildContent(Anggaran $anggaran, int $percentage, string $status): string
    {
        // Menggunakan e() untuk keamanan XSS jika nama_kategori diinput oleh user
        $namaKategori = e($anggaran->kategori->nama_kategori ?? 'Umum');

        return "
            <p>
                Anggaran kategori <b>{$namaKategori}</b> telah terpakai <b>{$percentage}%</b>. Segera evaluasi pengeluaranmu!
            </p>
            <p>Status: <b>{$status}</b></p>
        ";
    }

    private function dispatch($user, Notifikasi $notif): void
    {
        event(new NewNotificationEvent($notif));

        $user->notify(new WebPushNotification($notif));

        Mail::to($user->email)->queue(new NotifikasiEmail($notif));
    }
}