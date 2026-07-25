<?php

namespace App\Services\Notifications;

use App\Models\Anggaran;
use App\Models\Notifikasi;
use App\Models\User;
use App\Events\NewNotificationEvent;
use App\Mail\NotifikasiEmail;
use Illuminate\Support\Facades\Mail;

class BudgetWarningDigestService
{
    protected string $currentMonth;
    protected array $digests = [];

    public function __construct()
    {
        $this->currentMonth = now()->format('Y-m');
    }

    public function handle(): void
    {
        $anggarans = Anggaran::with(['user', 'kategori'])
            ->where('jumlah_anggaran', '>', 0)
            ->get();

        foreach ($anggarans as $anggaran) {
            $this->collect($anggaran);
        }

        $this->send();
    }

    // 🔄 Kumpulkan Data
    private function collect(Anggaran $anggaran): void
    {
        $percentage = $this->calculatePercentage($anggaran);

        if ($percentage < 80) return;

        [$status] = $this->resolveStatus($percentage);

        $this->digests[$anggaran->user_id][] = [
            'kategori' => $anggaran->kategori->nama_kategori,
            'percentage' => $percentage,
            'status' => $status,
            'kategori_id' => $anggaran->kategori_id,
        ];
    }

    // 📤 Kirim Digest (1 notif / user)
    private function send(): void
    {
        foreach ($this->digests as $userId => $items) {

            if ($this->alreadySent($userId)) continue;

            $user = User::find($userId);
            if (!$user) continue;

            $notif = Notifikasi::create([
                'user_id' => $userId,
                'summary' => 'Ringkasan peringatan anggaran',
                'content' => $this->buildContent($items),
                'type' => 'Anggaran-Ringkasan',
                'sender' => 'Sistem',
                'meta' => [
                    'month' => $this->currentMonth,
                ],
            ]);

            event(new NewNotificationEvent($notif));

            // ✅ sekarang benar
            $user->notify(new \App\Notifications\WebPushNotification($notif));

            Mail::to($user->email)->queue(new NotifikasiEmail($notif));
        }
    }

    // 🛑 Anti-spam Digest (1x / bulan atau hari)
    private function alreadySent(int $userId): bool
    {
        return Notifikasi::where('user_id', $userId)
            ->where('type', 'Anggaran-Ringkasan')
            ->where('meta->month', $this->currentMonth)
            ->exists();
    }

    // 🧩 Helper (dipakai ulang)
    private function calculatePercentage(Anggaran $anggaran): int
    {
        return (int) round(
            ($anggaran->nominal_yang_terpakai / $anggaran->jumlah_anggaran) * 100
        );
    }

    private function resolveStatus(int $percentage): array
    {
        if ($percentage >= 100) return ['Over Budget'];
        if ($percentage >= 90) return ['Critical'];
        return ['Warning'];
    }

    // 📝 Content Digest
    private function buildContent(array $items): string
    {
        $bulanIni = now()->translatedFormat('F Y');

        $html = "<p><b>Ringkasan peringatan anggaran bulan {$bulanIni}</b></p>";
        $html .= '<ul>';

        foreach ($items as $item) {
            $html .= "
                <li>
                    <b>{$item['kategori']}</b> :
                    {$item['percentage']}% ({$item['status']})
                </li>
            ";
        }

        return $html . '</ul>';
    }
}