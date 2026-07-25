<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifikasiEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $notif;

    public function __construct($notif)
    {
        // Jika array, convert ke object sederhana
        $this->notif = (object) $notif;
    }

    public function build()
    {
        return $this->subject('Notifikasi: ' . $this->notif->summary)
                    ->view('emails.notifikasi')
                    ->with([
                        'notif' => $this->notif,
                    ]);
    }
}
