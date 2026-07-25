<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Notifikasi;
use Carbon\Carbon;

class NotificationList extends Component
{
    // ================= PROPERTIES =================
    // Hapus $notifications dari sini! Biarkan query berjalan di render().
    
    public $monthFilter = '';
    public $selectedNotif = null;
    public $newNotifId = null;

    // ================= LIFECYCLE & LISTENERS =================

    public function mount()
    {
        // Ambil filter bulan dari URL query string jika ada
        $this->monthFilter = request('month', ''); 
    }

    public function getListeners()
    {
        $userId = auth()->id();
        if (!$userId) {
            return [];
        }

        return [
            // Listener untuk Laravel Echo Realtime
            "echo-private:notifications.{$userId},.new-notification" => 'handleNewNotification',          
            
            // Re-render komponen jika ada update dari luar (misal: badge lonceng)
            'notification-updated' => '$refresh', 

            // ADD THIS: Listener baru untuk menangkap klik dari dropdown lonceng
            'trigger-view-detail' => 'viewDetailFromDropdown',
        ];
    }

    // ================= REALTIME HANDLER =================

    public function handleNewNotification($event)
    {
        // Set ID notif baru untuk animasi CSS (class .new-notif)
        $this->newNotifId = $event['notification']['notif_id'] 
                         ?? $event['notification']['id'] 
                         ?? null;

        // Hapus class animasi setelah 2 detik
        $this->js("setTimeout(() => { \$wire.set('newNotifId', null) }, 2000)");
        
        // Tidak perlu panggil loadNotifications() lagi, 
        // karena perubahan property di atas akan memicu re-render 
        // dan method render() akan mengambil data terbaru dari DB.
    }

    // ================= ACTIONS =================

    public function viewDetail($notifId)
    {
        // Cari notif milik user yang login (mencegah manipulasi ID)
        $notif = Notifikasi::where('notif_id', $notifId)
                    ->where('user_id', auth()->id())
                    ->firstOrFail();

        // Tandai dibaca jika belum
        if (!$notif->is_read) {
            $notif->update(['is_read' => true]);
            
            // Trigger event global agar badge lonceng di navbar ikut update
            $this->dispatch('notification-updated');
        }

        $this->selectedNotif = $notif;

        // Trigger JS untuk buka modal Bootstrap
        $this->dispatch('open-detail-modal');
    }

    public function viewDetailFromDropdown($notifId)
    {
        // Cukup panggil method viewDetail yang sudah Anda buat sebelumnya
        $this->viewDetail($notifId);
    }

    public function deleteNotif($notifId)
    {
        $notif = Notifikasi::where('notif_id', $notifId)
                    ->where('user_id', auth()->id())
                    ->firstOrFail();

        $notif->delete();

        // Reset selected & tutup modal
        $this->selectedNotif = null;
        $this->dispatch('close-detail-modal');

        // Update badge lonceng di navbar
        $this->dispatch('notification-updated');

        // Flash message (akan ditangkap oleh popup layout app.blade.php)
        session()->flash('success', 'Notifikasi berhasil dihapus');
    }

    public function applyFilter()
    {
        // Karena kita menggunakan wire:model.live="monthFilter" di view,
        // list akan otomatis ter-filter saat user memilih bulan.
        // Method ini hanya sebagai formalitas penerimaan form submit.
    }

    public function resetFilter()
    {
        $this->monthFilter = '';
    }

    // ================= RENDER =================

    public function render()
    {
        // Query selalu dijalankan ulang saat render, menjamin data selalu terbaru
        // dan mencegah error hydrate Eloquent Collection
        $query = Notifikasi::where('user_id', auth()->id())->latest();

        // Filter berdasarkan bulan jika monthFilter terisi
        if (!empty($this->monthFilter)) {
            try {
                $date = Carbon::createFromFormat('Y-m', $this->monthFilter);
                $query->whereYear('created_at', $date->year)
                      ->whereMonth('created_at', $date->month);
            } catch (\Exception $e) {
                // Abaikan filter jika format tidak valid
            }
        }

        // Group by Nama Bulan + Tahun (F Y)
        $notifications = $query->get()
            ->groupBy(fn($item) => $item->created_at->translatedFormat('F Y'));

        // Kirim langsung ke view via compact, bukan disimpan di property
        return view('livewire.notification-list', compact('notifications'));
    }
}