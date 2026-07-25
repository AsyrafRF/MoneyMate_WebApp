<?php

namespace App\Mail;

use App\Models\PremiumTransaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserInvoiceNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $transaction;

    // Terima data transaksi saat dipanggil
    public function __construct(PremiumTransaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice Pembayaran Premium #' . $this->transaction->invoice_number,
        );
    }

    public function content(): Content
    {
        // Arahkan ke view email yang menginfokan pembayaran sukses
        return new Content(
            view: 'emails.user_invoice',
        );
    }

    // Bagian ini untuk generate PDF secara real-time dan melampirkannya
    public function attachments(): array
    {
        $data = [
            'transaction' => $this->transaction,
            'date' => now()->format('d/m/Y'),
        ];

        // Generate PDF menggunakan view yang sudah Anda miliki
        $pdf = Pdf::loadView('partials.pdf.premium.invoice_pdf', $data);

        return [
            Attachment::fromData(fn () => $pdf->output(), 'invoice_' . $this->transaction->invoice_number . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}