<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event; 

class EventIndex extends Component
{
    // Menyimpan ID event yang sedang dipilih untuk detail
    public $selectedEventId = null;

    // Method untuk memilih event dan menampilkan detail
    public function showDetail($eventId)
    {
        $this->selectedEventId = $eventId;
    }

    // Method untuk kembali ke halaman daftar list
    public function backToList()
    {
        $this->reset('selectedEventId');
    }

    public function render()
    {
        // 2. Ambil data dari database MySQL yang statusnya aktif
        $events = Event::where('is_active', true)->get();

        // 3. Cari data detail langsung dari database jika ada ID yang dipilih
        $selectedEvent = null;
        if ($this->selectedEventId) {
            $selectedEvent = Event::find($this->selectedEventId);
        }

        return view('livewire.event-index', [
            'events' => $events,
            'selectedEvent' => $selectedEvent
        ])
        ->layout('layouts.app')
        ->title('Acara Berlangsung');
    }
}