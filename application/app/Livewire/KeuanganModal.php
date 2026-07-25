<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Keuangan;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class KeuanganModal extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Properti Reaktif
    public $jenis; 
    public $filter = '';
    public $month = '';
    public $start_date = '';
    public $end_date = '';
    public $kategori_filter = '';
    public $search = '';

    // Reset halaman ke nomor 1 setiap kali filter berubah
    public function updated($propertyName)
    {
        $this->resetPage();
    }

    public function render()
    {
        // 1. Inisialisasi Query Dasar
        $query = Keuangan::with('kategori')
            ->where('user_id', Auth::id())
            ->where('jenis', $this->jenis);

        // 2. Logika Filter Berdasarkan Pilihan (Today, This Week, dll)
        if ($this->filter) {
            switch ($this->filter) {
                case 'today':
                    $query->whereDate('tanggal', Carbon::today());
                    break;
                case 'this_week':
                    $query->whereBetween('tanggal', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ]);
                    break;
                case 'this_month':
                    $query->whereMonth('tanggal', now()->month)
                          ->whereYear('tanggal', now()->year);
                    break;
                case 'monthly':
                    if ($this->month) {
                        $parsedMonth = Carbon::parse($this->month);
                        $query->whereMonth('tanggal', $parsedMonth->month)
                              ->whereYear('tanggal', $parsedMonth->year);
                    }
                    break;
            }
        }

        // 3. Filter Range Manual
        if ($this->start_date && $this->end_date) {
            $query->whereBetween('tanggal', [$this->start_date, $this->end_date]);
        }

        // 4. Filter Kategori
        if ($this->kategori_filter) {
            $query->whereHas('kategori', function ($q) {
                $q->where('nama_kategori', $this->kategori_filter);
            });
        }

        // 5. Pencarian (Search)
        if ($this->search) {
            $searchTerm = '%' . $this->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('keterangan', 'like', $searchTerm)
                  ->orWhere('tanggal', 'like', $searchTerm)
                  ->orWhereHas('kategori', function ($k) use ($searchTerm) {
                      $k->where('nama_kategori', 'like', $searchTerm);
                  });
            });
        }

        return view('livewire.keuangan-modal', [
            'items' => $query->orderBy('tanggal', 'desc')->paginate(10)
        ]);
    }
}