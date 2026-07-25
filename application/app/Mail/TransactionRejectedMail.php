<?php

namespace App\Mail;

use App\Models\PremiumTransaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TransactionRejectedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $transaction;

    public function __construct(PremiumTransaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function build()
    {
        return $this->subject('Pemberitahuan: Transaksi #' . $this->transaction->invoice_number . ' Telah Dibatalkan')
                    ->view('emails.transaction_rejected'); // Arahkan ke file blade
    }
}