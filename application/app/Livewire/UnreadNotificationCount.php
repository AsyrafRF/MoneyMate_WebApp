<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Notifikasi;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Route;

class UnreadNotificationCount extends Component
{
    public $unreadCount = 0;
    public $latestNotifications = [];
    public $isNotificationPage = false;

    public function mount()
    {
        $this->isNotificationPage = request()->routeIs('notifications.index');
        $this->updateCount();
        $this->loadLatestNotifications();
    }

    #[On('notification-updated')]
    public function updateCount()
    {
        if (auth()->check()) {
            $this->unreadCount = Notifikasi::forUser(auth()->id())
                ->unread()
                ->count();

            $this->loadLatestNotifications();
        } else {
            $this->unreadCount = 0;
            $this->latestNotifications = [];
        }
    }

    public function loadLatestNotifications()
    {
        $this->latestNotifications = Notifikasi::forUser(auth()->id())
            ->latest()
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.unread-notification-count');
    }
}