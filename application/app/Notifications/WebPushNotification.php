<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;

class WebPushNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $summary;
    protected $content;

    public function __construct($notif)
    {
        $this->summary = $notif->summary;
        $this->content = $notif->content;
    }

    public function via($notifiable)
    {
        return ['webpush']; // opsional, kalau mau email juga
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title($this->summary)
            ->body(strip_tags($this->content))
            ->action('Buka Aplikasi', 'open_app');
    }

    public function toArray($notifiable)
    {
        return [
            'summary' => $this->summary,
            'content' => $this->content,
        ];
    }
}
