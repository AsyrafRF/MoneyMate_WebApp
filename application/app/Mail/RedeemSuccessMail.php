<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RedeemSuccessMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $expirationDate;
    public $duration;
    public $plan;

    public function __construct($user, $expirationDate, $duration, $plan)
    {
        $this->user = $user;
        $this->expirationDate = $expirationDate;
        $this->duration = $duration;
        $this->plan = $plan;
    }

    public function build()
    {
        return $this
            ->subject('Premium Trial Berhasil Diaktifkan')
            ->view('emails.redeem-success');
    }
}