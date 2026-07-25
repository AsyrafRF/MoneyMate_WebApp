<?php
namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountSuspendedUserMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    // Definisikan properti agar bisa dibaca di dalam file blade
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the message envelope (Subjek Email).
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pemberitahuan: Akun Anda Telah Ditangguhkan',
        );
    }

    /**
     * Get the message content definition (Lokasi file Blade).
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.account_suspended_user',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}