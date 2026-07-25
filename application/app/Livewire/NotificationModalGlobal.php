<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Notifikasi;
use Livewire\Attributes\On;

class NotificationModalGlobal extends Component
{
    public $selectedNotif = null;

    #[On('trigger-view-detail')]
    public function loadNotification($notifId)
    {
        $this->selectedNotif = Notifikasi::where('notif_id', $notifId)
            ->where('user_id', auth()->id())
            ->first();

        if ($this->selectedNotif && !$this->selectedNotif->is_read) {
            $this->selectedNotif->update(['is_read' => true]);
            $this->dispatch('notification-updated'); // Update badge lonceng
        }

        // Pemicu Bootstrap Modal via Javascript
        $this->dispatch('open-detail-modal');
    }

    public function render()
    {
        return view('livewire.notification-modal-global');
    }
}