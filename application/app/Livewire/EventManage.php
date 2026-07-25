<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Mail\EventAnnouncementMail;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class EventManage extends Component
{
    use WithFileUploads, WithPagination;

    // Form Properties
    public $eventId;
    public $title;
    public $description;
    public $image; // Menyimpan upload file banner sementara
    public $description_image; // Menyimpan upload file QR sementara
    public $existingImage; // Menyimpan path banner lama saat edit
    public $existingDescriptionImage; // Menyimpan path QR lama saat edit
    public $start_date;
    public $end_date;
    public $terms;
    public $is_active = true;

    // Control State Properties
    public $isOpen = false; // Status modal form terbuka/tutup
    public $search = '';

    protected $queryString = [
        'search' => ['except' => '']
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Menampilkan data event dengan fitur pencarian dan paginasi
        $events = Event::where('title', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.event-manage', [
            'events' => $events
        ])
        ->layout('layouts.admin')
        ->title('Kelola Event');
    }

    public function create()
    {
        $this->resetForm();
        $this->isOpen = true;
    }

    public function edit($id)
    {
        $this->resetForm();
        $event = Event::findOrFail($id);
        
        $this->eventId = $event->id;
        $this->title = $event->title;
        $this->description = $event->description;
        $this->existingImage = $event->image;
        $this->existingDescriptionImage = $event->description_image;
        $this->start_date = $event->start_date;
        $this->end_date = $event->end_date;
        $this->terms = $event->terms;
        $this->is_active = $event->is_active;

        $this->isOpen = true;
    }

    public function save()
    {
        // Validasi input form
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => $this->eventId ? 'nullable|image|max:2048' : 'required|image|max:2048', // Jika tambah data wajib isi banner
            'description_image' => 'nullable|image|max:2048',
            'start_date' => 'required|string',
            'end_date' => 'required|string',
            'terms' => 'nullable|string',
            'is_active' => 'boolean',
        ];

        $this->validate($rules);

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'terms' => $this->terms,
            'is_active' => $this->is_active,
        ];

        // Upload banner baru jika ada
        if ($this->image) {
            // Hapus file banner lama dari storage jika sedang mode edit
            if ($this->eventId && $this->existingImage && !str_contains($this->existingImage, 'http')) {
                Storage::disk('public')->delete($this->existingImage);
            }
            $data['image'] = $this->image->store('events/banners', 'public');
        }

        // Upload QR Code/detail image baru jika ada
        if ($this->description_image) {
            // Hapus file lama jika ada
            if ($this->eventId && $this->existingDescriptionImage && !str_contains($this->existingDescriptionImage, 'http')) {
                Storage::disk('public')->delete($this->existingDescriptionImage);
            }
            $data['description_image'] = $this->description_image->store('events/descriptions', 'public');
        }

        if ($this->eventId) {
            // Aksi Update data
            Event::find($this->eventId)->update($data);
            session()->flash('success', 'Event berhasil diperbarui!');
        } else {
            // Aksi Tambah data
            $event = Event::create($data); // Tampung hasil create ke dalam variabel $event

            // ==========================================
            // LOGIKA KIRIM EMAIL DI SINI
            // ==========================================
            
            // 1. Ambil semua email user terdaftar
            $users = User::select('email')->get();

            // 2. Lakukan perulangan untuk mengirim email
            foreach ($users as $user) {
                // Menggunakan 'queue' agar proses pengiriman berjalan di background dan tidak lemot
                Mail::to($user->email)->queue(new EventAnnouncementMail($event));
            }

            session()->flash('success', 'Event baru berhasil ditambahkan dan email pengumuman telah dijadwalkan!');
        }

        $this->closeModal();
    }

    public function delete($id)
    {
        $event = Event::findOrFail($id);

        // Hapus file gambar dari public storage sebelum menghapus row database
        if ($event->image && !str_contains($event->image, 'http')) {
            Storage::disk('public')->delete($event->image);
        }
        if ($event->description_image && !str_contains($event->description_image, 'http')) {
            Storage::disk('public')->delete($event->description_image);
        }

        $event->delete();
        session()->flash('success', 'Event berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        // Shortcut untuk mengubah status aktif/nonaktif event langsung di tabel list
        $event = Event::findOrFail($id);
        $event->update([
            'is_active' => !$event->is_active
        ]);
        session()->flash('success', 'Status keaktifan event berhasil diubah.');
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->eventId = null;
        $this->title = '';
        $this->description = '';
        $this->image = null;
        $this->description_image = null;
        $this->existingImage = null;
        $this->existingDescriptionImage = null;
        $this->start_date = '';
        $this->end_date = '';
        $this->terms = '';
        $this->is_active = true;
    }
}