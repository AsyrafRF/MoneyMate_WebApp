<?php

namespace App\Mail;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventAnnouncementMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $event;

    // Mengirimkan data event ke dalam email
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pengumuman & Pemberitahuan: ' . $this->event->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.event-announcement', // File view blade template email
        );
    }

    public function attachments(): array
    {
        return [];
    }
}