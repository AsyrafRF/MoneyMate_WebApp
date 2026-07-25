<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\TransactionRejectedMail;
use App\Models\PremiumTransaction;
use Carbon\Carbon;

class CancelExpiredTransactions extends Command
{
    // Nama command yang akan dipanggil
    protected $signature = 'premium:cancel-expired';

    // Deskripsi command
    protected $description = 'Membatalkan transaksi premium yang tidak diupload buktinya dalam 24 jam';

    public function handle()
    {
        // Cari transaksi 'pending' yang dibuat lebih dari 24 jam yang lalu
        // Eager load relasi user untuk efisiensi
        $expiredTransactions = PremiumTransaction::where('status', 'pending')
            ->where('created_at', '<', Carbon::now()->subHours(24))
            ->with('user') 
            ->get();

        $count = $expiredTransactions->count();

        foreach ($expiredTransactions as $transaction) {
            $transaction->update(['status' => 'rejected']);
            
            // Pastikan user ada (untuk menghindari error jika user dihapus)
            if ($transaction->user) {
                // Sangat disarankan menggunakan queue() agar tidak lambat
                Mail::to($transaction->user->email)->queue(new TransactionRejectedMail($transaction));
            }
        }

        $this->info("Berhasil membatalkan {$count} transaksi yang kadaluarsa.");
    }
}