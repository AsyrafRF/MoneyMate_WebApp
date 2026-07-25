<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentReminderMail;
use App\Models\PremiumTransaction;

class SendPaymentReminder extends Command
{
    protected $signature = 'send:payment-reminder';

    protected $description = 'Mengirim Email pengingat ke payment pending';

    public function handle()
    {
        // Cari transaksi 'pending' yang berumur antara 12 sampai 13 jam
        // Agar user tidak dikirimi email berkali-kali setiap jam
        $transactions = PremiumTransaction::where('status', 'pending')
            ->whereBetween('created_at', [now()->subHours(13), now()->subHours(12)])
            ->get();

        foreach ($transactions as $transaction) {
            Mail::to($transaction->user->email)->queue(new PaymentReminderMail($transaction));
        }

        $this->info($transactions->count() . " email pengingat telah dikirim.");
    }
}
