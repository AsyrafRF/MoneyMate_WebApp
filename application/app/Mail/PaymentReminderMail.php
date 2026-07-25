<?php

namespace App\Mail;

use App\Models\PremiumTransaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentReminderMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $transaction;

    public function __construct(PremiumTransaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pengingat Pembayaran Premium',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment_reminder',
            with: [
                'transaction' => $this->transaction,
                'url' => route('premium.upload', $this->transaction->id),
            ],
        );
    }
}
