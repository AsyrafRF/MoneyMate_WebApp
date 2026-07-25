<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminPaymentNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    // 1. Deklarasikan property agar bisa diakses di seluruh class
    public $transaction;

    /**
     * Create a new message instance.
     * 2. Terima variabel melalui constructor
     */
    public function __construct($transaction)
    {
        // 3. Masukkan data ke property
        $this->transaction = $transaction;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Admin Payment Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin_notification',
            // Variabel $transaction sudah otomatis tersedia di view 
            // karena property-nya bersifat public, tapi jika ingin spesifik:
            with: [
                'url' => route('admin.confirm.payment', $this->transaction->id),
                'transaction' => $this->transaction
            ],
        );
    }

    /**
     * Get the message attachments.
     */
    public function attachments(): array
    {
        return [
            Attachment::fromStorageDisk('public', $this->transaction->proof_path),
        ];
    }
}
